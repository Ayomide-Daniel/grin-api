<?php

namespace App\Services;

use App\Dtos\CreateLocationDto;
use App\Models\Location;
use App\Repositories\LocationRepository;
use App\Repositories\UserRepository;
use App\Traits\CanDictify;

class LocationService
{
    use CanDictify;

    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly UserRepository $userRepository,
    ) {}

    public function create(CreateLocationDto $createLocationDto): Location
    {
        /**
         * @var Location
         */
        return $this->locationRepository->create($createLocationDto->toArray());
    }

    /**
     * Get nearby users
     * 
     * @param Location $userLocation
     * 
     * @return array<int<0, max>, mixed>. 
     */
    public function getNearbyUsers(Location $userLocation): array
    {
        /**
         * @var Location[] $all_locations
         */
        $all_locations = $this->locationRepository->findBy(["status" => "active"]);

        $nearby_users = [];

        foreach ($all_locations as $location) {
            $distance = $this->getDistance($userLocation->latitude, $userLocation->longitude, $location->latitude, $location->longitude);

            if ($distance <= 100 && $location->user_id != $userLocation->user_id) {
                $nearby_users[] = $location->user_id;
            }
        }

        foreach ($nearby_users as $key => $user_id) {
            $user = $this->userRepository->findById($user_id, ["*"], ["account"])->toArray();

            $user["account"] = $this->dictify($user["account"], "type");
            unset($user["account"]["social media"]);
            $nearby_users[$key] = $user;
        }
        return $nearby_users;
    }

    /**
     * Calculate distance between two points in km's
     * 
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @param string $unit
     * 
     * @return float
     */
    private function getDistance(float $lat1, float $lon1, float $lat2, float $lon2, string $unit = "K"): float
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        }
        if ($unit == "N") {
            return ($miles * 0.8684);
        }
        return $miles;
    }
}
