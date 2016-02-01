<?php

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

abstract class ApiAbstractControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    protected function assertResponse(array $expected)
    {
        $this->assertSame(
            json_decode($this->client->getResponse()->getContent(), true),
            $expected
        );
    }
}
