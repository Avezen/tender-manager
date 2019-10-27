<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\Company;
use App\Entity\Project;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @var Company
     */
    public $company;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var float
     */
    public $budget;

    /**
     * @Assert\NotBlank()
     * @var \DateTime
     */
    public $endDate;

    public static function fromProject(Project $project): self
    {
        $projectData = new self();
        $projectData->name = $project->getName();
        $projectData->company = $project->getCompany();
        $projectData->budget = $project->getBudget();
        $projectData->endDate = $project->getEndDate();

        return $projectData;
    }
}