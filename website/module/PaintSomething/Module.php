<?php
namespace PaintSomething;

use PaintSomething\Model\Friends;
use PaintSomething\Model\FriendsTable;
use PaintSomething\Model\Games;
use PaintSomething\Model\GamesTable;
use PaintSomething\Model\Users;
use PaintSomething\Model\UsersTable;
use PaintSomething\Model\UsersGames;
use PaintSomething\Model\UsersGamesTable;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'PaintSomething\Model\FriendsTable' =>  function($sm) {
                    $tableGateway = $sm->get('FriendsTableGateway');
                    $table = new FriendsTable($tableGateway);
                    return $table;
                },
                'FriendsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Friends());
                    return new TableGateway('friends', $dbAdapter, null, $resultSetPrototype);
                },
                
                'PaintSomething\Model\GamesTable' =>  function($sm) {
                    $tableGateway = $sm->get('GamesTableGateway');
                    $table = new GamesTable($tableGateway);
                    return $table;
                },
                'GamesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Games());
                    return new TableGateway('games', $dbAdapter, null, $resultSetPrototype);
                },
                
                'PaintSomething\Model\UsersTable' =>  function($sm) {
                    $tableGateway = $sm->get('UsersTableGateway');
                    $table = new UsersTable($tableGateway);
                    return $table;
                },
                'UsersTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Users());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                
                'PaintSomething\Model\UsersGamesTable' =>  function($sm) {
                    $tableGateway = $sm->get('UsersGamesTableGateway');
                    $table = new UsersGamesTable($tableGateway);
                    return $table;
                },
                'UsersGamesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UsersGames());
                    return new TableGateway('users_games', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}