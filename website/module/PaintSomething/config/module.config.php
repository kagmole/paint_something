<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'PaintSomething\Controller\Games' => 'PaintSomething\Controller\GamesController',
            'PaintSomething\Controller\Home' => 'PaintSomething\Controller\HomeController',
            'PaintSomething\Controller\Members' => 'PaintSomething\Controller\MembersController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'action' => 'index',
                        'controller' => 'PaintSomething\Controller\Home',
                    ),
                ),
            ),
            'members' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/members[/[:slug_name[/:action]]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'slug_name' => '[a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'action' => 'index',
                        'controller' => 'PaintSomething\Controller\Members',
                    ),
                ),
            ),
            'games' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/games[/[:slug_id[/:action]]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'slug_id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'action' => 'index',
                        'controller' => 'PaintSomething\Controller\Games',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'paint-something' => __DIR__ . '/../view',
        ),
    ),
);