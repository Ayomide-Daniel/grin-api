<?php

namespace App\Services;

use App\Dtos\AccountSettingDto;
use App\Models\AccountSetting;
use App\Repositories\AccountSettingLogRepository;
use App\Repositories\AccountSettingRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class AccountSettingService
{
    public function __construct(
        private readonly AccountSettingRepository $accountSettingRepository,
        private readonly AccountSettingLogRepository $accountSettingLogRepository,
    ) {}

    public function create(AccountSettingDto $accountSettingDto): AccountSetting
    {
        /**
         * @var AccountSetting|null $accountExists
         */
        $accountExists = $this->accountSettingRepository->findOneBy([
            'user_id' => $accountSettingDto->user_id,
            'tag' => $accountSettingDto->tag,
        ]);

        if ($accountExists) {
            throw new BadRequestException('Account setting already exists');
        }

        return $this->accountSettingRepository->create($accountSettingDto->toArray());
    }

    public function update(string $id, AccountSettingDto $accountSettingDto): bool
    {
        /**
         * @var AccountSetting|null $accountSetting
         */
        $accountSetting = $this->accountSettingRepository->findById($id);

        if (!$accountSetting || $accountSetting->user_id !== $accountSettingDto->user_id) {
            throw new NotFoundResourceException('Account setting not found');
        }

        if ($accountSetting->tag === $accountSettingDto->tag || $accountSetting->value === $accountSettingDto->value) {
            throw new BadRequestException('Nothing to update');
        }
        
        // log previous value
        /**
         * @var AccountSettingLog
         */
        $this->accountSettingLogRepository->create([
            'id' => $accountSettingDto->user_id,
            'tag' => 'previous_'. $accountSetting->tag,
            'value' => $accountSetting->value,
        ]);

        return $this->accountSettingRepository->update($id, $accountSettingDto->toArray());
    }

    public function readByUser(string $userId): array
    {
        /**
         * @var AccountSetting[]
         */
        return $this->accountSettingRepository->findBy(['user_id' => $userId])->toArray();
    }
}
