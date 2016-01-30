<?php

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminUserControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('PUT', '/api/admin/user', [
            'user' => [
                'username' => 'Reen',
                'plain_password' => 'Execute',
            ]
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame($client->getResponse()->getContent(), '{"success":true}');
    }
}
