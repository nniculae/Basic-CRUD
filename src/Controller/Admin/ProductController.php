<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/admin/product/new", name="product-create")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('product-list');
        }
        return $this->render('product/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/product/{id}", name="product-read")
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return Response
     */
    public function read(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->findByWithJoin($id);
//        dump($product); die;
        return $this->render('product/read.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/admin/product/edit/{id}", name="product-edit")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProductType::class, $product, ['label' => 'Update']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('product-list');
        }
        return $this->render('product/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/product/delete/{id}", name="product-delete", methods={"GET", "DELETE"})
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(EntityManagerInterface $entityManager, $id): Response
    {
        $article = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute('product-list');
    }

    /**
     * Show a list of products
     * @Route("/admin/product", name="product-list")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function list(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Product::class)->findAll();
        if (!$products) {
            throw $this->createNotFoundException(
                'No product found'
            );
        }
        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }
}
