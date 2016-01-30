<?php

namespace AppBundle\Document;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $username;

    /**
     * @MongoDB\String
     */
    protected $salt;

    /**
     * @MongoDB\String
     */
    protected $password;

    /**
     * @MongoDB\Collection
     */
    protected $roles;
}
