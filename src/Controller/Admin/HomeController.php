<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Comment;
use App\Repository\BookRepository;
use App\Repository\StatisticsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{   

    public function __construct(EntityManagerInterface   $em){
            $this->em = $em;
    }

    /**
     * @Route("/admin/home", name="admin.home")
     */
    public function index(): Response
    {   
       
        $comments = $this->em->getRepository(Comment::class)->findLastComments(5);
        $statistics = $this->em->getRepository(Book::class)->getBooksStatistcs();
      
        return $this->render('admin/home/index.html.twig',
            [ 
                'comments' => $comments,
                'statistcis'=>$statistics
            ]
        );
    }
}
