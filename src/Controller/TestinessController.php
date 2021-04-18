<?php

namespace App\Controller;

use App\Entity\Testiness;
use App\Form\TestinessType;
use App\Repository\TestinessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/testiness")
 */
class TestinessController extends AbstractController
{
    /**
     * @Route("/", name="testiness_index", methods={"GET"})
     */
    public function index(TestinessRepository $testinessRepository): Response
    {
        return $this->render('testiness/index.html.twig', [
            'testinesses' => $testinessRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="testiness_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $testiness = new Testiness();
        $form = $this->createForm(TestinessType::class, $testiness);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($testiness);
            $entityManager->flush();

            return $this->redirectToRoute('testiness_index');
        }

        return $this->render('testiness/new.html.twig', [
            'testiness' => $testiness,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="testiness_show", methods={"GET"})
     */
    public function show(Testiness $testiness): Response
    {
        return $this->render('testiness/show.html.twig', [
            'testiness' => $testiness,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="testiness_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Testiness $testiness): Response
    {
        $form = $this->createForm(TestinessType::class, $testiness);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('testiness_index');
        }

        return $this->render('testiness/edit.html.twig', [
            'testiness' => $testiness,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="testiness_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Testiness $testiness): Response
    {
        if ($this->isCsrfTokenValid('delete'.$testiness->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($testiness);
            $entityManager->flush();
        }

        return $this->redirectToRoute('testiness_index');
    }
}
