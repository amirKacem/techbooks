<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/{slug}", name="book.show")
     */
    public function detail(Book $book): Response
    {   
        return $this->render('website/pages/book-detail.html.twig', [
            'book' => $book,
        ]);
    }
}
