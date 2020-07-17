<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\user\controllers;
use framework\components\Controller;
use modules\user\models\User;
use framework\components\rbac\Role;
use framework\components\rbac\Permission;
use framework\core\Application;
use framework\exceptions\ErrorException;
use framework\helpers\ArrayHelper;


class ManagerRolesController extends Controller
{
    protected $layoutPath = '@modules/manager/views/layouts';

    public function actionIndex()
    {
        $roles = Role::find()->all();

        $this->render('roles', [
        'roles' => $roles
        ]);
    }

    public function actionCreate()
    {
        $model = new Role();

        $permissions = ArrayHelper::map(Permission::find()->all(), 'id', 'name');

        if($model->load(Application::app()->request->post()))
        {
            if($model->setPermissions(Application::app()->request->post('permissions')))
                Application::app()->request->setFlash('success', 'Обновлен список полномочий для роли');

            if($model->save())
                Application::app()->request->setFlash('success', 'Роль добавленна');
            else
                Application::app()->request->setFlash('error', 'Роль не была добавленна');
        }

        $this->render('role-update', ['model' => $model, 'permissions' => $permissions]);
    }

    public function actionUpdate($id)
    {
        $id = intval($id);
        $model = Role::findOne($id);

        if($model== null)
            return $this->notFound('Роль не найдена');

        $permissions = ArrayHelper::map(Permission::find()->all(), 'id', 'name');

        if($model->load(Application::app()->request->post()))
        {
            if($model->setPermissions(Application::app()->request->post('permissions')))
                Application::app()->request->setFlash('success', 'Обновлен список полномочий для роли');

            if($model->save())
                Application::app()->request->setFlash('success', 'Роль изменена');
            //else
            //    Application::app()->request->setFlash('error', 'Роль не была изменена');
        }

        $this->render('role-update', ['model' => $model, 'permissions' => $permissions]);
    }
}