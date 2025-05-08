<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorTypeForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/authors')]
final class AuthorController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    #[Route('/', name: 'author_index', methods: ['GET'])]
    public function index(): Response
    {
        $authors = $this->em->getRepository(Author::class)->findAll();
        return $this->render('author/index.html.twig', ['authors' => $authors]);
    }

    #[Route('/new', name: 'author_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorTypeForm::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($author);
            $this->em->flush();
            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'author_show', methods: ['GET'])]
    public function show(Author $author): Response
    {
        return $this->render('author/show.html.twig', ['author' => $author]);
    }

    #[Route('/{id}/edit', name: 'author_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Author $author): Response
    {
        $form = $this->createForm(AuthorTypeForm::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/edit.html.twig', ['form' => $form->createView(), 'author' => $author]);
    }

    #[Route('/{id}', name: 'author_delete', methods: ['POST'])]
    public function delete(Request $request, Author $author): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $this->em->remove($author);
            $this->em->flush();
        }

        return $this->redirectToRoute('author_index');
    }
}
