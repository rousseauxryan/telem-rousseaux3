<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * Controller qui sert une page contenant tous les produits
     */
    #[Route(path:'/product/show-all', name:'product_show_all')]
    public function showall(ProductRepository $productRepository):Response{

        // il faut récupérer tous les produits de la bdd
        $products = $productRepository->findAll();
        // il faut construire une page HTML avec les produits récupérés

        return $this->render('product/product_show_all.html.twig',['products'=>$products]);
        // il faut retourner cette page

    }


    /**
     * controleur qui sert une page contenant la fiche d'un produit
     */

    #[Route(path: '/product/show/{id}', name: 'product_show', requirements: ['id'=>'\d+'])]
    public function show(int $id, ProductRepository $productRepository):Response{


        $product = $productRepository->find($id);

        if (null == $product){
            throw new NotFoundHttpException('Ce produit n\'existe pas');
        }



        return $this->render('product/product_show.html.twig', ['product'=>$product
        ]);
    }

}