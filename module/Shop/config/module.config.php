<?php

return array(

    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'shop_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__.'/../src/Shop/Entity',
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Shop\Entity' => 'shop_entity'
                )
            )
        )
    ),

    'controllers' => array(
        'invokables' => array(
            'Shop\Controller\Index' => 'Shop\Controller\IndexController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'shop' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/shop[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Shop\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'shop' => __DIR__ . '/../view',
        ),
    ),
);