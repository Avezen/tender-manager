<?php

namespace App\Util;

use Doctrine\ORM\EntityManagerInterface;
use App\Util\RandomStringGenerator;

/**
 * Description of UUIDGenerator
 */
class UUIDGenerator {

    /**
     *
     * @var EntityManagerInterface 
     */
    protected $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function generateUUID(string $className) {
        do {
            $uuid = RandomStringGenerator::generate();
            $existing = $this->em->getRepository($className)->findOneBy(['uuid' => $uuid]);
        } while ($existing);
        return $uuid;
    }

}
