<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Cocur\Slugify\Slugify;


/**
 * Crud Book Controller
 * 
 * 
 * @Route("/admin/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="admin.book.index", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('admin/book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.book.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
      
        if ($form->isSubmitted() && $form->isValid()) {
      
            $entityManager = $this->getDoctrine()->getManager();
            $slugify = new Slugify();
            $book->setSlug( $slugify->slugify($book->getTitle()));
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('admin.book.index');
        }

        return $this->render('admin/book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.book.show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('admin/book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.book.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin.book.index');
        }

        return $this->render('admin/book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.book.delete", methods={"POST"})
     */
    public function delete(Request $request, Book $book): Response
    {   
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.book.index');
    }
}
