<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-17
 * Time: 16:01
 */

namespace App\Manager;


use App\Entity\Project;
use App\Model\ProjectModel;
use App\RequestData\ProjectData;
use Doctrine\ORM\EntityManagerInterface;

class ProjectManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function create(ProjectData $projectData)
    {
        $project = new Project();
        $project
            ->setName($projectData->name)
            ->setCompany($projectData->company)
            ->setBudget($projectData->budget)
            ->setEndDate($projectData->endDate)
        ;

        $this->em->persist($project);
        $this->em->flush();

        return $project;
    }

    public function update(Project $project, ProjectData $projectData)
    {
        $project
            ->setName($projectData->name)
            ->setCompany($projectData->company)
            ->setBudget($projectData->budget)
            ->setEndDate($projectData->endDate)
        ;

        $this->em->persist($project);
        $this->em->flush();

        return $project;
    }

    public function delete(Project $project)
    {
        $this->em->remove($project);
        $this->em->flush();

        return $project;
    }

    public function prepareForResponse(Project $project)
    {
        return new ProjectModel(
            $project->getId(),
            $project->getName(),
            $project->getCompany(),
            $project->getBudget(),
            $project->getEndDate(),
            $project->getCreatedAt(),
            $project->getUpdatedAt()
        );
    }

    public function prepareListForResponse(array $auctions)
    {
        $auctionList = [];

        foreach($auctions as $auction){
            $auctionList[] = $this->prepareForResponse($auction);
        }

        return $auctionList;
    }



}