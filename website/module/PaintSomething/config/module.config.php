<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'PaintSomething\Controller\Game' => 'PaintSomething\Controller\GameController',
            'PaintSomething\Controller\GamesList' => 'PaintSomething\Controller\GamesListController',
            'PaintSomething\Controller\Home' => 'PaintSomething\Controller\HomeController',
            'PaintSomething\Controller\Member' => 'PaintSomething\Controller\MemberController',
            'PaintSomething\Controller\MembersList' => 'PaintSomething\Controller\MembersListController',
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
            'game' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/game/:id',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'action' => 'index',
                        'controller' => 'PaintSomething\Controller\Game',
                    ),
                ),
            ),
            'games-list' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/games-list[/:parameter][/:value]',
                    'constraints' => array(
                        'parameters' => '[a-zA-Z]+',
                        'value' => '[a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'action' => 'index',
                        'controller' => 'PaintSomething\Controller\GamesList',
                    ),
                ),
            ),
            'member' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/member/:name[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'name' => '[a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'action' => 'index',
                        'controller' => 'PaintSomething\Controller\Member',
                    ),
                ),
            ),
            'members-list' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/members-list[/:parameter][/:value]',
                    'constraints' => array(
                        'parameter' => '[a-zA-Z]+',
                        'value' => '[a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'action' => 'index',
                        'controller' => 'PaintSomething\Controller\MembersList',
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