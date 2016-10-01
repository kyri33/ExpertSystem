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

	function left(&$str, &$vars)
	{
		if (strpos($str, '^'))
		{
			$spl = preg_split("/\^/", $str, -1, PREG_SPLIT_NO_EMPTY);
			$lef = left($spl[0], $vars);
			$right = left($spl[1], $vars);
			if (($lef == 0 && $right == 1) || ($lef == 1 && $right == 0))
				return 1;
			else
				return 0;
		}
		else if (strpos($str, '|'))
		{
			$spl = preg_split("/[|]/", $str, -1, PREG_SPLIT_NO_EMPTY);
			if (left($spl[0], $vars) == 1 || left($spl[1], $vars) == 1)
				return 1;
			else
				return 0;
		}
		else if (strpos($str, '+'))
		{
			$spl = preg_split("/[+]/", $str, -1, PREG_SPLIT_NO_EMPTY);
			$i = 0;
			while ($spl[$i] && left($spl[$i], $vars) == 1)
				$i++;
			if ($i == count($spl))
				return 1;
			else
				return 0;
		}
		else
		{
			$flag = 1;
			$i = 0;
			if ($str[0] == '!')
			{
				$flag = 0;
				$i++;
			}
			if ($vars[$str[$i]] == $flag)
				return 1;
			else
				return 0;
		}
	}

	function process_commands($cmd, &$vars)
	{
		$i = 0;
		while ($cmd[$i])
		{
			$implies = preg_split('/=>/', $cmd[$i], -1, PREG_SPLIT_NO_EMPTY);
			if (left($implies[0], $vars) == 1)
			{
				echo $implies[0]." is true".PHP_EOL;
				right($implies[1], $vars);
			}
			else
				echo $implies[0]." is false".PHP_EOL;
			$i++;
		}
	}

	function right($str, &$vars)
	{
		if (strpos($str, '|') || strpos($str, '^'))
			;
		else
		{
			if (strpos($str, '+'))
			{
				$spl = preg_split("/[+]/", $str,-1, PREG_SPLIT_NO_EMPTY);
				$i = 0;
				while ($spl[$i])
				{
					right($spl[$i], $vars);
					$i++;
				}
			}
			else
			{
				$i = 0;
				$flag = 1;
				if ($str[0] == '!')
				{
					$flag = 0;
					$i++;
				}
				$vars[$str[$i]] = $flag;
			}
		}
	}

?>
