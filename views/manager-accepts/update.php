<?php

use framework\helpers\ActiveForm;

$this->breadcrumbs[] = ['name' => 'Роли и полномочия', 'url' => '/manager/user/manager-accepts'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Создать' : 'Редактировать: '.$model->name)];

?>

<div style="padding: 10px;">
    <?
    $form = ActiveForm::begin();

    foreach($model->fields as $field)
    {
        if(in_array($field, ['id'])) continue;

        switch($field)
        {
            case 'type':
                    echo '<div class="field">'.$form->select($model, $field, $model->getTypes()).'</div>';
                    break;

            case 'description':
                echo '<div class="field">'.$form->textarea($model, $field).'</div>';
                break;

            default:
                    echo '<div class="field">'.$form->input($model, $field).'</div>';
                break;
        }
    }

    echo '<div class="field">';

    if(!empty($accepts))
    {
        foreach ($accepts as $acceptKey => $acceptName)
        {
            echo '<p class="p10"><label><input type="checkbox" name="selectedAccepts[]" value="'.$acceptKey.'"'.(isset($relations[$acceptKey]) ? ' checked' : '').'> '.$acceptName.'</label></p>';
        }
    }


    echo '</div>';

    echo '<div class="field">';
        ActiveForm::submit(['class' => '', 'value' => 'Сохранить']);
    echo '</div>';

    ActiveForm::end();
    ?>
</div>