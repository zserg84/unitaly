<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 01.06.15
 * Time: 14:59
 */

namespace modules\directory\controllers\backend;

use yii\filters\VerbFilter;
use yii\web\HttpException;

class Controller extends \vova07\admin\components\Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'put', 'post'],
                    'delete' => ['post', 'delete'],
                    'batch-delete' => ['post', 'delete'],
                    'image-delete' => ['post', 'delete'],
                ]
            ]
        ]);
    }

    protected function _findModel($modelName, $id)
    {
        if (is_array($id)) {
            $model = $modelName::findAll($id);
        } else {
            $model = $modelName::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }
} 