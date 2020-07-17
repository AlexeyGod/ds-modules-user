<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\user\controllers;

use modules\user\models\User;
use framework\components\Controller;
use framework\core\Application;
use framework\exceptions\NotFoundHttpException;
use framework\helpers\captcha\Captcha;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        exit('this user controller');
       $this->render('index', [

       ]);
    }

    public function actionCaptcha()
    {
        $captcha = Application::createObject('framework\helpers\captcha\Captcha');
        return $captcha->captcha();
    }

    public function actionLogin()
    {
        if(Application::app()->request->post('__username') != '' AND Application::app()->request->post('__password') != '')
        {
            if(User::auth(Application::app()->request->post('__username'), Application::app()->request->post('__password')))
            {
                return $this->redirect('/');
            }
            else
            {
                Application::app()->request->setFlash('danger', 'Не верный логин или пароль');
            }
        }
        $this->render('login', [

        ]);
    }

    public function actionLogout()
    {
        Application::app()->identy->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_REGISTER;

        if($model->load(Application::app()->request->post()))
        {
            if($model->save())
            {
                Application::app()->request->setFlash('success', 'Вы успешно зарегистрированы');
                return $this->redirect('/');
                exit();
            }
            else
            {
                Application::app()->request->setFlash('error', 'Произошла ошибка. Повторите попытку, если проблема повторяется - обратитесь к администратору');
            }
        }

        $this->render('signup', ['model' => $model]);
    }

    public function actionProfile()
    {
        $user = Application::app()->identy;

        if(!$user->isAuth())
        {
            return $this->redirect("/login");
            exit();
        }

        $editType = Application::app()->request->post('edit-type');

        switch ($editType){
            case 'set-photo':
                $user->photoObject->upload();
                if( $user->photoObject->save())
                {
                    Application::app()->request->setFlash('success', 'Фотография загружена');
                }
                break;

            case 'edit':
                $user->scenario = User::SCENARIO_EDIT_PROFILE;
                if($user->load(Application::app()->request->post()))
                {
                    if($user->save())
                        Application::app()->request->setFlash('success', 'Данные обновлены');
                }
                break;

            case 'change-pass':
                $user->scenario = User::SCENARIO_CHANGE_PASSWORD;
                if($user->load(Application::app()->request->post()))
                {
                    //exit(var_dump($user->getObjectParams()));
                    //exit('attr: '.var_dump($user->getAttributes()));
                    //exit(var_dump($user->getAttributes()));
                    if($user->save())
                    {
                        Application::app()->request->setFlash('success', 'Пароль обновлен');
                        return $this->redirect('/user/profile');
                    }
                    //else
                    //    Application::app()->request->setFlash('success', 'Пароль НЕ обновлен ('.var_export($user->getErrors(), true));
                }
                break;
        }
        $this->render('profile', [
            'user' => $user,
            'editType' => $editType,
        ]);
    }


}