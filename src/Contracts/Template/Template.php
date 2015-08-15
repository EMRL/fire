<?php

namespace Fire\Contracts\Template;

interface Template {

	public function render($key, $suffix = null, $data = []);

	public function find($key, $suffix = null);

}