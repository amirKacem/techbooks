<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    
    /**
     * a controller function to emebed the categories result
     */
    public function allCategories($class){
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('website/embed/_categories-navbar.html.twig',
            [   'class'=>$class,
                'categories'=>$categories
            ]
        );

    }


    
    /**
     * @Route("/{slug}", name="category.show", methods={"GET"})
     */
    public function show(Category $category): Response
    {   
        return $this->render('website/pages/category.html.twig', [
            'category' => $category,
        ]);
    }
}
