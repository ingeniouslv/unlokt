<body>
<?php
$value = explode("\n", $value);

foreach ($value as $line):
	echo '<p> ' . $line . "</p>\n";
endforeach;
?>
</body>