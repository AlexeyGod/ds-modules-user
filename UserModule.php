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
    public function __construct($options = [])
    {
        Application::setAlias('@modules/user', __DIR__);
        return parent::__construct($options);
    }

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