<?php

namespace App\Controller\Admin;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/sub/category")
 */
class SubCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_sub_category_index", methods={"GET"})
     */
    public function index(SubCategoryRepository $subCategoryRepository): Response
    {
        return $this->render('admin/sub_category/index.html.twig', [
            'sub_categories' => $subCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_sub_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $subCategory = new SubCategory();
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subCategory);
            $entityManager->flush();

            return $this->redirectToRoute('admin_sub_category_index');
        }

        return $this->render('admin/sub_category/new.html.twig', [
            'sub_category' => $subCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_sub_category_show", methods={"GET"})
     */
    public function show(SubCategory $subCategory): Response
    {
        return $this->render('admin/sub_category/show.html.twig', [
            'sub_category' => $subCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_sub_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SubCategory $subCategory): Response
    {
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_sub_category_index');
        }

        return $this->render('admin/sub_category/edit.html.twig', [
            'sub_category' => $subCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_sub_category_delete", methods={"POST"})
     */
    public function delete(Request $request, SubCategory $subCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_sub_category_index');
    }
}
