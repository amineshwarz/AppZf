<?php

putenv('ZF2_PATH='.__DIR__.'/../vendor/zendframework/zendframework/library');
include '../init_autoloader.php';

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

class TestAuthAdapter implements AdapterInterface{
	
	protected $log;
	protected $pass;
	/**
	 * Sets username and password for authentication
	 *
	 * @return void
	 */
	public function __construct($username, $password) {
		$this->log=$username;
		$this->pass=$password;
	}

	/**
	 * Performs an authentication attempt
	 *
	 * @return \Zend\Authentication\Result
	 * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
	 *               If authentication cannot be performed
	 */
	public function authenticate() {
		//test de l'authentification
		//elle a réeussir
		$result=new Result(Result::SUCCESS,$this->log);
		return $result;
	}
}

$auth=new AuthenticationService();
$auth->setAdapter(new TestAuthAdapter('log','pass'));
$auth->setStorage(new Session());

if($auth->hasIdentity()){
	echo 'Ok authentifier '.$auth->getIdentity().'<br>';
	$auth->clearIdentity();	
			
}else {
	$auth->setAdapter(new TestAuthAdapter('log', 'pass'));
	$r =$auth->authenticate();
	if($r->isValid())
		echo'bienvenu<br>';
}

