<?php

namespace Tests\AppBundle\Service;

class UserServiceTest extends AbstractServiceTest
{
    public function test()
    {
        $this->container->get('em.user');
    }
}
