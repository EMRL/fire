<?php

use Fire\Model\RepositoryFactory;
use Fire\Model\EntityManager;
use Fire\Model\Page\PagePostType;
use Fire\Model\Post\PostPostType;
use Fire\Model\Post\PostEntityMapper;
use Fire\Model\Post\PostRepository;
use Fire\Model\Post\Post;

class PostRepositoryTest extends WP_UnitTestCase {

	protected $repo;

	public function setUp()
	{
		parent::setUp();

		$factory = new RepositoryFactory;
		$em      = new EntityManager($factory);
		$mapper  = new PostEntityMapper($em);
		$repo    = new PostRepository($mapper, PostPostType::TYPE);

		$factory->registerRepository(PostPostType::TYPE, $repo);

		$this->repo = $repo;
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

		$this->assertEquals('testing', $post->slug());
	}

	public function testLoadsOnlyPosts()
	{
		$id = $this->factory->post->create(['post_type' => PagePostType::TYPE]);

		$post = $this->repo->postOfId($id);

		$this->assertEmpty($post);
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

	public function testFind()
	{
		$id = $this->factory->post->create();

		$this->factory->post->create();

		$results = $this->repo->find();

		$this->assertEquals(2, $results->count());
	}

}