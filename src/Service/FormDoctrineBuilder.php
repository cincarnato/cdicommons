<?php

namespace CdiCommons\Service;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

/**
 * Servicio para creacion de forms
 *
 * Description
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 *
 * @package Paquete
 */
class FormDoctrineBuilder {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var Object
     */
    protected $object;

    public function setEntityManager(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function generateForm($entity, $id = null, $send = true, $cancel = true, $method = 'post') {

        $builder = new DoctrineAnnotationBuilder($this->getEntityManager());
        $this->form = $builder->createForm($entity);

        if ($id) {
            $this->object = $this->getEntityManager()->getRepository($entity)->find($id);
        } else {
            $this->object = new $entity;
        }

        $this->form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEntityManager()))
                ->setObject($this->object)
                //  ->setInputFilter(new ReferenzwertFilter())
                ->setAttribute('method', $method);

        $this->form->bind($this->object);

        if ($send) {
            $this->form->add(array(
                'name' => 'submit',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' => 'Registrar',
                    'class' => 'btn btn-success'
                )
            ));
        }

        if ($cancel) {
            $this->form->add(array(
                'name' => 'cancel',
                'type' => 'Zend\Form\Element\Button',
                'options' => array('label' => "Cancel"),
                'attributes' => array(
                    'value' => 'Cancelar',
                    'class' => 'btn btn-primary'
                )
            ));
        }

        return $this->form;
    }

    public function saveObject($data) {
        $this->form->setData($data);
        if ($this->form->isValid($data)) {
            $this->object = $this->form->getObject();
            $this->getEntityManager()->persist($this->object);
            $this->getEntityManager()->flush();
            return true;
        }
        return false;
    }

    function getEm() {
        return $this->em;
    }

    function getObject() {
        return $this->object;
    }

    function setEm(Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    function setObject(Object $object) {
        $this->object = $object;
    }

    function getForm() {
        return $this->form;
    }

    function setForm(Form $form) {
        $this->form = $form;
    }

}
