<?php

namespace App\Controller\Api\V1\Product;

use App\Entity\Id;
use App\Product\Entity\Category;
use App\Product\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    #[Route('/product', name: 'product', methods: ['POST'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $parent = new Category(Id::generate(), 'категория', null);
        $category = new Category(Id::generate(), 'категория дочерняя', $parent);

        $product = new Product(Id::generate(), 'товар');

        // relates this product to the category
        $product->setCategory($category);

        $entityManager->persist($parent);
        $entityManager->persist($category);
        $entityManager->persist($product);
        $entityManager->flush();

        return new Response(
            'Saved new product with id: '.$product->getId()
            .' and new category with id: '.$category->getId()
            .' and new category with id: '.$parent->getChildren()->first()->getId()
        );
    }

    #[Route('/product', name: 'get.product', methods: ['GET'])]
    public function get(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Product::class)->findAll();
        $categories = $entityManager->getRepository(Category::class)->findAll();

        foreach ($categories as $category) {
            var_dump($category);
        }

        return $this->json([
            $products
        ]);
    }
}