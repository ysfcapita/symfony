<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'Home')]
    public function index(Request $request): Response
    {
        return $this->render('home/index.html.twig', [
            'route_name' => $request->attributes->get('_route')
        ]);
    }


    // #[Route('/admin', name: 'Admin')]
    // public function admin(string $_route): Response
    // {
    //     return $this->render('home/admin.html.twig', [
    //         'route_name' => $_route
    //     ]);
    // }

    #[Route('/product/create', name: 'product_create')]
    #[Route('/product/update/{id}', name: 'product_update')]
    public function addProduct(string $_route, ProductRepository $repo, Request $req, Product $product = null): Response
    {
        // if (!$product) {
        //     if ($_route === 'product_create') {
        //         $product = new Product();
        //     } else {
        //         throw new NotFoundHttpException();
        //     }
        // }
        if ($_route === 'product_update') {
            if ($product === null) {
                // throw new NotFoundHttpException();
                return new Response($this->renderView('bundles/TwigBundle/Exception/error404.html.twig'), Response::HTTP_NOT_FOUND);
            }
        } else {
            $product = new Product();
        }

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $repo->save($product, true);
            return $this->redirectToRoute('product_list');
        }

        return $this->render('home/product.html.twig',
            [
                'route_name' => $_route,
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/product/list', name: 'product_list')]
    public function listProduct(string $_route, ProductRepository $repo): Response
    {
        $list_product = $repo->findAll();

        return $this->render('home/product_list.html.twig', [
            'route_name' => $_route,
            'list_product' => $list_product
        ]);
    }

    #[Route('/product/delete/{id}', name: 'product_delete')]
    public function deleteProduct(string $_route, ProductRepository $repo, Product $prod): Response
    {

        $repo->remove($prod, true);
        return $this->redirectToRoute('product_list');
    }
}