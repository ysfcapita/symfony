<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'Home')]
    public function index(Request $request): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'route_name' => $request->attributes->get('_route')
        ]);
    }

    #[Route('/login', name: 'Login')]

    public function login(string $_route): Response
    {
        return $this->render('home/login.html.twig', [
            'controller_name' => 'LoginController',
            'route_name' => $_route
        ]);
    }

}