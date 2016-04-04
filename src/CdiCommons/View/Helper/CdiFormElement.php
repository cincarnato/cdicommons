<?php

namespace CdiCommons\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author cincarnato
 */
class CdiFormElement extends AbstractHelper {

    protected $em;

    public function __invoke() {
    
    }



    function getEm() {
        return $this->em;
    }

    function setEm($em) {
        $this->em = $em;
    }

}

?>
