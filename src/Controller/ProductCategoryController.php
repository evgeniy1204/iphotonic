<?php

namespace App\Controller;

use App\Repository\ProductCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductCategoryController extends AbstractController
{
    public function __construct(
        private readonly ProductCategoryRepository $productCategoryRepository
    )
    {
    }

    #[Route('/product/category', name: 'app_product_category')]
    public function index(): Response
    {
        $productCategories = $this->productCategoryRepository->findParentCategories();

        return $this->render('product_category/index.html.twig', [
            'categories' => $productCategories,
        ]);
    }
}
