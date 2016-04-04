<?php

/**
 *
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WaController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function abmAction() {

        $grid = $this->getServiceLocator()->get('cdiGrid');
        $source = new \CdiDataGrid\DataGrid\Source\Doctrine($this->getEntityManager(), '\DBAL\Entity\WhatsappNumber');
        $grid->setSource($source);
        $grid->setRecordPerPage(20);
        $grid->datetimeColumn('createdAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('updatedAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('expiration', 'Y-m-d H:i:s');
        $grid->hiddenColumn('createdAt');
        $grid->hiddenColumn('updatedAt');
        $grid->hiddenColumn('createdBy');
        $grid->hiddenColumn('profilePicture');
        $grid->hiddenColumn('profileStatus');
        $grid->hiddenColumn('profileNick');
        $grid->hiddenColumn('lastUpdatedBy');
        $grid->hiddenColumn('lastState');
        $grid->hiddenColumn('state');

        // $grid->addEditOption("Edit", "left", "btn btn-success fa fa-edit");
        $grid->addExtraColumn("Profile", "<a  class='fa fa-user btn btn-primary btn-xs' onclick='showProfile({{id}})' href='#'> Profile</a>      ", "right", false);

        $grid->addExtraColumn("Codigo", "<a style='color:blue; font-size: 10px;' class='fa fa-dot-circle-o' href='/wa/code/{{id}}'></a>      ", "right", false);

        $grid->addDelOption("Del", "left", "btn btn-warning fa fa-trash");
//        $grid->addNewOption("Add", "btn btn-primary fa fa-plus", " Agregar");
        $grid->setTableClass("table-condensed customClass");
        $grid->prepare();
        return array('grid' => $grid);
    }

    public function sprofileAction() {
        $form = new \Application\Form\WhatsappProfile();
        $view = new ViewModel(array('form' => $form));
        $view->setTerminal(true);
        return $view;
    }

    public function profileAction() {
        /*
         * Recibo la informacion por GET
         */
        $aGetData = $this->getRequest()->getQuery();
        $id = $aGetData['id'];

        /*
         * Verifico si me llega un ID por POST
         */
        if (!$id) {
            $aPostData = $this->getRequest()->getPost();
            $id = $aPostData['id'];
        }

        /*
         * En el caso de que este el ID, busco el registro en la DB
         * En el caso que ID este null, creo un nuevo objeto
         */
        if ($id) {
            $object = $this->getEntityManager()->getRepository('\DBAL\Entity\WhatsappNumber')->find($id);
            $new = false;
        } else {
            echo "ERROR";
        }

        /*
         * Declar el Formulario
         * Defino el Hidratador de Doctrine
         * Hago el Bind entre el Formulario y el objeto
         */
        $form = new \Application\Form\WhatsappProfile();
        $form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEntityManager()));
        $form->bind($object);

        /*
         * Verifico el Post, valido formulario y persisto en caso positivo
         */
        if ($this->getRequest()->isPost()) {

            $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray()
            );


            $form->setData($data);

            $form->setInputFilter($form->InputFilter());
            if ($form->isValid()) {

                if ($this->zfcUserAuthentication()->hasIdentity()) {
                    $user = $this->zfcUserAuthentication()->getIdentity();
                }

                if ($new) {
                    $object->setCreatedBy($user);
                    $object->setLastUpdatedBy($user);
                } else {
                    $object->setLastUpdatedBy($user);
                }

                $size = new \Zend\Validator\File\Size(array('max' => 50000000)); //minimum bytes filesize
                $imageResolution = new \Zend\Validator\File\ImageSize(100, 100, 640, 640);
                $extension = new \Zend\Validator\File\Extension(array('jpg', 'png'));
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size, $extension, $imageResolution), $File['picture']);

                if (!$adapter->isValid()) {

                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    $persist = false;
                    $form->setMessages(array('picture' => $error));
                } else {
                    $adapter->setDestination(BASEDIR . '/media/wprofile/');
                    if ($adapter->receive($File['picture'])) {
                        $newfile = $adapter->getFileName(null, true);
                        $srcPicture = BASEDIR . '/media/wprofile/' . $adapter->getFileName(null, false);
                        $webPicture = '/media/wprofile/' . $adapter->getFileName(null, false);
                        $object->setProfilePicture($srcPicture);

                        $this->getEntityManager()->persist($object);
                        $this->getEntityManager()->flush();


                        $form->bind($object);

//                          $w = new \WhatsProt($object->getAni(), $object->getProfileNick(), false);
//                          $w->connect();
//                            $w->loginWithPassword($object->getPassword());
//                          $w->sendSetProfilePicture($object->getProfilePicture());
//                          $w->sendStatusUpdate($object->getProfileStatus());
//                          $w->pollMessage();
//                           $w->disconnect();

                        $persist = true;
                    }
                }
            } else {
                $persist = false;
            }
        }
        /*
         * Paso la variable persist a la view
         * Defino terminal true para no renderizar el layout (ajax)
         */
        $view = new ViewModel(array('form' => $form,
            'persist' => $persist, "picture" => $webPicture));
        $view->setTerminal(true);
        return $view;
    }

    public function newAction() {


        $object = new \DBAL\Entity\WhatsappNumber();


        $form = new \Application\Form\WhatsappNew();
        $form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEntityManager()));
        $form->bind($object);

        /*
         * Verifico el Post, valido formulario y persisto en caso positivo
         */
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            $form->setInputFilter($form->InputFilter());
            if ($form->isValid()) {

                if ($this->zfcUserAuthentication()->hasIdentity()) {
                    $user = $this->zfcUserAuthentication()->getIdentity();
                }

                $object->setCreatedBy($user);
                $object->setLastUpdatedBy($user);



                $this->getEntityManager()->persist($object);
                $this->getEntityManager()->flush();
                $form->bind($object);
                $persist = true;


                return $this->redirect()->toRoute('wa', array('controller' => "Application\Controller\Wa",
                            'action' => "code",
                            'id' => $object->getId()));
            }
        }

        $view = new ViewModel(array('form' => $form));
        return $view;
    }

    public function codeAction() {

        $id = $this->params('id');

        if ($id) {


            $object = $this->getEntityManager()->getRepository('DBAL\Entity\WhatsappNumber')->find($id);





            $form = new \Application\Form\WhatsappCode();
            $form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEntityManager()));
            $form->bind($object);

            /*
             * Verifico el Post, valido formulario y persisto en caso positivo
             */
            if ($this->getRequest()->isPost()) {
                $form->setData($this->getRequest()->getPost());

                $form->setInputFilter($form->InputFilter());
                if ($form->isValid()) {

                    if ($this->zfcUserAuthentication()->hasIdentity()) {
                        $user = $this->zfcUserAuthentication()->getIdentity();
                    }

                    $object->setCreatedBy($user);
                    $object->setLastUpdatedBy($user);

                    try {
                        $w = new \Registration($object->getAni(), "", false);

                        $return = $w->codeRegister($object->getCode());



                        if ($return->status == "ok") {
                            $object->setPassword($return->pw);
                            $object->setStatus($return->status);
                            $expiration = new \DateTime();
                            $expiration->setTimestamp($return->expiration);
                            $object->setExpiration($expiration);
                            $object->setState($this->em->getReference('DBAL\Entity\WhatsappNumberState', 1));
                            $object->setLastState(new \DateTime("now"));
                            $this->getEntityManager()->persist($object);
                            $this->getEntityManager()->flush();
                            $form->bind($object);

                            return $this->forward()->dispatch('Application\Controller\Wa', [
                                        'action' => 'success',
                                        'whatsappNumber' => $object,
                            ]);
                        } else {
                            var_dump($return);
                        }
                    } catch (Exception $ex) {
                        return $this->forward()->dispatch('Application\Controller\Wa', [
                                    'action' => 'error'
                        ]);
                    }
                }
            } else {

                try {
                    $w = new \Registration($object->getAni(), "", false);
                    $w->codeRequest('sms'); // could be 'voice' too
                } catch (Exception $ex) {
                    echo "Msj:" . $ex;
                }
            }


            $view = new ViewModel(array('form' => $form));

            return $view;
        } else {

            return $this->forward()->dispatch('Application\Controller\Wa', [
                        'action' => 'error'
            ]);
        }
    }

    public function successAction() {
        $whatsappNumber = $this->params('whatsappNumber');

        return array('whatsappNumber' => $whatsappNumber);
    }

    public function errorAction() {
        return [];
    }

}
