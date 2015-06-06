<?php

namespace Fire\Foundation;

class MetaDataParser implements MetaDataParserInterface {

	public function parse($content)
	{
		$data = [];

		if (preg_match_all('/@(\w+)([^@\*]+)?/', $content, $matches))
		{
			$data = array_combine(
				array_map('trim', $matches[1]),
				array_map('trim', $matches[2])
			);

			foreach ($data as $key => $value)
			{
				$args = [];

				if ($value and $value[0] === '(')
				{
					// Trim parenthesis
					$value = trim($value, '()');

					// Split arguments by comma
					$value = explode(',', $value);

					// Loop argument pairs (key=value)
					foreach ($value as $v)
					{
						// Split key from value
						list($k, $v) = explode('=', $v);

						// Add key to arguments and trim quotes from value
						$args[trim($k)] = trim($v, '\'"');
					}
				}
				elseif ($value)
				{
					$args = array_map('trim', explode(',', $value));
				}

				// Overwrite key with new args
				$data[$key] = new MetaData($args);
			}
		}

		return new MetaData($data);
	}

}