<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-08-06
 * Time: 13:27
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Extension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('sortByScore', [$this, 'sortByScore']),
        ];
    }

    public function sortByScore($contractorOfferProductGroups, $order)
    {
        if ($order === 'ASC'){
            usort($contractorOfferProductGroups, [$this, 'cmpASC']);
            return $contractorOfferProductGroups;
        }

        usort($contractorOfferProductGroups, [$this, 'cmpDESC']);
        return $contractorOfferProductGroups;
    }

    public function cmpDESC($a, $b)
    {
        if ($a->getScore() == $b->getScore()) {
            return 0;
        }
        return ($a->getScore() > $b->getScore()) ? -1 : 1;
    }

    public function cmpASC($a, $b)
    {
        if ($a->getScore() == $b->getScore()) {
            return 0;
        }
        return ($a->getScore() < $b->getScore()) ? -1 : 1;
    }


}