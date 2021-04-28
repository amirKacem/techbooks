<?php

namespace App\Controller;

use App\Entity\Book;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** 
 * Home Page Controller 
 **/
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home.index")
     */
    public function index(PaginatorInterface $paginator,Request $request): Response
    {   $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
        $nb_books = count($books);
        $books = $paginator->paginate(
           $books,
            $request->query->getInt('page',1),
            9
        );
        return $this->render('website/pages/home.html.twig',
        [
            'books'=>$books,
            'nb_books'=>$nb_books
        ]
        );
    }
}
