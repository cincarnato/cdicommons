<?php

namespace CdiCommons\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author cincarnato
 */
class CdiRenderForm extends AbstractHelper {

    public function __invoke($templateForm, $templateElement) {

        $partial = 'cdicommons/forms/' . $templateForm;
        $partialElement = 'cdicommons/forms/elements/' . $templateElement;

        return $this->view->partial($partial, array(
                    "partialElement" => $partialElement));
    }

}

?>
