<?php

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminAuthControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('POST', '/api/auth');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame($client->getResponse()->getContent(), '[]');
    }
}
