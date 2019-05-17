<?php

namespace App\Controller;

use App\Entity\Provinces;
use App\Form\ProvincesType;
use App\Repository\ProvincesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/provinces")
 */
class ProvincesController extends AbstractController
{
    /**
     * @Route("/", name="provinces_index", methods={"GET"})
     */
    public function index(ProvincesRepository $provincesRepository): Response
    {
        return $this->render('provinces/index.html.twig', [
            'provinces' => $provincesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="provinces_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $province = new Provinces();
        $form = $this->createForm(ProvincesType::class, $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($province);
            $entityManager->flush();

            return $this->redirectToRoute('provinces_index');
        }

        return $this->render('provinces/new.html.twig', [
            'province' => $province,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="provinces_show", methods={"GET"})
     */
    public function show(Provinces $province): Response
    {
        return $this->render('provinces/show.html.twig', [
            'province' => $province,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="provinces_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Provinces $province): Response
    {
        $form = $this->createForm(ProvincesType::class, $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('provinces_index', [
                'id' => $province->getId(),
            ]);
        }

        return $this->render('provinces/edit.html.twig', [
            'province' => $province,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="provinces_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Provinces $province): Response
    {
        if ($this->isCsrfTokenValid('delete'.$province->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($province);
            $entityManager->flush();
        }

        return $this->redirectToRoute('provinces_index');
    }
}
