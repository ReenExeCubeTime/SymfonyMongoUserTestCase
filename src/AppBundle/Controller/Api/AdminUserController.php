<?php

namespace AppBundle\Controller\Api;

use AppBundle\Document\User;
use AppBundle\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminUserController extends Controller
{
    public function addAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(new UserType(), $user);

        $form->submit($request);

        /* @var $dm DocumentManager */
        $dm = $this->get('doctrine_mongodb')->getManager();

        $dm->persist($user);
        $dm->flush();

        return new JsonResponse([
            'success' => true
        ]);
    }
}
