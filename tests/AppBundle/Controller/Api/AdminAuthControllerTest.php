<?php

namespace Tests\AppBundle\Controller\Api;

use AppBundle\Document\User;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminAuthControllerTest extends WebTestCase
{
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

    public function testIndex()
    {
        $this->client->request('POST', '/api/auth');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame($this->client->getResponse()->getContent(), '[]');
    }
}
