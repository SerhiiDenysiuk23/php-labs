<?php

namespace App\Controller;

use App\Entity\Reader;
use App\Form\ReaderTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/readers')]
final class ReaderController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private PaginatorInterface   $paginator     // <— впровадити сервіс
    ) {}

    #[Route('/', name: 'reader_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // 1) Отримуємо QueryBuilder по сутності
        $qb = $this->em->getRepository(Reader::class)
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
        return $this->render('reader/index.html.twig', [
            'pagination'   => $pagination,
            'itemsPerPage' => $itemsPerPage,
            'allowed'      => $allowed,
        ]);
    }

    #[Route('/new', name: 'reader_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $reader = new Reader();
        $form = $this->createForm(ReaderTypeForm::class, $reader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($reader);
            $this->em->flush();
            return $this->redirectToRoute('reader_index');
        }

        return $this->render('reader/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'reader_show', methods: ['GET'])]
    public function show(Reader $reader): Response
    {
        return $this->render('reader/show.html.twig', ['reader' => $reader]);
    }

    #[Route('/{id}/edit', name: 'reader_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reader $reader): Response
    {
        $form = $this->createForm(ReaderTypeForm::class, $reader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('reader_index');
        }

        return $this->render('reader/edit.html.twig', ['form' => $form->createView(), 'reader' => $reader]);
    }

    #[Route('/{id}', name: 'reader_delete', methods: ['POST'])]
    public function delete(Request $request, Reader $reader): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reader->getId(), $request->request->get('_token'))) {
            $this->em->remove($reader);
            $this->em->flush();
        }

        return $this->redirectToRoute('reader_index');
    }
}
