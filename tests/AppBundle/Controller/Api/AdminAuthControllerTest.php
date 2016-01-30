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

        /* @var $registry ManagerRegistry */
        $registry = static::$kernel->getContainer()->get('doctrine_mongodb');

        /* @var $manager DocumentManager */
        $manager = $registry->getManager();

        $manager->getDocumentDatabase(User::class)->drop();
    }

    public function testIndex()
    {
        $this->client->request('POST', '/api/auth');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame($this->client->getResponse()->getContent(), '[]');
    }
}
