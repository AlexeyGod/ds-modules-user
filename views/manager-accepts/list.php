<?php

use framework\helpers\grid\GridView;
$this->title = 'Управелние | Роли и полномочия';
$this->breadcrumbs[] = ['name' => 'Роли и полномочия'];
?>
<h1>Роли и полномочия <a class="button" href="/manager/user/manager-accepts/create"><span class="">+</span></a></h1>
<div>
    <?=GridView::widget($models, [
        'columns' => [
            'slug',
            [
                'attribute' => 'type',
                'value' => function($model) {
                    return $model->getTypes()[$model->type];
                }
            ],
            'name', 'description',
            [
                'name' => 'Содержит',
                'value' => function($model){
                    $relations = $model->getRelations();
                    if(!empty($relations))
                    {
                        foreach ($relations as $relation)
                        {
                            $output[] = $relation;
                        }

                        return implode(', ', $output);
                    }
                    else
                     return '';
                }

            ],
           //[
           //    'name' => 'Полномочия',
           //    'value' => function($model){
           //        $output = '';
           //        $permissions = $model->getPermissionObjects();

           //        if(is_array($permissions))
           //            foreach ($permissions as $permission)
           //            {
           //               $output .=  '<span class="slug">'.$permission->name.'</span> ';
           //            }
           //        else
           //            return '';

           //        return $output;
           //    }
           //],
           [
               'name' => 'Действия',
               'value' => function($model)
               {
                   $out = [];
                   $out[] = '<a href="/manager/user/manager-accepts/update/'.$model->getIdentity().'">Редактировать</a>';
                   $out[] = '<a href="/manager/user/manager-accepts/delete/'.$model->getIdentity().'" onclick="if(confirm(\'Действительно удалить '.$model->getTypes()[$model->type].': '.$model->name.'?\')) return true; else return false;">Удалить</a>';
                   return implode('<br>', $out);
               }
           ]
        ]
    ])?>
</div>