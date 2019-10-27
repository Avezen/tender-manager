<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\Location;
use Symfony\Component\Validator\Constraints as Assert;

class LocationData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $description;


    public static function fromLocation(Location $location): self
    {
        $locationData = new self();
        $locationData->name = $location->getName();
        $locationData->description = $location->getDescription();

        return $locationData;
    }
}