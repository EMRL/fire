<?php

use Fire\Model\RepositoryFactory;
use Fire\Model\EntityManager;
use Fire\Model\Page\PagePostType;
use Fire\Model\Page\PageEntityMapper;
use Fire\Model\Page\PageRepository;
use Fire\Model\Page\Page;

class PageRepositoryTest extends WP_UnitTestCase {

	protected $repo;

	public function setUp()
	{
		parent::setUp();

		$factory = new RepositoryFactory;
		$em      = new EntityManager($factory);
		$mapper  = new PageEntityMapper($em);
		$repo    = new PageRepository($mapper, PagePostType::TYPE);

		$factory->registerRepository(PagePostType::TYPE, $repo);

		$this->repo = $repo;
	}

	public function testLoadsPageOfId()
	{
		$id = $this->factory->post->create(['post_type' => PagePostType::TYPE]);

		$page = $this->repo->pageOfId($id);

		$this->assertInstanceOf('Fire\Model\Page\Page', $page);
		$this->assertEquals($id, $page->id());
	}

	public function testLoadsPageofSlug()
	{
		$this->factory->post->create([
			'post_type' => PagePostType::TYPE,
			'post_name' => 'testing'
		]);

		$page = $this->repo->pageOfSlug('testing');

		$this->assertEquals('testing', $page->slug());
	}

	public function testFind()
	{
		$this->factory->post->create_many(2, ['post_type' => PagePostType::TYPE]);

		$results = $this->repo->find();

		$this->assertEquals(2, $results->count());
	}

}