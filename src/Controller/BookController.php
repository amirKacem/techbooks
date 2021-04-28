<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $comment = new Comment();       
        $form = $this->createForm(CommentType::class, $comment,
        [
            'action' => $this->generateUrl('comment.new'),
            'method' => 'POST'
        ]
        );
        
        return $this->render('website/pages/book-detail.html.twig', [
            'book' => $book,
            'form'=> $form->createView()
        ]);
    }
}
