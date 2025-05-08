<?php

namespace App\Controller;

use App\Entity\BookIssue;
use App\Form\BookIssueTypeForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/issues')]
final class BookIssueController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    #[Route('/', name: 'issue_index', methods: ['GET'])]
    public function index(): Response
    {
        $issues = $this->em->getRepository(BookIssue::class)->findAll();
        return $this->render('issue/index.html.twig', ['issues' => $issues]);
    }

    #[Route('/new', name: 'issue_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $issue = new BookIssue();
        $form = $this->createForm(BookIssueTypeForm::class, $issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($issue);
            $this->em->flush();
            return $this->redirectToRoute('issue_index');
        }

        return $this->render('issue/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'issue_show', methods: ['GET'])]
    public function show(BookIssue $issue): Response
    {
        return $this->render('issue/show.html.twig', ['issue' => $issue]);
    }

    #[Route('/{id}/edit', name: 'issue_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BookIssue $issue): Response
    {
        $form = $this->createForm(BookIssueTypeForm::class, $issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('issue_index');
        }

        return $this->render('issue/edit.html.twig', ['form' => $form->createView(), 'issue' => $issue]);
    }

    #[Route('/{id}', name: 'issue_delete', methods: ['POST'])]
    public function delete(Request $request, BookIssue $issue): Response
    {
        if ($this->isCsrfTokenValid('delete'.$issue->getId(), $request->request->get('_token'))) {
            $this->em->remove($issue);
            $this->em->flush();
        }

        return $this->redirectToRoute('issue_index');
    }
}
