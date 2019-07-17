<?php

namespace App\Controller;

use App\Entity\Dossiers;
use App\Form\DossiersType;
use App\Repository\DossiersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Include paginator interface
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/dossiers")
 */
class DossiersController extends AbstractController
{
    /**
     * @Route("/", name="dossiers_index", methods={"GET"})
     */
    public function index(DossiersRepository $dossiersRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $recherche = $request->query->get('search');
        if($recherche != ''){
            $dossierpaginer = $paginator->paginate(
                $dossiersRepository->Trouver($recherche),
                // Define the page parameter
                $request->query->getInt('page', 1),
                // Items per page
                200
            );
        } else {
            $dossierpaginer = $paginator->paginate(
                $dossiersRepository->findAll([],['id' => 'DESC']),
                // Define the page parameter
                $request->query->getInt('page', 1),
                // Items per page
                20
            );
        }
        return $this->render('dossiers/index.html.twig', [
            'dossiers' => $dossierpaginer,
        ]);
    }

    /**
     * @Route("/new", name="dossiers_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dossier = new Dossiers();
        $form = $this->createForm(DossiersType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $dossier->setDateexpedition(new \DateTime());
            $dossier->setUniteorigine($this->getUser()->getUnite());
            $daty   = new \DateTime(); //this returns the current date time
            $results = $daty->format('Y-m-d-H-i-s');
            $krr    = explode('-', $results);
            $results = implode("", $krr);
            $dossier->setReferencesuivie($results);
            $entityManager->persist($dossier);
            $entityManager->flush();

            return $this->redirectToRoute('dossiers_index');
        }

        return $this->render('dossiers/new.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dossiers_show", methods={"GET"})
     */
    public function show(Dossiers $dossier): Response
    {
        return $this->render('dossiers/show.html.twig', [
            'dossier' => $dossier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dossiers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dossiers $dossier): Response
    {
        $form = $this->createForm(DossiersType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dossiers_index', [
                'id' => $dossier->getId(),
            ]);
        }

        return $this->render('dossiers/edit.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dossiers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dossiers $dossier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dossier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dossier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dossiers_index');
    }
}
