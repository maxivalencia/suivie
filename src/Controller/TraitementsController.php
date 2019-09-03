<?php

namespace App\Controller;

use App\Entity\Traitements;
use App\Form\TraitementsType;
use App\Repository\TraitementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Include paginator interface
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/traitements")
 */
class TraitementsController extends AbstractController
{
    /**
     * @Route("/", name="traitements_index", methods={"GET"})
     */
    public function index(TraitementsRepository $traitementsRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $dossierpaginer = $paginator->paginate(
            $traitementsRepository->findAll(),
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            20
        );
        return $this->render('traitements/index.html.twig', [
            'traitements' => $dossierpaginer,
        ]);
    }

    /**
     * @Route("/new", name="traitements_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $traitement = new Traitements();
        $form = $this->createForm(TraitementsType::class, $traitement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($traitement);
            $entityManager->flush();

            return $this->redirectToRoute('traitements_index');
        }

        return $this->render('traitements/new.html.twig', [
            'traitement' => $traitement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="traitements_show", methods={"GET"})
     */
    public function show(Traitements $traitement): Response
    {
        return $this->render('traitements/show.html.twig', [
            'traitement' => $traitement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="traitements_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Traitements $traitement): Response
    {
        $form = $this->createForm(TraitementsType::class, $traitement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('traitements_index', [
                'id' => $traitement->getId(),
            ]);
        }

        return $this->render('traitements/edit.html.twig', [
            'traitement' => $traitement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="traitements_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Traitements $traitement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$traitement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($traitement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('traitements_index');
    }
}
