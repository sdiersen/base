<?php
/**
 * Created by PhpStorm.
 * User: cippio
 * Date: 2/22/19
 * Time: 1:43 PM
 */

namespace App\Service;


use App\Entity\Gx\ScheduledClass;
use App\Entity\Location;
use App\Repository\LocationRepository;

class LocationHelper
{

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function getLocationsNames(): array
    {
        $ret = [];
        $names = $this->locationRepository->getAllLocationNames();
        foreach($names as $name) {
            $ret[] = $name["name"];
        }
        return $ret;
    }

    public function getLocationByName(?string $name): ?Location
    {
        if ($name == null) {return null;}
        return $this->locationRepository->findLocationByName($name);
    }

    public function getLocationById(?int $id): ?Location
    {
        if($id == null) { return null; }
        return $this->locationRepository->find($id);
    }

    public function getScheduledClassesAtLocationId(?int $id): array
    {
        if($id == null) { return []; }
        $club = $this->locationRepository->find($id);
        if ($club == null) { return []; }
        dd($club->getScheduledClasses());
        return $club->getScheduledClasses();
    }
    public function getRoomsForLocation(string $location): array
    {

        if($location == "Buffalo") {
            return ScheduledClass::getBuffaloRooms();
        }
        if($location == "Monticello") {
            return ScheduledClass::getMonticelloRooms();
        }
        if($location == "Zimmerman") {
            return ScheduledClass::getZimmermanRooms();
        }
        return [];
    }
}
