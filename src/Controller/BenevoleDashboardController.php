<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BenevoleDashboardController extends AbstractController
{
    #[Route('/benevole', name: 'app_benevole_dashboard')]
    public function index(): Response
    {
        return $this->render('benevole/dashboard.html.twig');
    }
}
