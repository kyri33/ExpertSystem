<?php

	function get_rule(&$cmd, &$vars)
	{
		$k = 0;
		while ($cmd[$k])
		{
			$line = $cmd[$k];
			if ($line[0] == '=' || ($line[0] == '!' && $line[1] == '='))
			{
				if ($line[0] == '=')
					$flag = 1;
				else if ($line[0] == '!')
					$flag = 0;
				else
					die ("Parse error near ".$line.PHP_EOL);

				$i = 1;
				while ($line[$i])
				{
					$vars[$line[$i]] = $flag;
					$i++;
				}
			}
			$k++;
		}
	}

?>
