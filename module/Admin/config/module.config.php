<?php

return array(


    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Items' => 'Admin\Controller\ItemsController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/admin/',
                    /*'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),*/
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),

                'may_terminate' => true,

                'child_routes' => array(
                    'items' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'items[/:action][/:id]',
                            'constraints' => array(
                                //'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Items',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
        'template_map'=>array(
            'pagination_control' => __DIR__.'/../view/layout/pagination_control.phtml'
        ),
    ),
);