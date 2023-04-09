<?php

namespace App\Services;

use App\Models\FriendRequest;
use App\Models\UserBlockList;
use App\Dtos\FriendRequestDto;
use App\Repositories\FriendRequestRepository;
use App\Repositories\UserBlockListRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class FriendRequestService
{
    public function __construct(
        private readonly FriendRequestRepository $friendRequestRepository,
        private readonly UserBlockListRepository $userBlockListRepository,
    ) {}
    
    public function create(FriendRequestDto $friendRequestDto): FriendRequest
    {
        if ($friendRequestDto->sender_id === $friendRequestDto->receiver_id) {
            throw new BadRequestException("Sender and receiver cannot be the same");
        }

        /**
         * @var UserBlockList[] $checkSenderBlockList
         */
        $checkSenderBlockList = $this->userBlockListRepository->findBy(
            [
                "user_id" => $friendRequestDto->sender_id,
                "blocked_user_id" => $friendRequestDto->receiver_id
            ]
        );

        /**
         * @var UserBlockList[] $checkReceiverBlockList
         */
        $checkReceiverBlockList = $this->userBlockListRepository->findBy(
            [
                "user_id" => $friendRequestDto->receiver_id,
                "blocked_user_id" => $friendRequestDto->sender_id
            ]
        );

        if (count($checkSenderBlockList) > 0 || count($checkReceiverBlockList) > 0) {
            throw new BadRequestException("You can't send a friend request to this user");
        }

        /**
         * @var FriendRequest
         */
        return $this->friendRequestRepository->create($friendRequestDto->toArray());
    }

    public function accept(string $id): bool
    {
        /**
         * @var FriendRequest|null $friendRequest
         */
        $friendRequest = $this->friendRequestRepository->findById($id);

        if (!$friendRequest) {
            throw new NotFoundResourceException("Friend poke not found");
        }

        return $this->friendRequestRepository->update($friendRequest->id, ["status" => "accepted"]);
    }

    public function reject(string $id): bool
    {
        /**
         * @var FriendRequest|null $friendRequest
         */
        $friendRequest = $this->friendRequestRepository->findById($id);

        if (!$friendRequest) {
            throw new NotFoundResourceException("Friend poke not found");
        }

        return $this->friendRequestRepository->update($friendRequest->id, ["status" => "rejected"]);
    }
}

?>