<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageProductController extends AbstractController
{

    #[Route('/manage/product/new', name: 'manage_product_new')]
    public function new(Request $request, EntityManagerInterface $em):Response{
        $product = new Product();

        $form = $this->createForm(
            ProductType::class,
            $product/*,
            ['action'=>$this->generateUrl('manage_product_new')]*/
        );

        $form->add('Ajouter', SubmitType::class); //permet d'ajouter un champ à ceux prévus dans la classe ProductType

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // maj date creation
            $product->setCreateAt( new \DateTimeImmutable());

            // persister l'objet en bdd
            $em->persist($product);
            // synchro des objets persistés dans la bdd : le produit est inséré dans la bdd
            $em->flush();

            $this->addFlash('success', 'Le produit a été ajouté au catalogue.');

            // on redirige l'utilisateur
            return $this->redirectToRoute('product_show_all');


        }

        return $this->renderForm('product/product_new.html.twig',
            [
                'form'=>$form
            ]

        );
    }

}