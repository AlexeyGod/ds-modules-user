<?php

use framework\helpers\ActiveForm;
use framework\core\Application;

$this->breadcrumbs[] = ['name' => 'Список пользователей', 'url' => '/manager/user/manager-users'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Создать' : 'Редактировать: '.$model->username)];
$this->title =  'Управление | Список пользователей | '.($model->isNewRecord ? 'Создать' : 'Редактировать: '.$model->username);
?>

<div style="padding: 10px;">
    <?
    $form = ActiveForm::begin();

    foreach($model->fields as $field)
    {
        if(in_array($field, ['id', 'password', 'last_visit', 'created_at', 'token'])) continue;

        echo '<div class="field">'.$form->input($model, $field).'</div>';
    }

    // Права
    if(Application::app()->identy->can('rbac-manager'))
    {
        echo '<div class="field">';
        foreach ($accepts as $acceptKey => $acceptValue)
        {
            echo '<p><label><input type="checkbox" name="selectedAccepts[]" value="'.$acceptKey.'"'.(isset($userAccepts[$acceptKey]) ? ' checked' : '').'> '.$acceptValue.'</label></p><br>';
        }

        echo '</div>';

    }

    echo '<div class="field">';
    ActiveForm::submit(['class' => '', 'value' => 'Сохранить']);
    echo '</div>';

    ActiveForm::end();
    ?>
</div>
