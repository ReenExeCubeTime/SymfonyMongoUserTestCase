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
        $this->assertResponse(
            [
                'success' => true,
            ]
        );
    }

    /**
     * @dataProvider getDataProvider
     * @param $username
     * @param array $response
     */
    public function testGet($username, array $response)
    {
        $this->client->request('GET', "/api/admin/user/$username");

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponse(
            $response
        );
    }

    public function getDataProvider()
    {
        $successResponse =             [
            'success' => true,
            'data' => [
                'user' => [
                    'username' => 'Reen'
                ]
            ]
        ];

        yield [
            'Reen',
            $successResponse
        ];
    }

    public function testUpdate()
    {
        $this->client->request('POST', '/api/admin/user/Reen', [
            'user' => [
                'username' => 'ReenExe',
                'plain_password' => 'Execute',
            ]
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponse(
            [
                'success' => true,
            ]
        );
    }

    private function assertResponse(array $expected)
    {
        $this->assertSame(
            json_decode($this->client->getResponse()->getContent(), true),
            $expected
        );
    }
}
