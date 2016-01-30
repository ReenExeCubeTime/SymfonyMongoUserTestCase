<?php

namespace AppBundle\Controller\Api;

use AppBundle\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminUserController extends Controller
{
    public function addAction(Request $request)
    {
        $user = $this->get('fos_user.user_manager')->createUser();

        $form = $this->createForm(new UserType(), $user);

        $form->submit($request);

        $user->setRoles(['ROLE_DEVELOPER']);

        $this->get('fos_user.user_manager')->updateUser($user);

        return new JsonResponse([
            'success' => true
        ]);
    }
}
