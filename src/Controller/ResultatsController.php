<?php

namespace App\Controller;

use App\Entity\Resultats;
use App\Form\ResultatsType;
use App\Repository\ResultatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resultats")
 */
class ResultatsController extends AbstractController
{
    /**
     * @Route("/", name="resultats_index", methods={"GET"})
     */
    public function index(ResultatsRepository $resultatsRepository): Response
    {
        return $this->render('resultats/index.html.twig', [
            'resultats' => $resultatsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="resultats_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $resultat = new Resultats();
        $form = $this->createForm(ResultatsType::class, $resultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resultat);
            $entityManager->flush();

            return $this->redirectToRoute('resultats_index');
        }

        return $this->render('resultats/new.html.twig', [
            'resultat' => $resultat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resultats_show", methods={"GET"})
     */
    public function show(Resultats $resultat): Response
    {
        return $this->render('resultats/show.html.twig', [
            'resultat' => $resultat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="resultats_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Resultats $resultat): Response
    {
        $form = $this->createForm(ResultatsType::class, $resultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resultats_index', [
                'id' => $resultat->getId(),
            ]);
        }

        return $this->render('resultats/edit.html.twig', [
            'resultat' => $resultat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resultats_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Resultats $resultat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resultat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resultat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('resultats_index');
    }
}
