<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\user\controllers;

use framework\components\Controller;
use framework\components\rbac\AcceptObject;
use framework\core\Application;
use framework\exceptions\NotFoundHttpException;


class ManagerAcceptsController extends Controller
{
    protected $layoutPath = '@modules/manager/views/layouts';

    public function actionIndex()
    {
        $models = AcceptObject::find()->orderBy(['type' => 'desc'])->all();

        $this->render('list', [
            'models' => $models
        ]);
    }

    public function actionCreate()
    {
        // Пустой объект
        $model = new AcceptObject();
        // Все полномочия и роли
        $accepts = AcceptObject::allObjects();
        // Привязки текущей роли (Для совместимости с видом для редактирования)
        $relations = [];

        $selectedAccepts = Application::app()->request->post('selectedAccepts');
        if(!empty($selectedAccepts))
        {
            $model->updateRelations($selectedAccepts);
            Application::app()->request->setFlash('success', 'Cвязи полномочий обновленны');
        }

        if($model->load(Application::app()->request->post()))
        {
            if($model->save())
            {
                Application::app()->request->setFlash('success', 'Объект полномочий добавлен');
                $selectedAccepts = Application::app()->request->post('selectedAccepts');
                $model->updateRelations($selectedAccepts);
            }
            else
                Application::app()->request->setFlash('error', 'Объект полномочий не был добавлен');
        }

        $this->render('update', [
            'model' => $model,
            'accepts' => $accepts,
            'relations' => $relations
        ]);
    }

    public function actionUpdate($id)
    {
        // Пустой объект
        $model = AcceptObject::findOne($id);

        if($model == null) throw new NotFoundHttpException("Объект полномочий не найден");

        // Все полномочия и роли
        $accepts = AcceptObject::allObjects();

        if($model->load(Application::app()->request->post()))
        {
            //Application::app()->request->setFlash('success', 'data loaded');

            $selectedAccepts = Application::app()->request->post('selectedAccepts');
            $model->updateRelations($selectedAccepts);

            if($model->save())
                Application::app()->request->setFlash('success', 'Объект полномочий обновлен');
        }


        $this->render('update', [
            'model' => $model,
            'accepts' => $accepts,
            'relations' => $model->getRelations()
        ]);
    }

}