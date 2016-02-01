<?php

namespace Tests\AppBundle\Controller\Api;

use AppBundle\Document\User;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();

        $container = static::$kernel->getContainer();

        /* @var $registry ManagerRegistry */
        $registry = $container->get('doctrine_mongodb');

        /* @var $manager DocumentManager */
        $manager = $registry->getManager();

        $manager->getDocumentDatabase(User::class)->drop();

        $userManager = $container->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $user
            ->setUsername('admin')
            ->setPlainPassword('empty')
            ->setRoles(['ROLE_ADMIN']);

        $userManager->updateUser($user);
    }

    public function test()
    {
        $this->client->request('POST', '/api/login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponse([
            'success' => false
        ]);

        $this->client->request('POST', '/api/login', [
            'username' => 'admin',
            'password' => 'empty',
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponse([
            'success' => true
        ]);

        $this->client->request('POST', '/api/logout');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponse([
            'success' => true
        ]);

        $this->client->request('POST', '/api/logout');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponse([
            'success' => false
        ]);
    }

    private function assertResponse(array $expected)
    {
        $this->assertSame(
            json_decode($this->client->getResponse()->getContent(), true),
            $expected
        );
    }
}
