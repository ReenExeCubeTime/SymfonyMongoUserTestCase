<?php

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminUserControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testAdd()
    {
        $this->client->request('PUT', '/api/admin/user', [
            'user' => [
                'username' => 'Reen',
                'plain_password' => 'Execute',
            ]
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame($this->client->getResponse()->getContent(), '{"success":true}');
    }

    public function testGet()
    {
        $this->client->request('GET', '/api/admin/user/Reen');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(
            json_decode($this->client->getResponse()->getContent(), true),
            [
                'success' => true,
                'data' => [
                    'user' => [
                        'username' => 'Reen'
                    ]
                ]
            ]
        );
    }
}
