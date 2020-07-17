<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use \framework\core\Application;
use framework\helpers\ActiveForm;

// $user;

$this->title = 'Профиль '.$user->username;
?>
<div class="page">
    <div class="page-header">
        <h1><?=$this->title?></h1>
    </div>
    <div class="page-body">
        <!-- Вкладки -->

            <div class="tabs">
                <input id="tab_1" type="radio" name="tabs"<?=(($editType == 'edit' OR empty($editType)) ? ' checked' : '')?>>
                <label for="tab_1" title="Анкета"><span class="icon icon-profile"></span> <span class="text">Анкета</span></label>

                <input id="tab_2" type="radio" name="tabs" <?=($editType == 'set-photo' ? ' checked' : '')?>>
                <label for="tab_2" title="Фотография"><span class="icon icon-camera"></span>  <span class="text">Фото</span></label>

                <input id="tab_3" type="radio" name="tabs"<?=($editType == 'change-pass' ? ' checked' : '')?>>
                <label for="tab_3" title="Пароль"><span class="icon icon-key2"></span>  <span class="text">Пароль</span></label>

                <input id="tab_4" type="radio" name="tabs"<?=($editType == 'change-pass' ? ' checked' : '')?>>
                <label for="tab_4" title="Пароль"><span class="icon icon-shield"></span>  <span class="text">Права и полномочия</span></label>

                <section id="content_1">
                    <?php
                    $form = ActiveForm::begin(['options' => ['name' => 'edit']]);
                    foreach($user->fields as $field)
                    {

                        if(in_array($field, ['id', 'username', 'created_at', 'last_visit', 'status', 'password', 'token', 'secret_key'])) continue;

                        switch($field):

                            case 'password':
                                echo '<div class="field">'
                                    .'  '.$form->input($user, 'currentPassword')
                                    .'</div>';
                                echo '<div class="field">'
                                    .'  '.$form->input($user, 'newPassword')
                                    .'</div>';
                                echo '<div class="field">'
                                    .'  '.$form->input($user, 'repeatNewPassword')
                                    .'</div>';
                                break;

                            default:
                                echo '<div class="field">'
                                    .'  '.$form->input($user, $field)
                                    .'</div>'
                                    .'';
                                break;

                        endswitch;
                    }
                    echo '<input type="hidden" name="edit-type" value="edit">';
                    echo ActiveForm::submit(['value' => 'Сохранить']);

                    ActiveForm::end();
                    ?>
                    <br>
                    <hr>
                    <br>
                    <div class="field">
                        Вы с нами с <?=date("d.m.Y h:i", strtotime($user->created_at))?>
                    </div>
                </section>
                <section id="content_2">
                    <div class="field">
                        <p>Ваша текущая фотография</p>
                        <div class="image">
                            <img src="<?=$user->photo?>" style="max-height: 100px; width: auto">
                        </div>
                    </div>
                    <?php
                        $form = ActiveForm::begin(['options' => ['name' => 'set-photo', 'enctype' => 'multipart/form-data']]);
                        echo '<div class="field">'
                        .'  '.$form->inputFile($user->photoObject, 'file')
                        .'</div>';

                    echo '<input type="hidden" name="edit-type" value="set-photo">';
                    echo ActiveForm::submit(['value' => 'Сохранить']);
                    ActiveForm::end();
                    ?>
                </section>
                <section id="content_3">
                    <?php
                    $form = ActiveForm::begin(['options' => ['name' => 'change-pass']]);
                    foreach($user->fields as $field)
                    {

                        if(in_array($field, ['id', 'username', 'created_at', 'last_visit', 'status', 'email', 'name', 'token', 'secret_key'])) continue;

                        switch($field):

                            case 'password':
                                echo '<div class="field">'
                                    .'  '.$form->input($user, 'currentPassword')
                                    .'</div>';
                                echo '<div class="field">'
                                    .'  '.$form->input($user, 'newPassword')
                                    .'</div>';
                                echo '<div class="field">'
                                    .'  '.$form->input($user, 'repeatNewPassword')
                                    .'</div>';
                                break;

                            default:
                                echo '<div class="field">'
                                    .'  '.$form->input($user, $field)
                                    .'</div>'
                                    .'';
                                break;

                        endswitch;
                    }

                    echo '<input type="hidden" name="edit-type" value="change-pass">';
                    echo ActiveForm::submit(['value' => 'Сохранить']);

                    ActiveForm::end();
                    ?>
                </section>
                <section id="content_4">
                    <p>Ваш ID: <?=$user->id?></p>
                    <?
                    $accepts = $user->getAccepts();
                    if(count($accepts) == 0)
                    echo "Вам не присвоено никаких ролей";
                    else
                    {
                        echo '<p><u>Вам присвоены следующие права и полномочия:</u></p>';
                        foreach ($accepts as $accept)
                        {
                            echo '<p>'.$accept.'</p>';
                        }
                    }
                    ?>
                </section>
            </div>
       
    </div><!-- / page -->
</div>