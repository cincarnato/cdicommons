<?php

namespace CdiNamespace\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class GridController extends AbstractActionController {

    /**
     * Description
     * 
     * @var \CdiDataGrid\Grid 
     */
    protected $grid;

    function getGrid() {
        return $this->grid;
    }

    function setGrid(\CdiDataGrid\Grid $grid) {
        $this->grid = $grid;
    }

    function __construct(\CdiDataGrid\Grid $grid) {

        $this->grid = $grid;
    }

}
