<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/new", name="comment.new")
     */
    public function new(Request $request): Response
    {   
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
       
        $book_id = $request->get('book_id');
        $book = $this->getDoctrine()->getRepository(Book::class)->find($book_id);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setBook($book);
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($comment);
            $entityManager->flush();
     
            return $this->redirectToRoute('book.show',['slug'=>$book->getSlug()]);
        }

        return new Response('Invalid Data',400);
    }
}
