<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("admin/category/new", name="category-create")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, ['label' => 'Create']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('category-list');
        }
        return $this->render('category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/category/{id}", name="category-read")
     * @param Category $category
     * @return Response
     */
    public function read(Category $category): Response
    {
        return $this->render('category/read.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/admin/category/edit/{id}", name="category-edit")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $category = $entityManager->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class, $category, ['label' => 'Update']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('category-list');
        }
        return $this->render('category/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/category/delete/{id}", name="category-delete", methods={"GET", "DELETE"})
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(EntityManagerInterface $entityManager, $id): Response
    {
        $article = $entityManager->getRepository(Category::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute('category-list');
    }

    /**
     * @Route("/admin/category", name="category-list")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function list(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();
        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }
}
