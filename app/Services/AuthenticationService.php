<?php

namespace App\Services;

use App\Dtos\LoginDto;
use App\Dtos\RegisterDto;
use App\Events\RequestPasswordReset;
use App\Models\User;
use App\Repositories\PasswordResetRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AuthenticationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly RoleRepository $roleRepository,
        private readonly PasswordResetRepository $passwordResetRepository
    ) {
    }

    /**
     * @param RegisterDto $registerDto
     * @return array<string, mixed>
     * @throws BadRequestException
     */
    public function register(RegisterDto $registerDto): array
    {
        /**
         * @var User|null $user
         */
        $user = $this->userRepository->findByEmail($registerDto->email);

        if ($user) {
            throw new BadRequestException("User already exists");
        }

        $user = $this->userRepository->create(array_merge($registerDto->toArray(), [
            'password' => Hash::make($registerDto->password)
        ]));

        return [
            'token' => $this->generateAuthToken($user),
            'user' => $user->toArray()
        ];
    }

    /**
     * @param LoginDto $loginDto
     * @return array<string, mixed>
     * @throws BadRequestException
     */
    public function login(LoginDto $loginDto): array
    {
        /**
         * @var User|null $user
         */
        $user = $this->userRepository->findByEmail($loginDto->email);

        if (!$user || !Hash::check($loginDto->password, $user->password)) {
            throw new BadRequestException("Invalid credentials");
        }

        return [
            'token' => $this->generateAuthToken($user),
            'user' => $user->toArray()
        ];
    }

    /**
     * @param RegisterDto $registerDto
     * @return array<string, mixed>
     * @throws BadRequestException
     */
    public function adminRegister(RegisterDto $registerDto): array
    {
        /**
         * @var User|null $user
         */
        $user = $this->userRepository->findByEmail($registerDto->email);

        if ($user) {
            throw new BadRequestException("User already exists");
        }

        /**
         * @var User $user
         */
        $user = $this->userRepository->create($registerDto->toArray());

        /**
         * @var Role|null $role
         */
        $role = $this->roleRepository->findByName("admin");

        if (!$role) {
            throw new BadRequestException("Admin role not found");
        }

        /**
         * @var UserRole
         */
        $user->roles()->create([
            "role_id" => $role->id
        ]);

        return [
            'token' => $this->generateAuthToken($user),
            'admin' => $user->toArray()
        ];
    }

    /**
     * @param User $user
     * @return void
     */
    public function logout(User $user): void
    {
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return;
    }

    /**
     * @param User $user
     * @return string
     */
    private function generateAuthToken(User $user): string
    {
        // generate radom secret
        $secret = bin2hex(random_bytes(16));

        return $user->createToken($secret)->plainTextToken;
    }

    /**
     * @param string $email
     * @return void
     */
    public function requestPasswordReset(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return;
        }

        // generate radom secret
        $password_reset_token = bin2hex(random_bytes(32));

        $hash_token = Hash::make($password_reset_token);

        $this->passwordResetRepository->create([
            "email" => $email,
            "token" => $hash_token,
        ]);

        event(new RequestPasswordReset($password_reset_token));

        return;
    }
}
