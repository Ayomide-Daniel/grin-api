<?php

namespace App\Services;

use App\Dtos\AccountDto;
use App\Models\Account;
use App\Repositories\AccountRepository;
use App\Traits\CanDictify;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AccountService
{
    use CanDictify;

    public function __construct(
        private readonly AccountRepository $accountsRepository
    ) {}
    
    public function create(AccountDto $createAccountDto): Account
    {
        /**
         * @var Account|null $account
         */
        $account = $this->checkIfUserAccountExists($createAccountDto);

        if ($account) {
            throw new BadRequestException("Account already exists");
        }

        /**
         * @var Account
         */
        return $this->accountsRepository->create($createAccountDto->toArray());
    }

    private function checkIfUserAccountExists(AccountDto $dto): ?Account
    {
        /**
         * @var Account|null
         */
        return $this->accountsRepository->findOneBy([
            'user_id' => $dto->user_id,
            'type' => $dto->type,
            'tag' => $dto->tag,
        ]);
    }

    /**
     * @param string $user_id
     * @param bool $dictify
     * @return Account[] | array<string, Account>
     */
    public function readUserAccounts(string $user_id, bool $dictify = false): array
    {
        /**
         * @var Account[] $accounts
         */
        $accounts = $this->accountsRepository->findBy(["user_id" => $user_id])->toArray();

        if ($dictify) {
            $accounts = $this->dictify($accounts, "tag");
        }

        return $accounts;
    }

    public function update(Account $account, AccountDto $updateAccountDto): bool
    {
        /**
         * @var Account|null $account
         */
        $account = $this->checkIfUserAccountExists($updateAccountDto);

        if (!$account) {
            throw new BadRequestException("Account does not exist");
        }

        if ($account->user_id !== $updateAccountDto->user_id) {
            throw new BadRequestException("Account does not belong to user");
        }

        /**
         * TODO: ensure that the update won't cause a duplicate
         */

        return $this->accountsRepository->update($account->id, $updateAccountDto->toArray());
    }
}

?>