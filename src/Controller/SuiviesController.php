<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use App\Repository\DossiersRepository;
use App\Repository\UnitesRepository;
use App\Repository\TraitementsRepository;
use App\Entity\User;
use App\Entity\Dossiers;
use App\Entity\Unites;
use App\Entity\Traitements;
use Symfony\Component\Validator\Constraints\DateTime;

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

    /**
     * @Route("/", name="cs_base")
     */
    public function rediriger(){
        if(!empty($_SESSION['username']))
        {
            return $this->redirectToRoute('cs_suivie');
        } else 
        {
            return $this->redirectToRoute('app_login');
        }
    }
    
    /**
     * @Route("/suivie", name="cs_suivie")
     */
    public function suivie()
    {
        return $this->render('suivie/suivie.html.twig', [
            'controller_name' => 'SuiviesController',
        ]);
    }
    /**
     * @Route("/dossiers_fini", name="dossiers_vita", methods={"GET"})
     */
    public function dossiers_fini(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, UserRepository $userRepository, UnitesRepository $unitesRepository): Response
    {
        $unit1 = new Unites();
        $unit2 = new Unites();
        $traitement = new Traitements();
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $unit2 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneById(['traitement' => 'Terminer']);
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossiersRepository->findByDosFini($traitement, $unit1, $unit2),
        ]);
    }
}
