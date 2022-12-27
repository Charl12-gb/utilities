<?php

require_once('css-generator.php');
$cssGenerator = new CSSGenerator();

$cssGenerator->addRule('body', array(
    'background-color' => '#E6EFF2',
    'color' => 'black'
));

$cssGenerator->addRule('#my-id', array(
    'color' => 'blue',
    'font-size' => '18px'
));

echo '<style>' . $cssGenerator->getCSS() . '</style>';
