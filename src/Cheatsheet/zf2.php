<?php

/**
 * TITLE
 *
 * Description
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 *
 * @package Paquete
 */
$return = $this->redirect()->toRoute('wa', array('controller' => "Application\Controller\Wa",
    'action' => "code",
    'id' => $object->getId()));

$return = $this->forward()->dispatch('Application\Controller\Wa', [
    'action' => 'error'
        ]);
