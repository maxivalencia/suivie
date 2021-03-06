<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\UserRepository;
use App\Repository\DossiersRepository;
use App\Repository\UnitesRepository;
use App\Repository\TraitementsRepository;
use App\Repository\ResultatsRepository;
use App\Repository\PiecesJointesRepository;
use App\Entity\User;
use App\Entity\Dossiers;
use App\Entity\Unites;
use App\Entity\Traitements;
use App\Entity\Resultats;
use App\Entity\TypeDossiers;
use App\Entity\PiecesJointes;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Form\DossiersType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
//use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dompdf\Dompdf;
use Dompdf\Options;

// Include paginator interface
use Knp\Component\Pager\PaginatorInterface;

class SuiviesController extends AbstractController
{
    /**
     * @Route("/suivies", name="suivies")
     */
    public function index(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, UserRepository $userRepository, UnitesRepository $unitesRepository)
    {
        $unit = new Unites();
        $traitement = new Traitements();
        $unit = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'Non']);
        $numbers = $dossiersRepository->findAll(['unitedestinataire' => $unit, 'traitement' => $traitement]);
        $dataReceive = 0;
        foreach($numbers as $number){
            if($number->getUnitedestinataire() == $unit && $number->getTraitement() == $traitement){
                $dataReceive++;
            }
        }
        $non_recue = $dataReceive;

        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'En cours']);
        $numbers = $dossiersRepository->findByDosEnCours($traitement->getId(), $unit1->getId());
        $dataReceive = 0;
        foreach($numbers as $number){
            if($number->getUnitedestinataire() == $unit && $number->getTraitement() == $traitement){
                $dataReceive++;
            }
        }
        $en_cours = $dataReceive;
        
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'En attente']);
        $numbers = $dossiersRepository->findByDosAttente($traitement->getId(), $unit1->getId());
        $dataReceive = 0;
        foreach($numbers as $number){
            if($number->getUniteorigine() == $unit && $number->getTraitement() == $traitement){
                $dataReceive++;
            }
        }
        $en_attente = $dataReceive;

        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'Terminer']);
        $numbers = $dossiersRepository->findByDosEnCours($traitement->getId(), $unit1->getId());
        $dataReceive = 0;
        foreach($numbers as $number){
            if($number->getUnitedestinataire() == $unit && $number->getTraitement() == $traitement){
                $dataReceive++;
            }
        }
        $terminer = $dataReceive;

        return $this->render('suivies/index.html.twig', [
            'controller_name' => 'SuiviesController',
            'non_recue' => $non_recue,
            'en_cours' => $en_cours,
            'en_attente' => $en_attente,
            'terminer' => $terminer,
            'sous_unite' => 3,
        ]);
    }

    /**
     * @Route("/", name="cs_base")
     */
    public function rediriger(){
        if(!empty($_SESSION['username']))
        {
            return $this->redirectToRoute('suivies');
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
    public function dossiers_fini(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, UserRepository $userRepository, UnitesRepository $unitesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $unit1 = new Unites();
        $unit2 = new Unites();
        $traitement = new Traitements();
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $unit2 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'Terminer']);
        if($unit1 != null && $unit2 != null){
            $recherche = $request->query->get('search');
            if($recherche != ''){
                $dossierpaginer = $paginator->paginate(
                    $dossiersRepository->findByDosFiniRechercher($traitement->getId(), $unit1->getId(), $recherche),
                    // Define the page parameter
                    $request->query->getInt('page', 1),
                    // Items per page
                    100
                );
            } else {
                $dossierpaginer = $paginator->paginate(
                    $dossiersRepository->findByDosFini($traitement->getId(), $unit1->getId()),
                    // Define the page parameter
                    $request->query->getInt('page', 1),
                    // Items per page
                    10
                );
            }
            return $this->render('suivie/suivie.html.twig', [
                'dossiers' => $dossierpaginer,
                'retour' => 'dossiers_affichage',
                'titre' => 'Terminer',
                'type' => 'Traiter',
            ]);
        }
        $dossierpaginer = $paginator->paginate(
            $dossiersRepository->findByDosFini($traitement->getId()),
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossierpaginer,
            'retour' => 'dossiers_affichage',
            'titre' => 'Terminer',
            'type' => 'Traiter',
        ]);
    }
    
    /**
     * @Route("/dossiers_attente", name="dossiers_miandry", methods={"GET"})
     */
    public function dossiers_attente(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, UserRepository $userRepository, UnitesRepository $unitesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $unit1 = new Unites();
        $unit2 = new Unites();
        $traitement = new Traitements();
        $traitement2 = new Traitements();
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        //$unit2 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'En attente']);
        //$traitement2 = $traitementsRepository->findOneBy(['traitement' => 'Non']);
        if($unit1 != null){
            $recherche = $request->query->get('search');
            if($recherche != ''){
                $dossierpaginer = $paginator->paginate(
                    $dossiersRepository->findByDosAttenteRechercher($traitement->getId(), $unit1->getId(), $recherche),
                    // Define the page parameter
                    $request->query->getInt('page', 1),
                    // Items per page
                    100
                );
            } else {
                $dossierpaginer = $paginator->paginate(
                    $dossiersRepository->findByDosAttente($traitement->getId(), $unit1->getId()),
                    // Define the page parameter
                    $request->query->getInt('page', 1),
                    // Items per page
                    10
                );
            }
            return $this->render('suivie/suivie.html.twig', [
                'dossiers' => $dossierpaginer,
                'retour' => 'dossiers_affichage',
                'titre' => 'Transferer',
                'type' => 'Attente',
            ]);
            
        }
        $dossierpaginer = $paginator->paginate(
            $dossiersRepository->findByDosAttente($traitement->getId()),
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossierpaginer,
            'retour' => 'dossiers_affichage',
            'titre' => 'Transferer',
            'type' => 'Attente',
        ]);
    }
    
    /**
     * @Route("/dossiers_non", name="dossiers_non", methods={"GET"})
     */
    public function dossiers_non(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, UserRepository $userRepository, UnitesRepository $unitesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $unit1 = new Unites();
        $unit2 = new Unites();
        $traitement = new Traitements();
        $traitement2 = new Traitements();
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        //$unit2 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'Non']);
        //$traitement2 = $traitementsRepository->findOneBy(['traitement' => 'En attente']);
        if($unit1 != null){
            $recherche = $request->query->get('search');
            if($recherche != ''){
                $dossierpaginer = $paginator->paginate(
                    $dossiersRepository->findByDosNonRecueRechercher($traitement->getId(), $unit1->getId(), $traitement2->getId(), $recherche),
                    // Define the page parameter
                    $request->query->getInt('page', 1),
                    // Items per page
                    100
                );
            } else {
                $dossierpaginer = $paginator->paginate(
                    $dossiersRepository->findByDosNonRecue($traitement->getId(), $unit1->getId(), $traitement2->getId()),
                    // Define the page parameter
                    $request->query->getInt('page', 1),
                    // Items per page
                    10
                );
            }
            return $this->render('suivie/suivie.html.twig', [
                'dossiers' => $dossierpaginer,
                'retour' => 'dossiers_affichage',
                'titre' => 'Non recue',
                'type' => 'Non',
            ]);
        }
        $dossierpaginer = $paginator->paginate(
            $dossiersRepository->findByDosNonRecue($traitement->getId()),
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossierpaginer,
            'retour' => 'dossiers_affichage',
            'titre' => 'Non recue',
            'type' => 'Non',
        ]);
    }
    
    /**
     * @Route("/dossiers_cours", name="dossiers_cours", methods={"GET"})
     */
    public function dossiers_cours(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, UserRepository $userRepository, UnitesRepository $unitesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $unit1 = new Unites();
        $unit2 = new Unites();
        $traitement = new Traitements();
        $unit1 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        //$unit2 = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'En cours']);
        if($unit1 != null){
            $recherche = $request->query->get('search');
            if($recherche != ''){
                $dossierpaginer = $paginator->paginate(
                    $dossiersRepository->findByDosEnCoursRechercher($traitement->getId(), $unit1->getId(), $recherche),
                    // Define the page parameter
                    $request->query->getInt('page', 1),
                    // Items per page
                    100
                );
            } else {
                $dossierpaginer = $paginator->paginate(
                    $dossiersRepository->findByDosEnCours($traitement->getId(), $unit1->getId()),
                    // Define the page parameter
                    $request->query->getInt('page', 1),
                    // Items per page
                    10
                );
            }
            return $this->render('suivie/suivie.html.twig', [
                'dossiers' => $dossierpaginer,
                'retour' => 'dossiers_affichage',
                'titre' => 'En cours de traitement',
                'type' => 'Encours',
            ]);
        }
        $dossierpaginer = $paginator->paginate(
            $dossiersRepository->findByDosEnCours($traitement->getId()),
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossierpaginer,
            'retour' => 'dossiers_affichage',
            'titre' => 'En cours de traitement',
            'type' => 'Encours',
        ]);
    }

    /**
     * @Route("/{id}/dossiers_affichage", name="dossiers_affichage", methods={"GET", "POST"})
     */
    public function dossiers_affichage(TraitementsRepository $traitementsRepository, Dossiers $dossier, DossiersRepository $dossiersRepository, Request $request, ResultatsRepository $resultatsRepository, PiecesJointesRepository $piecesJointesRepository): Response
    {
        $piecejointe[] = new PiecesJointes();

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
            $dossier->setTraitement($traitementsRepository->findOneBy(['traitement' => 'En attente']));
            $entityManager->persist($dossier);
            $entityManager->flush();
            $donnee = $form->get('Dossiers')->getData();
            //$dossier2 = $dossiersRepository->findOneBy(['id' => $donnee]);
            $dossier2 = clone $dossier;
            $entityManager->detach($dossier2);
            $dossier2->setUniteorigine($this->getUser()->getUnite());
            $dossier2->setUnitedestinataire($form->get('Unites')->getData());
            $dossier2->setTraitement($traitementsRepository->findOneBy(['traitement' => 'Non']));  
            $dossier2->setPrecdossiers($dossier);
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
            $dossier->setSuggestions($dossier->getSuggestions().' '.$form2->get('Suggestions')->getData().'.');
            $nbjours = $dossier->getDaterecepeffectif()->diff(new \DateTime())->format("%a");
            if($nbjours <= 0){
                $nbjours = 1;
            }
            $dossier->setDureeeffectif($nbjours);
            $entityManager->persist($dossier);
            $entityManager->flush();
            //$dossier2 = new Dossiers($dossier);
            /* if($dossier->getPrecdossiers() != null){
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
                $dossier2->setPrecdossiers($dossier->getPrecdossiers()->getPrecdossiers());
                $nbjours2 = $dossier2->getDaterecepeffectif()->diff(new \DateTime())->format("%a");
                if($nbjours2 <= 0){
                    $nbjours2 = 1;
                }
                $dossier2->setDureeeffectif($nbjours2);
                //$dossier2->setDureeeffectif(abs((new \DateTime()) - $dossier2->getDaterecepeffectif()));
                //$dossier3 = $dossier->getPrecdossiers();
                //$dossier2->setSuggestions($dossier->getSuggestions().' '.$form2->get('Suggestions')->getData().'.');
                //$entityManager->flush();
                //$entityManager->persist($dossier2);
                $dossier3 = $dossiersRepository->findOneBy(['precdossiers' => $dossier->getPrecdossiers()]);
                $dossier3->setTraitement($traitementsRepository->findOneBy(['traitement' => 'Terminer']));
                $entityManager->persist($dossier2);
                $entityManager->persist($dossier3);
                $entityManager->flush();
            } */ /*else {
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
                //$dossier2->setPrecdossiers($dossier->getPrecdossiers()->getPrecdossiers());
                //$dossier3 = $dossier->getPrecdossiers();
                //$dossier2->setSuggestions($dossier->getSuggestions().' '.$form2->get('Suggestions')->getData().'.');
                //$entityManager->flush();
                $entityManager->persist($dossier2);
                $dossier3 = $dossiersRepository->findOneBy(['precdossiers' => $dossier->getPrecdossiers()]);
                $dossier3->setTraitement($traitementsRepository->findOneBy(['traitement' => 'Terminer']));
                $entityManager->persist($dossier2);
                $entityManager->persist($dossier3);
                $entityManager->flush();                
            }*/
            return $this->redirectToRoute('dossiers_miandry');
        }

        
        // date de reception numerique du dossier
        if($dossier->getDaterecepnumeric() == null){
            $entityManager = $this->getDoctrine()->getManager();
            $dossier->setDaterecepnumeric(new \DateTime());
            $entityManager->persist($dossier);
            $entityManager->flush();
        }
        
        /*$daty   = new \DateTime(); //this returns the current date time
        $results = $daty->format('Y-m-d-H-i-s');
        $krr    = explode('-', $results);
        $results = implode("", $krr).$this->generateUniqueFileName();*/

        $piecejointe = $piecesJointesRepository->findBy(['referencePJ' => $dossier->getPiecejointes()]);
        return $this->render('suivie/affichagesuivie.html.twig', [
            'dossier' => $dossier,
            'piecejointe' => $piecejointe,
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            //'refpiecejointe' => $results,
        ]);
    }

    /**
     * @Route("/creation", name="dossiers_creation", methods={"GET","POST"})
     */
    public function new(TraitementsRepository $traitementsRepository, Request $request): Response
    {
        /*$form = $this->createFormBuilder()
            ->add('reference', TextType::class, [
                'label' => 'Reférence',
            ])
            ->add('objet', TextType::class, [
                'label' => 'Objet de votre demande',
            ])
            ->add('dureetraitement', NumberType::class, [
                'label' => 'Durée prévue du traitement',
            ])
            ->add('piecejointe', FileType::class, [
                'label' => 'Pièces-jointes',
                'required'   => false,
                'multiple' => true,
            ])
            ->add('typedossier', EntityType::class, [
                'class' => TypeDossiers::class,
                'label' => 'Type de dossier',
                'required'   => true,
                'attr' => [
                    'class' => 'multi',
                    'multiple' => false,
                    'data-live-search' => true,
                ],
            ])
            ->add('unitedestinataire', EntityType::class, [
                'class' => Unites::class,
                'label' => 'Unité destinataire',
                'required' => true,
                'attr' => [
                    'class' => 'multi',
                    'multiple' => false,
                    'data-live-search' => true,
                ],
            ])
            ->add('montant', NumberType::class, [
                'label' => 'Montant de l\'objet(laissez vide si inexistant)',
            ])
            ->add('Ajouter', SubmitType::class, [
                'label' => 'Ajouter',
            ])
            ->getForm();*/
        $dossier = new Dossiers();
        $form = $this->createForm(DossiersType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //$dossier->setReference($form->get('dossiers')['reference']->getData());
            //$dossier->setObjet($form->get('dossiers')['objet']->getData());
            //$dossier->setDureetraitement($form->get('dossiers')['dureetraitement']->getData());
            //$dossier->setTypedossier($form->get('dossiers')['typedossier']->getData());
            //$dossier->setUnitedestinataire($form->get('dossiers')['unitedestinataire']->getData());
            //$dossier->setMontant($form->get('dossiers')['montant']->getData());
            //$dossier->setPiecejointes($form->get('piecejointes')->getData());
            $dossier->setDateexpedition(new \DateTime());
            $dossier->setUniteorigine($this->getUser()->getUnite());
            $dossier->setTraitement($traitementsRepository->findOneBy(['traitement' => 'Non']));
            $daty   = new \DateTime(); //this returns the current date time
            $results = $daty->format('Y-m-d-H-i-s');
            $krr    = explode('-', $results);
            $results = implode("", $krr);
            $dossier->setReferencesuivie($results);
            //$file = $dossier->getPiecejointes();
            /*$files[] = $form->get('dossiers')['piecejointe']->getData();
            $piecejointe = '';
            foreach($files as $file){
                if($piecejointe != ''){
                    $piecejointe = $piecejointe.';';
                }
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('piece_jointe_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $piecejointe = $piecejointe.$fileName;
            }
            $dossier->setPiecejointes('$piecejointe');*/
            $entityManager->persist($dossier);
            $entityManager->flush();

            return $this->redirectToRoute('dossiers_miandry');
        }
        
        $daty   = new \DateTime(); //this returns the current date time
        $results = $daty->format('Y-m-d-H-i-s');
        $krr    = explode('-', $results);
        $results = implode("", $krr).$this->generateUniqueFileName();
        
        $form->get('piecejointes')->setData($results);
        return $this->render('suivie/creation.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
            'refpiecejointe' => $results,
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

    /**
     * @Route("/sous_unite", name="sous_unite", methods={"GET", "POST"})
     */
    public function sous_unite(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, Request $request, UnitesRepository $unitesRepository): Response
    {
        $unit1 = new Unites();
        $unit1 = $unitesRepository->findOneBy(['id' => $this->getUser()->getUnite()]);
        $unit2[] = new Unites();
        $unit2 = $unitesRepository->findBy(['unitesuperieur' => $unit1]);
        $i = 0;
        foreach($unit2 as $unit){
            $unit2 = $unitesRepository->findBy(['unitesuperieur' => $unit]);
            $i++;
        }
        $traitement = new Traitements();
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'En cours']);
        $dossier[] = new Dossiers();
        foreach($unit2 as $unit){
            $dossier = $dossiersRepository->findByDosAttente($traitement->getId(), $unit->getId());
        }
        /*$entityManager = $this->getDoctrine()->getManager();
        $dossier->setTraitement($traitementsRepository->findOneBy(['id' => 1]));
        $dossier->setDaterecepeffectif(new \DateTime());
        $entityManager->persist($dossier);
        $entityManager->flush();*/
    
        return $this->render('suivie/suivie.html.twig', [
            'dossiers' => $dossier,
            'retour' => 'dossiers_affichage',
            'titre' => 'Sous unité',
            'type' => 'rien',
        ]);
    }
    
    /**
     * @Route("/notif_non", name="notif_non", methods={"GET"})
     */
    public function notif_non(TraitementsRepository $traitementsRepository, DossiersRepository $dossiersRepository, UserRepository $userRepository, UnitesRepository $unitesRepository)
    {
        $unit = new Unites();
        $traitement = new Traitements();
        $unit = $unitesRepository->findOneById(['id' => $this->getUser()->getUnite()]);
        $traitement = $traitementsRepository->findOneBy(['traitement' => 'Non']);
        $numbers = $dossiersRepository->findAll(['unitedestinataire' => $unit, 'traitement' => $traitement]);
        $dataReceive = 0;
        foreach($numbers as $number){
            if($number->getUnitedestinataire() == $unit && $number->getTraitement() == $traitement){
                $dataReceive++;
            }
        }
        return new JsonResponse(['numberAjax' => $number, "dataResponse" => $dataReceive]);  
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/upload_file/{ref}", name="upload_file", methods={"GET","POST"})
     */
    public function upload_file(Request $request, $ref): Response
    {
        $piecesJointes = new PiecesJointes(); 
        $entityManager = $this->getDoctrine()->getManager();   
        $file = $request->files->get('myfile');
        $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
        $file->move(
            $this->getParameter('piece_jointe_directory'),
            $fileName
        );
        $reference = $ref;//$request->request->get('piecejointes');
        $daty   = new \DateTime(); //this returns the current date time
        $results = $daty->format('Y-m-d-H-i-s');
        $krr    = explode('-', $results);
        $results = implode("", $krr);
        $piecesJointes->setNomFichier($file->getClientOriginalName()); // mila maka an'ilay reference sy ilay vraie nom de fichier
        $piecesJointes->setNomServer($fileName);
        $piecesJointes->setReferencePJ($reference);
        $entityManager->persist($piecesJointes);
        $entityManager->flush();
        return new JsonResponse(['filesnames' => $results]);
            
    }

    /**
     * @Route("/fileuploadhandler", name="fileuploadhandler")
     */
    public function fileUploadHandler(Request $request) {
        $output = array('uploaded' => false);
        // get the file from the request object
        $file = $request->files->get('file');
        // generate a new filename (safer, better approach)
        // To use original filename, $fileName = $this->file->getClientOriginalName();
        $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
     
        // set your uploads directory
        $uploadDir = $this->getParameter('brochures_directory');
        if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        if ($file->move($uploadDir, $fileName)) { 
           $output['uploaded'] = true;
           $output['fileName'] = $fileName;
        }
        return new JsonResponse($output);
    }

    /**
     * @Route("/{id}/pdf", name="pdf", methods={"GET"})
     */
    public function pdf(Dossiers $dossier, PiecesJointesRepository $piecesJointesRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $piecejointe = $piecesJointesRepository->findBy(['referencePJ' => $dossier->getPiecejointes()]);
        $logo = $this->getParameter('image').'/logo_dgsr.png';
        $html = $this->renderView('suivie/pdfsaisie.html.twig', [
            'dossier' => $dossier,
            'piecejointe' => $piecejointe,
            'logo' => $logo,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $fichier = $dossier->getObjet();
        $dompdf->stream("Suivie_".$fichier.".pdf", [
            "Attachment" => true
        ]);

    }
}
