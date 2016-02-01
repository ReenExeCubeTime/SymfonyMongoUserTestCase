<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if (empty($username) || empty($password)) {
            return new JsonResponse([
                'success' => false
            ]);
        }

        $user = $this
            ->get('fos_user.user_manager')
            ->findUserByUsername($username);

        if (empty($user)) {
            return new JsonResponse([
                'success' => false
            ]);
        }

        $isValid = $this
            ->get('security.encoder_factory')
            ->getEncoder($user)
            ->isPasswordValid(
                $user->getPassword(),
                $password,
                $user->getSalt()
            );

        if (empty($isValid)) {
            return new JsonResponse([
                'success' => false
            ]);
        }

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));

        return new JsonResponse([
            'success' => true
        ]);
    }

    public function logoutAction()
    {
        $user = $this->getUser();

        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();

        return new JsonResponse([
            'success' => (bool)$user
        ]);
    }
}
