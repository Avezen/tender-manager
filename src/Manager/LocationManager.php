<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-17
 * Time: 16:01
 */

namespace App\Manager;


use App\Entity\Location;
use App\Model\LocationModel;
use App\RequestData\LocationData;
use Doctrine\ORM\EntityManagerInterface;

class LocationManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function create(LocationData $locationData)
    {
        $location = new Location();
        $location
            ->setName($locationData->name)
            ->setDescription($locationData->description)
            ;

        $this->em->persist($location);
        $this->em->flush();

        return $location;
    }

    public function update(Location $location, LocationData $locationData)
    {
        $location
            ->setName($locationData->name)
            ->setDescription($locationData->description)
            ;

        $this->em->persist($location);
        $this->em->flush();

        return $location;
    }

    public function delete(Location $location)
    {
        $this->em->remove($location);
        $this->em->flush();

        return $location;
    }

    public function prepareForResponse(Location $location)
    {
        return new LocationModel(
            $location->getId(),
            $location->getName(),
            $location->getDescription(),
            $location->getCreatedAt(),
            $location->getUpdatedAt()
        );
    }

    public function prepareListForResponse(array $locations)
    {
        $locationList = [];

        foreach($locations as $location){
            $locationList[] = $this->prepareForResponse($location);
        }

        return $locationList;
    }



}