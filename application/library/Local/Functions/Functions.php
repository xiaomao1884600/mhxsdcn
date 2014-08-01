<?php
//暂时定义debug

/**
 * Prints out debug information about given variable.
 *
 * @param string $var Variable to show debug information for.
 * @param boolean $exit If set to true, exit.
 * @param boolean $showFrom If set to true, the method prints from where the function was called.
 * @param boolean $showHtml If set to true, the method prints the debug data in a screen-friendly way.
 */
function debug($var = '', $exit = false, $showFrom = true, $showHtml = false)
{
	if ($showFrom)
	{
		$calledFrom = debug_backtrace();
		echo '<strong>' . $calledFrom[0]['file'] . '</strong>';
		echo ' (line <strong>' . $calledFrom[0]['line'] . '</strong>)';
	}
	echo "\n<pre>\n";

	$var = print_r($var, true);
	if ($showHtml)
	{
		$var = str_replace('<', '&lt;', str_replace('>', '&gt;', $var));
	}
	echo $var . "\n</pre>\n";

	if ($exit)
	{
		exit();
	}
}

function x($var = '')
{
	$calledFrom = debug_backtrace();
	echo '<strong>' . $calledFrom[0]['file'] . '</strong>';
	echo ' (line <strong>' . $calledFrom[0]['line'] . '</strong>)';
	echo "\n<pre>\n";
	$var = print_r($var, true);
	echo $var . "\n</pre>\n";
	exit();
}