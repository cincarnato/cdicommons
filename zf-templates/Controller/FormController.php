<?php

namespace CdiNamespace\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Description of NameController
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class NameController extends AbstractActionController {

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

    public function formAction() {

        //FORM
        $form = new \CdiUser\Form\LostPassword();

        //HIDRATOR-IF NEED
        $form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEm()));

        //BIND OBJECT - IF NEED
        $form->bind($object);

        //IF POST
        if ($this->getRequest()->isPost()) {

            //SET DATA TO FORM
            $form->setData($this->getRequest()->getPost());

            //SET FILTERS TO FORM
            $form->setInputFilter($form->InputFilter());


            //VALID FORM
            if ($form->isValid()) {

                //DO SOMETHING IF FORM IS VALID
                //PERSIST OBJECT - IF NEED
                $this->getEntityManager()->persist($object);
                $this->getEntityManager()->flush();

                //FORWARD - IF NEED
                return $this->forward()->dispatch('Controller', ['action' => 'nameaction']);
            } else {
                //DO SOMETHING IF FORM IS INVALID
            }
        }


        return array("form" => $form);
    }

}
