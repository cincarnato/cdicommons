<?php

namespace CdiNamespace\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class EmController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    function getEm() {
        return $this->em;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

}
