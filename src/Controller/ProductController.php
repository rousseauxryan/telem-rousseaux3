<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * Controller qui sert une page contenant tous les produits
     */
    #[Route(path:'/product/show-all', name:'product_show_all')]
    public function showall(ProductRepository $productRepository){

        // il faut récupérer tous les produits de la bdd
        $products = $productRepository->findAll();
        // il faut construire une page HTML avec les produits récupérés

        return $this->render('base.html.twig',['products'=>$products]);
        // il faut retourner cette page

    }

}