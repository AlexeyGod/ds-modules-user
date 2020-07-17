<?php

use framework\helpers\grid\GridView;
use framework\core\Application;

$this->breadcrumbs[] = ['name' => 'Список пользователей'];
$this->title =  'Управление | Список пользователей';
?>
<h1>Список пользователей <a class="button" href="/manager/user/manager-users/create"><span class="">+</span></a></h1>
<p>Всего юзеров <?=count($users)?></p>

<div>
    <?=GridView::widget($users, ['columns' => [
       'name', 'username', 'email', 'status', 'last_visit', 'created_at',
        Application::app()->identy->can('rbac-manager') ? [
            'name' => 'Доступ',
            'value' => function($model){
                $output = '';
                $roles = $model->getAccepts();

                if(is_array($roles))
                    foreach ($roles as $role)
                    {
                        $output .=  '<span class="slug">'.$role.'</span> ';
                    }
                else
                    return '';

                return $output;
            }
        ] : [],
        [
            'name' => 'Действия',
            'value' => function($model)
            {
                $out = [];

                if(!$model->can('system') OR \framework\core\Application::app()->identy->can('system'))
                {
                    $out[] = '<a href="/manager/user/manager-users/pw/'.$model->getIdentity().'">Сбросить пароль</a>';
                    $out[] = '<a href="/manager/user/manager-users/update/'.$model->getIdentity().'">Редактировать</a>';
                    $out[] = '<a href="/manager/user/manager-users/delete/'.$model->getIdentity().'">Удалить</a>';
                }
                else
                {
                    $out[] = 'Недостаточно прав';
                }

                return implode('<br>', $out);
            }
        ]
    ]])?>
</div>