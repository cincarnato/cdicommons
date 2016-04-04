<?php

return array(
    'cdicommons_options' => array(
    ),
       'view_manager' => array(
        'template_path_stack' => array(
            'cdicommons' => __DIR__ . '/../view',
        ),
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
     'view_helpers' => array(
        'invokables' => array(
            'CdiFormElement' => 'CdiCommons\View\Helper\CdiFormElement',
        )
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

