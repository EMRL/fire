<?php

use Fire\Model\RepositoryFactory;
use Fire\Model\EntityManager;
use Fire\Model\User\UserEntityMapper;
use Fire\Model\User\UserRepository;
use Fire\Model\User\User;

class UserRepositoryTest extends WP_UnitTestCase
{
    protected $repo;

    public function setUp()
    {
        parent::setUp();

        $factory = new RepositoryFactory;
        $em      = new EntityManager($factory);
        $mapper  = new UserEntityMapper($em);
        $repo    = new UserRepository($mapper);

        $factory->registerRepository('user', $repo);

        $this->repo = $repo;
    }

    public function testLoadsUserOfId()
    {
        $id = $this->factory->user->create();

        $user = $this->repo->userOfId($id);

        $this->assertInstanceOf('Fire\Model\User\User', $user);
        $this->assertEquals($id, $user->id());
    }

    public function testLoadsUserOfUsername()
    {
        $this->factory->user->create(['user_login' => 'testing']);

        $user = $this->repo->userOfUsername('testing');

        $this->assertEquals('testing', $user->username());
    }

    public function testLoadsUserOfEmail()
    {
        $this->factory->user->create(['user_email' => 'test@test.com']);

        $user = $this->repo->userOfEmail('test@test.com');

        $this->assertEquals('test@test.com', $user->email());
    }

    public function testFind()
    {
        $id = $this->factory->user->create();

        $this->factory->user->create();

        $results = $this->repo->find();

        // There is always an admin user, so we add one more to our created
        $this->assertEquals(3, $results->count());
    }
}
