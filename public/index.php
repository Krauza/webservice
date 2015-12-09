<?php

require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../src/mvc/views');
$twig = new Twig_Environment($loader, array(
    //'cache' => '../cache',
    'cache' => false
));

echo $twig->render('index.html.twig', array('name' => 'Mateusz'));
