<?php

use Fire\Model\Post\Post;

class PostTest extends WP_UnitTestCase {

	public function testCanInstanciate()
	{
		$this->assertInstanceOf('Fire\Model\Post\Post', new Post);
	}

	public function testCanSetValuesInConstruct()
	{
		$post = new Post([
			'title'   => 'This is the "title"',
			'content' => 'Content here',
		]);

		$this->assertEquals('This is the &#8220;title&#8221;', $post->title());
		$this->assertEquals("<p>Content here</p>\n", $post->content());
	}

	public function testParent()
	{
		$parent = new Post([
			'id' => 1,
		]);

		$child = new Post([
			'id'     => 2,
			'parent' => $parent,
		]);

		$this->assertEquals($parent, $child->parent());
	}

}