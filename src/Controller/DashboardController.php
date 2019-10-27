<?php

namespace App\Controller;

use Hisune\EchartsPHP\Config;
use Hisune\EchartsPHP\ECharts;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index()
    {
        return $this->render('dashboard/index.html.twig', ['menu' => 'yeey!']);
    }

}
