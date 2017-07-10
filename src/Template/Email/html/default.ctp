<?php
/**
 * @var string $content The email content.
 */
$content = explode("\n", $content);

foreach ((array)$content as $line):
    echo '<p> ' . $line . "</p>\n";
endforeach;
