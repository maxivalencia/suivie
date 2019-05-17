<?php

namespace App\Controller;

use App\Entity\Regions;
use App\Form\RegionsType;
use App\Repository\RegionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/regions")
 */
class RegionsController extends AbstractController
{
    /**
     * @Route("/", name="regions_index", methods={"GET"})
     */
    public function index(RegionsRepository $regionsRepository): Response
    {
        return $this->render('regions/index.html.twig', [
            'regions' => $regionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="regions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $region = new Regions();
        $form = $this->createForm(RegionsType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($region);
            $entityManager->flush();

            return $this->redirectToRoute('regions_index');
        }

        return $this->render('regions/new.html.twig', [
            'region' => $region,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="regions_show", methods={"GET"})
     */
    public function show(Regions $region): Response
    {
        return $this->render('regions/show.html.twig', [
            'region' => $region,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="regions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Regions $region): Response
    {
        $form = $this->createForm(RegionsType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('regions_index', [
                'id' => $region->getId(),
            ]);
        }

        return $this->render('regions/edit.html.twig', [
            'region' => $region,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="regions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Regions $region): Response
    {
        if ($this->isCsrfTokenValid('delete'.$region->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($region);
            $entityManager->flush();
        }

        return $this->redirectToRoute('regions_index');
    }
}
