<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BookSearch;
use App\Entity\Comment;
use App\Form\BookSearchType;
use App\Form\CommentType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book/{slug}", name="book.show")
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

    /**
     * @Route("/books", name="books.search")
     */

     public function searchBooks(Request $request,PaginatorInterface $paginator)
    {  
      
     
        return $this->render('website/pages/books.html.twig');
    }

    


    /**
     * a controller function to emebed the books result
     */
    
    
    public function search(Request $request,PaginatorInterface $paginator,$withResult=false){
        $request =  $request->createFromGlobals();
        $bookSearch = new BookSearch();
        $form = $this->createForm(BookSearchType::class,$bookSearch);
        $form->handleRequest($request);
            $books = $paginator->paginate(
                $this->getDoctrine()->getRepository(Book::class)->findBooks($bookSearch),
                $request->query->getInt('page',1),
                9);
        return $this->render('website/embed/_search.html.twig',
            [   'books'=>$books,
                'form' => $form->createView(),
                'withResult'=>$withResult
            ]
        );
     }
}
