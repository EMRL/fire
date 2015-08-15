<?php

namespace Fire\Template;

use Fire\Contracts\Template\Template as TemplateContract;
use Fire\Contracts\Template\TemplateFinder as TemplateFinderContract;

class Template implements TemplateContract {

	protected $finder;

	public function __construct(TemplateFinderContract $finder)
	{
		$this->finder = $finder;
	}

	public function render($key, $suffix = null, $data = [])
	{
		global $posts, $post, $wp_did_header,$wp_query, $wp_rewrite, $wpdb,
		       $wp_version, $wp, $id, $comment, $user_ID;

		if (is_array($suffix))
		{
			$data   = $suffix;
			$suffix = null;
		}

		$path = $this->finder->find($key, $suffix);

		if (is_array($wp_query->query_vars))
		{
			extract($wp_query->query_vars, EXTR_SKIP);
		}

		extract($data, EXTR_SKIP);

		ob_start();
		include $path;
		return ob_get_clean();
	}

	public function partial($key, $suffix = null, $data = [])
	{
		$partialPath = apply_filters('fire/template/partialPath', 'partials');

		return $this->render(trailingslashit($partialPath).$key, $suffix, $data);
	}

	public function find($key, $suffix = null)
	{
		$templates = [$key];

		if ($suffix)
		{
			array_unshift($templates, "{$key}-{$suffix}");
			array_unshift($templates, "{$key}.{$suffix}");
		}

		foreach ($templates as $template)
		{
			if ($found = $this->finder->find($template))
			{
				break;
			}
		}

		return $found;
	}

}