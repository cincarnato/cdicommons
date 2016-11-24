<?php

namespace namespaces\Form;

use Zend\Form\Form;

class FormName extends \Zend\Form\Form {

      /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    
    
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
        parent::__construct('FormName');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form-horizontal");
        $this->setAttribute('role', "form");
        $this->setAttribute('action', "/url|javascript");
        
        
        //PUT YOUR ELEMENTS
        
        
        //BASE
        
        
        //$this->addCsrf(); //Optional security
        
        $this->addSubmit();
        
    }

    protected function addSubmit($value = "submit") {

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => $value
            )
        ));
    }

    protected function addCsrf() {
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));
    }

    function getEm() {
        return $this->em;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }


}
