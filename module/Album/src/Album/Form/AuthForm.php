<?php
namespace Album\Form;

use Zend\Form\Form; 

class AuthForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('auth'); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'login',  
            'attributes' => array( 
				'type' => 'text',
                'placeholder' => 'Votre identifiant ', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => ' Identifiant : ', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'password', 
            'attributes' => array( 
				'type' => 'password',
                'placeholder' => 'Votre mot de passe', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Mot de passe :  ' , 
            ), 
        )); 
 
		$this->add(array( 
            'name' => 'submit', 
            'attributes' => array( 
				'type' => 'submit',
                'value' => 'Connexion', 
				'id' => 'submitbutton',
            ), 
        )); 
		
		
    } 
} 