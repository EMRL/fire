<?php

if ( ! function_exists('add_hooks'))
{
	function add_hooks($hooks, $callback, $priority, $accepted_args, $type = 'filter')
	{
		$function = "add_$type";

		if ( ! is_array($hooks))
		{
			$hooks = array_map('trim', preg_split('/[,\s]+/', $hooks));
		}

		foreach ($hooks as $hook)
		{
			$function($hook, $callback, $priority, $accepted_args);
		}
	}
}

if ( ! function_exists('add_actions'))
{
	function add_actions($actions, $callback, $priority = NULL, $accepted_args = 1)
	{
		add_hooks($actions, $callback, $priority, $accepted_args, 'action');
	}
}

if ( ! function_exists('add_filters'))
{
	function add_filters($filters, $callback, $priority = NULL, $accepted_args = 1)
	{
		add_hooks($filters, $callback, $priority, $accepted_args, 'filter');
	}
}