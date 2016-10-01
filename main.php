<?php

require_once('process_commands.php');

if (isset($argv[1]))
{
	/* Error variable to exit loop when syntax error is found */
	$err = false;
	$line = "";

	/* Variable to store line number for errors */
	$lineNo = 0;

	/* Array to store all variables, propositions and queries*/
	$vars = array();
	$cmd = array();
	$query = array();

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
	store_variables($cmd, $vars);
	get_facts($cmd, $vars, $query);
	process_commands($cmd, $vars);
	process_query($query, $vars);
}
else
{
	print("No file specified".PHP_EOL);
}

function process_query($query, $vars)
{
	$i = 0;
	while ($query[$i])
	{
		if ($vars[$query[$i]] == 1)
			echo $query[$i]." is True".PHP_EOL;
		else if ($vars[$query[$i]] == 0)
			echo $query[$i]." is False".PHP_EOL;
		else
			echo $query[$i]." is undertermined".PHP_EOL;
		$i++;
	}
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

function store_variables($cmds, &$vars)
{
	$k = 0;
	while ($cmds[$k])
	{
		$line = $cmds[$k];
		$i = 0;
		while ($i < strlen($line))
		{
			if (ctype_alpha($line[$i]))
				$vars[$line[$i]] = 0;
			$i++;
		}
		$k++;
	}
}

?>
