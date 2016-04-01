<?php

return array(
    'cdicommons_options' => array(
    ),
    'controller_plugins' => array(
        'aliases' => array(
            'CsvExport' => 'CdiCsv:CsvExport',
            'CsvImport' => 'CdiCsv:CsvImport',
        ),
        'invokables' => array(
            'CdiCsv:CsvExport' => 'CdiCommons\Controller\Plugin\CsvExport',
            'CdiCsv:CsvImport' => 'CdiCommons\Controller\Plugin\CsvImport',
        ),
        'shared' => array(
            'CdiCsv:CsvExport' => false,
            'CdiCsv:CsvImport' => false,
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'cdicommons_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/CdiCommons/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'CdiCommons\Entity' => 'cdicommons_entity',
                ),
            ),
        ),
    ),
);

