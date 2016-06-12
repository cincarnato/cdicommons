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
      'view_manager' => array(
        'template_path_stack' => array(
            'cdicommons' => __DIR__ . '/../view',
        ),
    ),
);
 
