<?php
require_once('navbar-generator.php');
$navbarData = array(
    'css_class' => ' navbar navbar-expand-lg ',
    'id' => 'my-navbar',
    'style' => 'background-color: #e3f2fd ',
    'brand' => array(
        'link' => '/',
        'text' => 'Mon site'
    ),
    'links' => array(
        array(
            'link' => '/about',
            'text' => 'À propos'
        ),
        array(
            'link' => '/contact',
            'text' => 'Contact'
        )
    ),
    'search' => array(
        array(
            'placeholder' => 'Rechercher',
            'input_class' => 'form-control me-2'
        )
    )
);

$navbarGenerator = new NavbarGenerator($navbarData);
echo $navbarGenerator->generate();
