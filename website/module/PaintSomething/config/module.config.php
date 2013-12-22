<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'PaintSomething\Controller\Game' => 'PaintSomething\Controller\GameController',
            'PaintSomething\Controller\Home' => 'PaintSomething\Controller\HomeController',
            'PaintSomething\Controller\Member' => 'PaintSomething\Controller\MemberController',
            'PaintSomething\Controller\MembersList' => 'PaintSomething\Controller\MembersListController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/[:action]',
                    'defaults' => array(
                        'action' => 'index',
                        'controller' => 'PaintSomething\Controller\Home',
                    ),
                ),
                
            ),
            'game' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/game[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'action' => 'index',
                        'controller' => 'PaintSomething\Controller\Game',
                    ),
                ),
            ),
            'member' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/member/:name[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
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
                        'value' => '[0-9]+',
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