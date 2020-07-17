<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\user;

use framework\components\module\ModuleComponent;

class UserModule extends ModuleComponent
{
    //ublic $routes = [
    //   'manager/user/list' => '/user/manager-users',
    //   'manager/user/accepts' => '/user/manager-accepts',
    //   'manager/user/accepts/create' => '/user/manager-accepts/create',
    //   'manager/user/accepts/<action:update|delete>/<id:\d+>' => '/user/manager-accepts/<action>',
    //   'manager/user/create' => '/user/manager-users/create',
    //   'manager/user/<action:pw|update|delete>/<id:\d+>' => '/user/manager-users/<action>',
    //;

    protected $_menu = [
        'accept' => 'user-manager',
        'name' => 'Пользователи',
        'icon' => 'icon icon-users',
        'links' => [
            [
                'name' => 'Список',
                'url' => '/manager/user/manager-users',
            ],
            [
                'name' => 'Роли и полномочия',
                'url' => '/manager/user/manager-accepts',
                'accept' => 'system',
            ],

        ]
    ];
}