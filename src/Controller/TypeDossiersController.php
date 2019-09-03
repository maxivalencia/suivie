<?php

namespace App\Controller;

use App\Entity\TypeDossiers;
use App\Form\TypeDossiersType;
use App\Repository\TypeDossiersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Include paginator interface
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/type/dossiers")
 */
class TypeDossiersController extends AbstractController
{
    /**
     * @Route("/", name="type_dossiers_index", methods={"GET"})
     */
    public function index(TypeDossiersRepository $typeDossiersRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $dossierpaginer = $paginator->paginate(
            $typeDossiersRepository->findAll(),
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            20
        );
        return $this->render('type_dossiers/index.html.twig', [
            'type_dossiers' => $dossierpaginer,
        ]);
    }

    /**
     * @Route("/new", name="type_dossiers_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeDossier = new TypeDossiers();
        $form = $this->createForm(TypeDossiersType::class, $typeDossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeDossier);
            $entityManager->flush();

            return $this->redirectToRoute('type_dossiers_index');
        }

        return $this->render('type_dossiers/new.html.twig', [
            'type_dossier' => $typeDossier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_dossiers_show", methods={"GET"})
     */
    public function show(TypeDossiers $typeDossier): Response
    {
        return $this->render('type_dossiers/show.html.twig', [
            'type_dossier' => $typeDossier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_dossiers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeDossiers $typeDossier): Response
    {
        $form = $this->createForm(TypeDossiersType::class, $typeDossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_dossiers_index', [
                'id' => $typeDossier->getId(),
            ]);
        }

        return $this->render('type_dossiers/edit.html.twig', [
            'type_dossier' => $typeDossier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_dossiers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeDossiers $typeDossier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeDossier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeDossier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_dossiers_index');
    }
}
