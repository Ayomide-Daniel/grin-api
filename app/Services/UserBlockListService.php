<?php

namespace App\Services;

use App\Dtos\UserBlockListDto;
use App\Models\User;
use App\Models\UserBlockList;
use App\Repositories\UserBlockListRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class UserBlockListService
{
    public function __construct(
        private readonly UserBlockListRepository $userBlockListRepository,
    ) {}

    public function create(UserBlockListDto $userBlockListDto): UserBlockList
    {
        if ($userBlockListDto->user_id == $userBlockListDto->blocked_user_id) {
            throw new BadRequestException("You cannot block this user");
        }

        if ($this->checkIfExists($userBlockListDto)) {
            throw new BadRequestException("You have already blocked this user");
        }

        /**
         * @var UserBlockList
         */
        return $this->userBlockListRepository->create($userBlockListDto->toArray());
    }

    public function remove(string $id, User $user): bool
    {
        /**
         * @var UserBlockList|null $blockList
         */
        $blockList = $this->userBlockListRepository->findById($id);

        if (!$blockList) {
            throw new NotFoundResourceException("Block list not found");
        }

        if ($blockList->user_id != $user->id) {
            throw new BadRequestException("You cannot remove this user from your block list");
        }

        return $this->userBlockListRepository->deleteById($id);
    }

    /**
     * @param UserBlockListDto $userBlockListDto
     * @return UserBlockList|null
     */
    public function checkIfExists(UserBlockListDto $userBlockListDto)
    {
        /**
         * @var UserBlockList|null
         */
        return $this->userBlockListRepository->findOneBy([
            'user_id' => $userBlockListDto->user_id,
            'blocked_user_id' => $userBlockListDto->blocked_user_id
        ]);
    }
}

?>