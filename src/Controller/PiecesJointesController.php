<?php

namespace App\Controller;

use App\Entity\PiecesJointes;
use App\Form\PiecesJointesType;
use App\Repository\PiecesJointesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pieces/jointes")
 */
class PiecesJointesController extends AbstractController
{
    /**
     * @Route("/", name="pieces_jointes_index", methods={"GET"})
     */
    public function index(PiecesJointesRepository $piecesJointesRepository): Response
    {
        return $this->render('pieces_jointes/index.html.twig', [
            'pieces_jointes' => $piecesJointesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pieces_jointes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $piecesJointe = new PiecesJointes();
        $form = $this->createForm(PiecesJointesType::class, $piecesJointe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($piecesJointe);
            $entityManager->flush();

            return $this->redirectToRoute('pieces_jointes_index');
        }

        return $this->render('pieces_jointes/new.html.twig', [
            'pieces_jointe' => $piecesJointe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pieces_jointes_show", methods={"GET"})
     */
    public function show(PiecesJointes $piecesJointe): Response
    {
        return $this->render('pieces_jointes/show.html.twig', [
            'pieces_jointe' => $piecesJointe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pieces_jointes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PiecesJointes $piecesJointe): Response
    {
        $form = $this->createForm(PiecesJointesType::class, $piecesJointe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pieces_jointes_index', [
                'id' => $piecesJointe->getId(),
            ]);
        }

        return $this->render('pieces_jointes/edit.html.twig', [
            'pieces_jointe' => $piecesJointe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pieces_jointes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PiecesJointes $piecesJointe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$piecesJointe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($piecesJointe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pieces_jointes_index');
    }
}
