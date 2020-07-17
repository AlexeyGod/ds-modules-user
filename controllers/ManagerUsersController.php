<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\user\controllers;
use framework\components\Controller;
use framework\components\rbac\AcceptObject;
use modules\user\models\User;
use framework\components\rbac\Role;
use framework\core\Application;
use framework\exceptions\ErrorException;
use framework\helpers\ArrayHelper;


class ManagerUsersController extends Controller
{
    protected $layoutPath = '@modules/manager/views/layouts';

    public function actionIndex()
    {
       $this->render('user-list', ['users' => User::find()->all()]);
    }

    public function actionCreate()
    {
        $user = new User();

        if($user->load(Application::app()->request->post()))
        {
            if($user->save())
            {
                //$user->setRoles(Application::app()->request->post('roles'));
                $user->updateAccepts(Application::app()->request->post("selectedAccepts"));
                Application::app()->request->setFlash('success', 'Пользователь добавлен');
            }
        }
        else
        {
            $user->status = User::STATUS_ACTIVE;
        }


        $this->render('user-edit', [
            'roles' => ['' => 'ReWork in '.__LINE__], //ArrayHelper::map(Role::find()->all(), 'id', 'name'),
            'model' => $user
        ]);
    }

    public function actionUpdate($id)
    {
        //exit('id: '.$id);
        $user = User::findOne(intval($id));

        //exit(var_dump($user));
        if($user == null)
            return $this->notFound('Пользователь не найден');

        $user->scenario = User::SCENARIO_MANAGER;


        //if(!empty(Application::app()->request->post('roles')))
        //    $user->setRoles(Application::app()->request->post('roles'));

        if($user->load(Application::app()->request->post()))
        {
            $user->updateAccepts(Application::app()->request->post("selectedAccepts"));
            if($user->save())
            {
                Application::app()->request->setFlash('success', 'Данные сохранены');
            }
        }

        $this->render('user-edit', [
            'accepts' => AcceptObject::allObjects(),
            'userAccepts' => $user->getAccepts(),
            'model' => $user
        ]);
    }

    public function actionPw($id)
    {
        //exit('id: '.$id);
        $user = User::findOne(intval($id));
        $user->scenario = User::SCENARIO_SYSTEM;

        //exit(var_dump($user));
        if($user == null)
            return $this->notFound('Пользователь не найден');

            $user->password = User::DEFAULT_PASSWORD;
            $user->save();
            Application::app()->request->setFlash('success', 'Пароль для пользователя <b>'.$user->username.'</b> был сброшен на <b>'.User::DEFAULT_PASSWORD.'</b>');



        $this->render('user-edit', [
            'roles' => [],
            'model' => $user
        ]);
    }

    public function actionDelete($id)
    {
        //exit('id: '.$id);
        $user = User::findOne(intval($id));

        //exit(var_dump($user));
        if($user == null)
            return $this->notFound('Пользователь не найден');

        $username = $user->username;

        if($user->getIdentity() == Application::app()->identy->getIdentity())
            throw new ErrorException("Вы не можете удалить сами себя");

        if($user->delete())
        {
            Application::app()->request->setFlash('success', 'Пользователь '.$username.' был удален');
        }
        else
        {
            Application::app()->request->setFlash('error', 'Пользователь '.$username.' не был удален');
        }


        $this->redirect('/user/manager-users');
    }


}