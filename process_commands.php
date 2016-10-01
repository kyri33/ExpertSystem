<?php

	function get_facts(&$cmd, &$vars, &$query)
	{
		$k = 0;
		while ($cmd[$k])
		{
			$line = $cmd[$k];
			if ($line[0] == '=' || ($line[0] == '!' && $line[1] == '='))
			{
				$i = 1;
				if ($line[0] == '=')
					$flag = 1;
				else if ($line[0] == '!')
				{
					$flag = 0;
					$i++;
				}
				else
					die ("Parse error near ".$line.PHP_EOL);

				while ($line[$i])
				{
					$vars[$line[$i]] = $flag;
					$i++;
				}
				array_splice($cmd, $k, 1);
				$k--;
			}
			else if ($line[0] == '?')
			{
				$i = 1;
				while ($line[$i])
				{
					$query[$line[$i]] = -1;
					$i++;
				}
				array_splice($cmd, $k, 1);
				$k--;
			}
			$k++;
		}
	}

	function left(&$implies)
	{
		$brackets = preg_split("/[()]+/", $implies[0], -1, PREG_SPLIT_NO_EMPTY);
		//preg_match_alL('#[^\)]+|[$\(]+#', $implies[0], $brackets);
		print_r($brackets);
		return true;
	}

	function process_commands($cmd, &$vars)
	{
		$i = 0;
		while ($cmd[$i])
		{
			$implies = preg_split('/=>/', $cmd[$i]);
			if (left($implies))
				;
			$i++;
		}
	}

?>
