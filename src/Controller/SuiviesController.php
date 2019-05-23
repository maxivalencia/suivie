<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use App\Repository\DossiersRepository;
use App\Entity\User;
use App\Entity\Dossiers;
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
    public function dossiers_fini(DossiersRepository $dossiersRepository, UserRepository $userRepository): Response
    {
        $dossiers[] = new Dossiers();
        $dossier =  $dossiersRepository->findBy(['resultat' => 'Terminer', 'uniteorigine' => $this->getUser()->getUnite()], ['id' => 'DESC']);
        $dossier =  $dossier->add($dossiersRepository->findBy(['resultat' => 'Terminer', 'unitedestinataire' => $this->getUser()->getUnite()], ['id' => 'DESC']));
        return $this->render('dossiers/index.html.twig', [
            'dossiers' => $dossiers,
        ]);
    }
}
