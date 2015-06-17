<?php
use Zend\I18n\Validator\Alpha;
include 'init_autoloader.php';



$str='toto4';

$validator=new Alpha();
if($validator->isValid($str)){
	echo"c'est une chaine alphabétique";
	
}else {
	$msg=$validator->getMessages();
	var_dump($msg);
}