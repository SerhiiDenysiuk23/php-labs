<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookTypeForm;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/books')]
final class BookController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private PaginatorInterface   $paginator     // <— впровадити сервіс
    ) {}

    #[Route('/', name: 'book_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // 1) Отримуємо QueryBuilder по сутності
        $qb = $this->em->getRepository(Book::class)
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
        return $this->render('book/index.html.twig', [
            'pagination'   => $pagination,
            'itemsPerPage' => $itemsPerPage,
            'allowed'      => $allowed,
        ]);
    }

    #[Route('/new', name: 'book_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookTypeForm::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($book);
            $this->em->flush();
            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', ['book' => $book]);
    }

    #[Route('/{id}/edit', name: 'book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookTypeForm::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/edit.html.twig', ['form' => $form->createView(), 'book' => $book]);
    }

    #[Route('/{id}', name: 'book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $this->em->remove($book);
            $this->em->flush();
        }

        return $this->redirectToRoute('book_index');
    }
}
