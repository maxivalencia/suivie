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
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'Terminer']);
        if($unit1 != null && $unit2 != null){
            return $this->render('suivie/suivie.html.twig', [
                'dossiers' => $dossiersRepository->findByDosFini($traitement->getId(), $unit1->getId(), $unit2->getId()),
            ]);
        }
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossiersRepository->findByDosFini($traitement->getId()),
        ]);
    }
    
    /**
     * @Route("/dossiers_attente", name="dossiers_miandry", methods={"GET"})
     */
    public function dossiers_attente(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, UserRepository $userRepository, UnitesRepository $unitesRepository): Response
    {
        $unit1 = new Unites();
        $unit2 = new Unites();
        $traitement = new Traitements();
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        //$unit2 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'En attente']);
        if($unit1 != null){
            return $this->render('suivie/suivie.html.twig', [
                'dossiers' => $dossiersRepository->findByDosAttente($traitement->getId(), $unit1->getId()),
            ]);
        }
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossiersRepository->findByDosAttente($traitement->getId()),
        ]);
    }
    
    /**
     * @Route("/dossiers_non", name="dossiers_non", methods={"GET"})
     */
    public function dossiers_non(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, UserRepository $userRepository, UnitesRepository $unitesRepository): Response
    {
        $unit1 = new Unites();
        $unit2 = new Unites();
        $traitement = new Traitements();
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        //$unit2 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'Non']);
        if($unit1 != null){
            return $this->render('suivie/suivie.html.twig', [
                'dossiers' => $dossiersRepository->findByDosNonRecue($traitement->getId(), $unit1->getId()),
            ]);
        }
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossiersRepository->findByDosNonRecue($traitement->getId()),
        ]);
    }
    
    /**
     * @Route("/dossiers_cours", name="dossiers_cours", methods={"GET"})
     */
    public function dossiers_cours(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, UserRepository $userRepository, UnitesRepository $unitesRepository): Response
    {
        $unit1 = new Unites();
        $unit2 = new Unites();
        $traitement = new Traitements();
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        //$unit2 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'En cours']);
        if($unit1 != null){
            return $this->render('suivie/suivie.html.twig', [
                'dossiers' => $dossiersRepository->findByDosEnCours($traitement->getId(), $unit1->getId()),
            ]);
        }
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossiersRepository->findByDosEnCours($traitement->getId()),
        ]);
    }
}
