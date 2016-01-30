<?php

namespace AppBundle\Controller\Api;

use AppBundle\Document\User;
use AppBundle\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationInterface;

class AdminUserController extends Controller
{
    public function addAction(Request $request)
    {
        $user = $this->get('fos_user.user_manager')->createUser();

        if ($response = $this->progress($request, $user)) {
            return $response;
        }

        $user->setRoles(['ROLE_DEVELOPER']);

        $this->get('fos_user.user_manager')->updateUser($user);

        return new JsonResponse([
            'success' => true
        ]);
    }

    public function getAction($username)
    {
        $user = $this->get('fos_user.user_manager')->findUserByUsername($username);

        return new JsonResponse([
            'success' => (bool)$user,
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function updateAction(Request $request, $username)
    {
        $user = $this->get('fos_user.user_manager')->findUserByUsername($username);

        if ($response = $this->progress($request, $user)) {
            return $response;
        }

        $this->get('fos_user.user_manager')->updateUser($user);

        return new JsonResponse([
            'success' => true
        ]);
    }

    public function progress(Request $request, User $user)
    {
        $form = $this->createForm(new UserType(), $user);

        $form->submit($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if ($errors->count()) {
            /* @var $errors ConstraintViolationInterface[] */
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }

            return new JsonResponse([
                'success' => false,
                'errors' => $messages,
            ]);
        }

        return false;
    }
}
