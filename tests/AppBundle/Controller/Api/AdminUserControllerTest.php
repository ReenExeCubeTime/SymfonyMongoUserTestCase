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

    public function testAnonymous()
    {
        $this->client->request('PUT', '/api/admin/user', [
            'user' => [
                'username' => 'Reen',
                'plain_password' => 'Execute',
            ]
        ]);

        $this->assertEquals(500, $this->client->getResponse()->getStatusCode());
    }

    public function testAdd()
    {
        $this->login();
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
     * @dataProvider addValidationDataProvider
     * @param $username
     * @param $message
     */
    public function testAddValidation($username, $message)
    {
        $this->login();
        $this->client->request('PUT', '/api/admin/user', [
            'user' => [
                'username' => $username
            ]
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponse(
            [
                'success' => false,
                'errors' => [
                    'username' => $message
                ]
            ]
        );
    }

    public function addValidationDataProvider()
    {
        yield [
            '',
            'This field is required'
        ];

        yield [
            'a',
            'This field must be at least 3 characters long'
        ];
    }

    /**
     * @dataProvider getDataProvider
     * @param $username
     * @param array $response
     */
    public function testGet($username, array $response)
    {
        $this->login();
        $this->client->request('GET', "/api/admin/user/$username");

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponse(
            $response
        );
    }

    public function getDataProvider()
    {
        $successResponse = [
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

        yield [
            'reen',
            $successResponse
        ];

        yield [
            'someAbsent',
            [
                'success' => false,
                'data' => [
                    'user' => null
                ]
            ]
        ];
    }

    public function testUpdateValidate()
    {
        $this->login();
        $this->client->request('POST', '/api/admin/user/Reen', [
            'user' => [
                'username' => 'E'
            ]
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponse(
            [
                'success' => false,
                'errors' => [
                    'username' => 'This field must be at least 3 characters long'
                ]
            ]
        );
    }

    public function testUpdate()
    {
        $this->login();
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

    private function login()
    {
        $this->client->request('POST', '/api/login', [
            'username' => 'admin',
            'password' => 'empty',
        ]);
    }
}
