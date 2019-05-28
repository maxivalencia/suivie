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
use App\Repository\ResultatsRepository;
use App\Entity\User;
use App\Entity\Dossiers;
use App\Entity\Unites;
use App\Entity\Traitements;
use App\Entity\Resultats;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Form\DossiersType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
                'dossiers' => $dossiersRepository->findByDosFini($traitement->getId(), $unit1->getId()),
                'retour' => 'dossiers_affichage',
                'titre' => 'Terminer',
            ]);
        }
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossiersRepository->findByDosFini($traitement->getId()),
            'retour' => 'dossiers_affichage',
            'titre' => 'Terminer',
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
        $traitement2 = new Traitements();
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        //$unit2 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'En cours']);
        $traitement2 = $traitementsRepository->findOneBy(['traitement' => 'Non']);
        if($unit1 != null){
            return $this->render('suivie/suivie.html.twig', [
                'dossiers' => $dossiersRepository->findByDosAttente($traitement->getId(), $unit1->getId()),
                'retour' => 'dossiers_affichage',
                'titre' => 'En attente',
            ]);
        }
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossiersRepository->findByDosAttente($traitement->getId()),
            'retour' => 'dossiers_affichage',
            'titre' => 'En attente',
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
        $traitement2 = new Traitements();
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        //$unit2 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'Non']);
        $traitement2 = $traitementsRepository->findOneBy(['traitement' => 'En attente']);
        if($unit1 != null){
            return $this->render('suivie/suivie.html.twig', [
                'dossiers' => $dossiersRepository->findByDosNonRecue($traitement->getId(), $unit1->getId(), $traitement2->getId()),
                'retour' => 'dossiers_affichage',
                'titre' => 'Non recue',
            ]);
        }
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossiersRepository->findByDosNonRecue($traitement->getId()),
            'retour' => 'dossiers_affichage',
            'titre' => 'Non recue',
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
                'retour' => 'dossiers_affichage',
                'titre' => 'En cours de traitement',
            ]);
        }
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossiersRepository->findByDosEnCours($traitement->getId()),
            'retour' => 'dossiers_affichage',
            'titre' => 'En cours de traitement',
        ]);
    }

    /**
     * @Route("/{id}/dossiers_affichage", name="dossiers_affichage", methods={"GET", "POST"})
     */
    public function dossiers_affichage(TraitementsRepository $traitementsRepository, Dossiers $dossier, DossiersRepository $dossiersRepository, Request $request, ResultatsRepository $resultatsRepository): Response
    {
        $form = $this->createFormBuilder()
            ->add('Unites', EntityType::class, [
                'class' => Unites::class,
                'label' => 'Unité destinataire',
                'required' => true,
                'attr' => [
                    'class' => 'multi',
                    'multiple' => false,
                    'data-live-search' => true,
                ],
            ])
            ->add('Dossiers', HiddenType::class, [
                'data' => $dossier->getId()
            ])
            ->add('Transferer', SubmitType::class, ['label' => 'Transferer'])
            ->getForm();

        $form2 = $this->createFormBuilder()
            ->add('Resultats', EntityType::class, [
                'class' => Resultats::class,
                'label' => 'Résultat du traitement',
                'required' => true,
                'attr' => [
                    'class' => 'multi',
                    'multiple' => false,
                    'data-live-search' => true,
                ],
            ])
            ->add('Suggestions', TextareaType::class, [
                'label' => 'suggestion',
            ])
            ->add('Dossiers', HiddenType::class, [
                'data' => $dossier->getId()
            ])
            ->add('Terminer', SubmitType::class, ['label' => 'Terminer'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //$dossier1 = new Dossiers();
            $dossier->setTraitement($traitementsRepository->findOneBy(['traitement' => 'En attente']));
            $entityManager->persist($dossier);
            $entityManager->flush();
            //$dossier2 = new Dossiers($dossier);
            $donnee = $form->get('Dossiers')->getData();
            $dossier2 = $dossiersRepository->findOneBy(['id' => $donnee]);
            $dossier2 = clone $dossier;
            $entityManager->detach($dossier2);
            //$dossier2->setUniteorigine($dossier->getUnitedestinataire());
            $dossier2->setUniteorigine($this->getUser()->getUnite());
            $dossier2->setUnitedestinataire($form->get('Unites')->getData());
            $dossier2->setTraitement($traitementsRepository->findOneBy(['traitement' => 'Non']));  
            $dossier2->setPrecdossiers($dossier);          
            //$entityManager->flush();
            $entityManager->persist($dossier2);
            $entityManager->flush();
        
            return $this->redirectToRoute('dossiers_miandry');
        }

        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //$dossier1 = new Dossiers();
            $dossier->setTraitement($traitementsRepository->findOneBy(['traitement' => 'Terminer']));
            $dossier->setResultat($form2->get('Resultats')->getData());
            $entityManager->persist($dossier);
            $entityManager->flush();
            //$dossier2 = new Dossiers($dossier);
            $donnee = $form2->get('Dossiers')->getData();
            $dossier2 = $dossiersRepository->findOneBy(['id' => $donnee]);
            $dossier2 = clone $dossier;
            $entityManager->detach($dossier2);
            //$dossier2->setUniteorigine($dossier->getUnitedestinataire());
            $dossier2->setUniteorigine($this->getUser()->getUnite());
            $dossier2->setUnitedestinataire($dossier->getUniteorigine());
            $resultat = $form2->get('Resultats')->getData();
            $dossier2->setResultat($resultatsRepository->findOneBy(['id' => $resultat]));
            $dossier2->setTraitement($traitementsRepository->findOneBy(['traitement' => 'Non']));    
            $dossier2->setPrecdossiers($dossier->getPrecdossiers());  
            $dossier2->setSuggestions($dossier->getSuggestions().' '.$form2->get('Suggestions')->getData());
            //$entityManager->flush();
            $entityManager->persist($dossier2);
            $dossier3 = $dossiersRepository->findOneBy(['precdossiers' => $dossier->getPrecdossiers()]);
            $dossier3->setTraitement($traitementsRepository->findOneBy(['traitement' => 'Terminer']));
            $entityManager->flush();
        
            return $this->redirectToRoute('dossiers_miandry');
        }

        
        // date de reception numerique du dossier
        if($dossier->getDaterecepnumeric() == null){
            $entityManager = $this->getDoctrine()->getManager();
            $dossier->setDaterecepnumeric(new \DateTime());
            $entityManager->persist($dossier);
            $entityManager->flush();
        }

        return $this->render('suivie/affichagesuivie.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }

    /**
     * @Route("/creation", name="dossiers_creation", methods={"GET","POST"})
     */
    public function new(TraitementsRepository $traitementsRepository, Request $request): Response
    {
        $dossier = new Dossiers();
        $form = $this->createForm(DossiersType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $dossier->setDateexpedition(new \DateTime());
            $dossier->setUniteorigine($this->getUser()->getUnite());
            $dossier->setTraitement($traitementsRepository->findOneBy(['traitement' => 'Non']));
            $daty   = new \DateTime(); //this returns the current date time
            $results = $daty->format('Y-m-d-H-i-s');
            $krr    = explode('-', $results);
            $results = implode("", $krr);
            $dossier->setReferencesuivie($results);
            $entityManager->persist($dossier);
            $entityManager->flush();

            return $this->redirectToRoute('dossiers_miandry');
        }

        return $this->render('suivie/creation.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/reception", name="dossiers_reception", methods={"GET", "POST"})
     */
    public function dossiers_reception(TraitementsRepository $traitementsRepository, Dossiers $dossier, DossiersRepository $dossiersRepository, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dossier->setTraitement($traitementsRepository->findOneBy(['id' => 1]));
        $dossier->setDaterecepeffectif(new \DateTime());
        $entityManager->persist($dossier);
        $entityManager->flush();
    
        return $this->redirectToRoute('dossiers_cours');
    }
}
