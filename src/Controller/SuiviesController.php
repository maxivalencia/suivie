<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SuiviesController extends AbstractController
{
    /**
     * @Route("/suivies", name="suivies")
     */
    public function index()
    {
        return $this->render('suivies/index.html.twig', [
            'controller_name' => 'SuiviesController',
        ]);
    }
}
