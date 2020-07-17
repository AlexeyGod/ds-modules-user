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


class ManagerPermissionsController extends Controller
{
    protected $layoutPath = '@modules/manager/views/layouts';

    public function actionIndex()
    {
        $models = Permission::find()->all();

        $this->render('permission', [
            'models' => $models
        ]);
    }

    public function actionCreate()
    {
        $model = new Permission();

        $permissions = ArrayHelper::map(Permission::find()->all(), 'id', 'name');

        if($model->load(Application::app()->request->post()))
        {

            if($model->save())
                Application::app()->request->setFlash('success', 'Полномочие добавленна');

        }

        $this->render('permission-update', ['model' => $model, 'permissions' => $permissions]);
    }

    public function actionUpdate($id)
    {
        $id = intval($id);
        $model = Permission::findOne($id);

        if($model== null)
            return $this->notFound('Полномочие не найдено');


        if($model->load(Application::app()->request->post()))
        {
            if($model->save())
                Application::app()->request->setFlash('success', 'Полномочие изменено');

        }
        $permissions = ArrayHelper::map(Permission::find()->all(), 'id', 'name');
        $this->render('permission-update', ['model' => $model, 'permissions' => $permissions]);
    }
}