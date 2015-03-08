<?php

namespace CdiCommons\Form;

use Zend\Form\Form;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

class BaseForm extends \CdiCommons\Form\ProvidesEventsForm
{
   
    
    
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
    
}
