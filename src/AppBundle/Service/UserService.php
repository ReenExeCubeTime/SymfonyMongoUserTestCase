<?php

namespace AppBundle\Service;

use AppBundle\Document\User;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;

class UserService
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * UserService constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function add(User $user)
    {
        /* @var $dm DocumentManager */
        $dm = $this->registry->getManager();

        $dm->persist($user);
        $dm->flush();
    }
}
