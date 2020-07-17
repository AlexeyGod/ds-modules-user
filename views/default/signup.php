<?php
/**
 * Created by Digital-Solution web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\components\user\User;
use framework\helpers\ActiveForm;
use framework\widgets\CaptchaInputWidget;

$this->title = 'Регистрация';
?>
<section>
    <div class="login">
        <h1>Регистрация</h1>
        <br>
            <?php
            $form = ActiveForm::begin();
            foreach($model->fields as $field)
            {
                if(in_array($field, ['id', 'created_at', 'last_visit', 'status', 'token']))
                    continue;

                echo '<div class="field">'.
                    $form->input($model, $field).
                '</div>';
            }

            echo '<div class="field">'.
                ''.$form->widget(CaptchaInputWidget::class, $model, 'captcha').
                '</div>';

            echo '<div class="field">'.ActiveForm::agreement('#register').'</div>';
            ActiveForm::button('Регистрация', ['type' => 'submit', 'id' => 'register']);
            ActiveForm::end();
            ?>
        </form>
    </div>
    </div>
</section>
