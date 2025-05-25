<?php

namespace App\Controller;

use App\Entity\BookIssue;
use App\Form\BookIssueTypeForm;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/issues')]
final class BookIssueController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private PaginatorInterface   $paginator     // <— впровадити сервіс
    ) {}

    #[Route('/', name: 'issue_index', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT')]
    public function index(Request $request): Response
    {
        // 1) Отримуємо QueryBuilder по сутності
        $qb = $this->em->getRepository(BookIssue::class)
            ->createQueryBuilder('a');

        // 2) Скільки на сторінці?
        $itemsPerPage = $request->query->getInt('itemsPerPage', 10);
        $allowed = [5,10,25,50,100];
        if (!in_array($itemsPerPage, $allowed)) {
            $itemsPerPage = 10;
        }

        // 3) Пагінація
        $pagination = $this->paginator->paginate(
            $qb,                                  // QueryBuilder
            $request->query->getInt('page', 1),   // номер сторінки
            $itemsPerPage                         // елементів на сторінці
        );

        // 4) Рендер
        return $this->render('issue/index.html.twig', [
            'pagination'   => $pagination,
            'itemsPerPage' => $itemsPerPage,
            'allowed'      => $allowed,
        ]);
    }

    #[Route('/new', name: 'issue_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MANAGER')]
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
    #[IsGranted('ROLE_CLIENT')]
    public function show(BookIssue $issue): Response
    {
        return $this->render('issue/show.html.twig', ['issue' => $issue]);
    }

    #[Route('/{id}/edit', name: 'issue_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MANAGER')]
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
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, BookIssue $issue): Response
    {
        if ($this->isCsrfTokenValid('delete'.$issue->getId(), $request->request->get('_token'))) {
            $this->em->remove($issue);
            $this->em->flush();
        }

        return $this->redirectToRoute('issue_index');
    }
}
