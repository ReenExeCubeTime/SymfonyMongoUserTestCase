<?php

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminAuthControllerTest extends WebTestCase
{
    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();

        /* @var $dm ManagerRegistry */
        $dm = static::$kernel->getContainer()->get('doctrine_mongodb');
    }

    public function testIndex()
    {
        $this->client->request('POST', '/api/auth');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame($this->client->getResponse()->getContent(), '[]');
    }
}
