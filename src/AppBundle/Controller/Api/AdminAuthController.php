<?php

namespace AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminAuthController extends Controller
{
    public function mainAction()
    {
        return new JsonResponse([]);
    }
}
