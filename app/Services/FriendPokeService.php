<?php

namespace App\Services;

use App\Dtos\FriendPokeDto;
use App\Models\FriendPoke;
use App\Repositories\FriendPokeRepository;
use App\Repositories\UserBlockListRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class FriendPokeService
{
    public function __construct(
        private readonly FriendPokeRepository $friendPokeRepository,
        private readonly UserBlockListRepository $userBlockListRepository,
    ) {
    }

    public function create(FriendPokeDto $friendPokeDto): FriendPoke
    {
        if ($friendPokeDto->sender_id == $friendPokeDto->receiver_id) {
            throw new BadRequestException("Sender and receiver cannot be the same");
        }

        /**
         * @var FriendPoke[] $checkSenderBlockList
         */
        $checkSenderBlockList = $this->userBlockListRepository->findBy(
            [
                "user_id" => $friendPokeDto->sender_id,
                "blocked_user_id" => $friendPokeDto->receiver_id
            ]
        );

        /**
         * @var FriendPoke[] $checkReceiverBlockList
         */
        $checkReceiverBlockList = $this->userBlockListRepository->findBy(
            [
                "user_id" => $friendPokeDto->receiver_id,
                "blocked_user_id" => $friendPokeDto->sender_id
            ]
        );

        if (count($checkSenderBlockList) > 0 || count($checkReceiverBlockList) > 0) {
            throw new BadRequestException("You can't poke this user");
        }

        /**
         * @var FriendPoke[] $checkPokesSent
         */
        $checkPokesSent = $this->friendPokeRepository->findBy([
            "sender_id" => $friendPokeDto->sender_id,
            "receiver_id" => $friendPokeDto->receiver_id
        ]);


        if (count($checkPokesSent) > 3) {
            throw new BadRequestException("You can't poke this user more than 4 times");
        }
        
        /**
         * @var FriendPoke
         */
        return $this->friendPokeRepository->create($friendPokeDto->toArray());
    }

}
