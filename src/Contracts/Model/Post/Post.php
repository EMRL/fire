<?php

namespace Fire\Contracts\Model\Post;

interface Post {

	public function id();
	public function setId($id);

	public function author();
	public function setAuthor($user);

	public function date();
	public function setDate($date);

	public function content();
	public function setContent($content);

	public function title();
	public function setTitle($title);

	public function excerpt();
	public function setExcerpt($excerpt);

	public function status();
	public function setStatus($status);

	public function password();
	public function setPassword($password);

	public function slug();
	public function setSlug($slug);

	public function parent();
	public function setParent($parent);

	public function type();
	public function setType($type);

}