<?php

namespace App\Controller;

use App\Entity\BookReturn;
use App\Form\BookReturnTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/returns')]
final class BookReturnController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private PaginatorInterface   $paginator     // <— впровадити сервіс
    ) {}

    #[Route('/', name: 'return_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // 1) Отримуємо QueryBuilder по сутності
        $qb = $this->em->getRepository(BookReturn::class)
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
        return $this->render('return/index.html.twig', [
            'pagination'   => $pagination,
            'itemsPerPage' => $itemsPerPage,
            'allowed'      => $allowed,
        ]);
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
