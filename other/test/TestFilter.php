<?php
use Zend\I18n\Filter\Alpha;
use Zend\Filter\DateTimeFormatter;
use Zend\Validator\Date;
include 'init_autoloader.php';

// $str='totototot';

// $filtre=new Alpha();

// $valeurFiltre=$filtre->filter($str);

// var_dump($valeurFiltre);

$filtre = new DateTimeFormatter();
$date = $filtre->filter('12-12-2014');
$validator = new Date();
var_dump($validator->isValid($date));