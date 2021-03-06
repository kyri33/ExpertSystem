<?php

	if (isset($argv[1]))
	{
		/* Error variable to exit loop when syntax error is found */
		$err = false;
		$line = "";

		/* Variable to store line number for errors */
		$lineNo = 0;

		/* Array to store all variables and propositions*/
		$vars = array();
		$cmd = array();

		/*
		 * Open the file given as argument
		 */
		if (!($fd = fopen('file.txt', 'r')))
			die("Error opening file, please make sure file exists".PHP_EOL);

		while (($line = fgets($fd)) && !$err)
		{
			$lineNo++;
			$line = preg_replace("/\s+/", "", $line);
			$line = remove_comments($line);

			if ($line[0] != '#')
				array_push($cmd, $line);
		}
	}
	else
	{
		print("No file specified".PHP_EOL);
	}

	function remove_comments($line)
	{
		$newLine = $line;
		if ($start = strpos($line, '#'))
		{
			$newLine = substr($line, 0, $start);
			if ($end = strpos($line, '#', $start + 1))
				$newLine = $newLine . substr($line, $start + 1, $end - $start - 1);
		}
		return $newLine;
	}

	function store_variables($line)
	{
		
	}

?>
