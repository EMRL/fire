<?php

use Fire\Model\RepositoryFactory;
use Fire\Model\EntityManager;
use Fire\Model\Post\PostRepository;
use Fire\Model\Post\Post;

class PostRepositoryTest extends WP_UnitTestCase {

	protected $repo;

	public function setUp()
	{
		parent::setUp();

		$factory = new RepositoryFactory;
		$factory->registerRepository('Post', 'Fire\Model\Post\PostRepository');

		$this->repo = new PostRepository(new EntityManager($factory));
	}

	public function testLoadsPostOfId()
	{
		$id = $this->factory->post->create();

		$post = $this->repo->postOfId($id);

		$this->assertInstanceOf('Fire\Model\Post\Post', $post);
		$this->assertEquals($id, $post->id());
	}

	public function testLoadsPostofSlug()
	{
		$this->factory->post->create(['post_name' => 'testing']);

		$post = $this->repo->postOfSlug('testing');

		$this->assertInstanceOf('Fire\Model\Post\Post', $post);
		$this->assertEquals('testing', $post->slug());
	}

	public function testInvalidIdReturnsNull()
	{
		$post1 = $this->repo->postOfId(0);
		$post2 = $this->repo->postOfSlug('non-existant');

		$this->assertEmpty($post1);
		$this->assertEmpty($post2);
	}

	public function testParentLoads()
	{
		$parentId = $this->factory->post->create([
			'post_title' => 'Parent'
		]);
		
		$childId = $this->factory->post->create([
			'post_title'  => 'Child',
			'post_parent' => $parentId,
		]);

		$child = $this->repo->postOfId($childId);

		$this->assertEquals($parentId, $child->parent()->id());
	}

}