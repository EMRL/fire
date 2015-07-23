<?php

use Fire\Model\Page\Page;

class PageTest extends PHPUnit_Framework_TestCase {

	public function testCreateEmptyPost()
	{
		$this->assertInstanceOf('Fire\Model\Page\Page', new Page);
	}

	public function testCanSetValuesInConstruct()
	{
		$page = new Page([
			'title'   => 'This is the "title"',
			'content' => 'Content here',
		]);

		$this->assertEquals('This is the &#8220;title&#8221;', $page->title());
		$this->assertEquals("<p>Content here</p>\n", $page->content());
	}

}