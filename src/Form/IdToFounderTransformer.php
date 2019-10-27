<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-01
 * Time: 14:31
 */

namespace App\Form;


use App\Entity\Company;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class IdToFounderTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($founder)
    {

        if ($founder == null) {
            return 0;
        }

        return $founder->getId();
    }


    public function reverseTransform($id)
    {
        if (!$id) {
            return;
        }

        $founder = $this->entityManager->getRepository(User::class)->findOneBy(
            [
                'id' => $id
            ]
        );

        if (null === $founder) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A user with id "%s" does not exist!',
                $id
            ));
        }
        return $founder;

    }

}