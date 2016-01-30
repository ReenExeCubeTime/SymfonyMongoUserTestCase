<?php

namespace AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminUserController extends Controller
{
    public function addAction()
    {
        return new JsonResponse([
            'success' => true
        ]);
    }
}
