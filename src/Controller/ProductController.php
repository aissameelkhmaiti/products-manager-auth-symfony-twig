<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/products')]
class ProductController extends AbstractController
{
      // =========================
    // CREATE (form Twig)
    // =========================
    #[Route('/product/create', name: 'product_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();

        $product->setName($request->request->get('name'));
        $product->setPrice((float) $request->request->get('price'));
        $product->setQuantity((int) $request->request->get('quantity'));
        $product->setDescription($request->request->get('description'));

        $em->persist($product);
        $em->flush();

        $this->addFlash('success', 'Produit ajouté avec succès');

        return $this->redirectToRoute('app_dashboard');
    }

    // =========================
    // EDIT FORM (page edit)
    // =========================
    #[Route('/product/{id}/edit', name: 'product_edit', methods: ['GET'])]
    public function edit(Product $product): Response
    {
        return $this->render('product/edit.html.twig', [
            'product' => $product
        ]);
    }

    // =========================
    // UPDATE (submit edit form)
    // =========================
    #[Route('/product/{id}/update', name: 'product_update', methods: ['POST'])]
    public function update(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        $product->setName($request->request->get('name'));
        $product->setPrice((float) $request->request->get('price'));
        $product->setQuantity((int) $request->request->get('quantity'));
        $product->setDescription($request->request->get('description'));

        $em->flush();

        $this->addFlash('success', 'Produit modifié avec succès');

        return $this->redirectToRoute('app_dashboard');
    }

    // =========================
    // DELETE
    // =========================
    #[Route('/product/{id}/delete', name: 'product_delete', methods: ['GET'])]
    public function delete(Product $product, EntityManagerInterface $em): Response
    {
        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'Produit supprimé');

        return $this->redirectToRoute('app_dashboard');
    }
}