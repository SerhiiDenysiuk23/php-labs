<?php

namespace App\Controller;

use App\Entity\BookReturn;
use App\Form\BookReturnTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/returns')]
final class BookReturnController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    #[Route('/', name: 'return_index', methods: ['GET'])]
    public function index(): Response
    {
        $returns = $this->em->getRepository(BookReturn::class)->findAll();
        return $this->render('return/index.html.twig', ['returns' => $returns]);
    }

    #[Route('/new', name: 'return_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $bookReturn = new BookReturn();
        $form = $this->createForm(BookReturnTypeForm::class, $bookReturn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($bookReturn);
            $this->em->flush();
            return $this->redirectToRoute('return_index');
        }

        return $this->render('return/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'return_show', methods: ['GET'])]
    public function show(BookReturn $return): Response
    {
        return $this->render('return/show.html.twig', ['return' => $return]);
    }

    #[Route('/{id}/edit', name: 'return_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BookReturn $return): Response
    {
        $form = $this->createForm(BookReturnTypeForm::class, $return);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('return_index');
        }

        return $this->render('return/edit.html.twig', ['form' => $form->createView(), 'return' => $return]);
    }

    #[Route('/{id}', name: 'return_delete', methods: ['POST'])]
    public function delete(Request $request, BookReturn $return): Response
    {
        if ($this->isCsrfTokenValid('delete'.$return->getId(), $request->request->get('_token'))) {
            $this->em->remove($return);
            $this->em->flush();
        }

        return $this->redirectToRoute('return_index');
    }
}
