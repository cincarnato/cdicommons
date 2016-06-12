<?php

/**
 * User: Cristian Incarnato
 */
use Zend\ServiceManager\ServiceLocatorInterface;

return array(
    'invokables' => array(
    ),
    'factories' => array(
        'cdicommons_options' => function (ServiceLocatorInterface $sm) {
            $config = $sm->get('Config');
            return new \CdiCommons\Options\CdiCommonsOptions(isset($config['cdicommons_options']) ? $config['cdicommons_options'] : array());
        },
        'cdicommons_form_doctrine_builder' => function (ServiceLocatorInterface $sm) {
            $em = $sm->get('Doctrine\ORM\EntityManager');
            $service = new \CdiCommons\Service\FormDoctrineBuilder();
            $service->setEntityManager($em);
            return $service;
        }
        ));


        
