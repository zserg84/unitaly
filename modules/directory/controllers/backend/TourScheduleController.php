<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 15.06.15
 * Time: 14:42
 */

namespace modules\directory\controllers\backend;


use common\actions\CreateAction;
use common\actions\UpdateAction;
use modules\directory\models\form\TourScheduleForm;
use modules\directory\models\Tour;
use modules\directory\models\TourSchedule;
use modules\directory\models\TourScheduleLang;
use modules\translations\models\Lang;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class TourScheduleController extends Controller
{

    public function actions()
    {
        return [
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => TourSchedule::className(),
                'formModelClass' => TourScheduleForm::className(),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel){
                    $dayNumber = \Yii::$app->getRequest()->get('dayNumber');
                    $tourId = \Yii::$app->getRequest()->get('tourId');

                    $tour = Tour::findOne($tourId);

                    $dateStart = \Yii::$app->getFormatter()->asDate($tour->date_start);
                    $dateStart = new \DateTime($dateStart);
                    $date = $dateStart->add(new \DateInterval('P'.($dayNumber-1).'D'));
                    $formModel->date = strtotime($date->format('d.m.Y'));
                    $model->tour_id = $tour->id;
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => TourSchedule::className(),
                'formModelClass' => TourScheduleForm::className(),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel){
                    $defaultLang = Lang::getDefaultLang();
                    $langId = \Yii::$app->getRequest()->get('lang', $defaultLang->id);

                    $languages = Lang::find()->all();
                    $tsLangs = $model->tourScheduleLangs;
                    $tsLangs = ArrayHelper::index($tsLangs, 'lang_id');
                    foreach($languages as $language){
                        $tsLang = isset($tsLangs[$language->id]) ? $tsLangs[$language->id] : new TourScheduleLang();
                        if($langId == $language->id)
                            $formModel->text = $tsLang->text;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
        ];
    }

    public function afterEdit($action, $model, $formModel){
        $defaultLang = Lang::getDefaultLang();
        $langId = \Yii::$app->getRequest()->get('lang', $defaultLang->id);

        $dayNumber = \Yii::$app->getRequest()->get('dayNumber');
        $action->redirectUrl = Url::toRoute(['tour-schedule/index', 'tourId'=>$model->tour_id, 'day'=>$dayNumber, 'lang'=>$langId]);

        $formModel->translationText = [
            $langId => $formModel->text,
        ];
        $model->saveLangsRelations('tourScheduleLangs', $formModel, 'translationText', 'text', 'tour_schedule_id');

        return $model;
    }

    public function actionIndex($tourId){
        $tourModel = Tour::findOne($tourId);
        $dayNumber = \Yii::$app->getRequest()->get('day', 1);

        $defaultLang = Lang::getDefaultLang();
        $langId = \Yii::$app->getRequest()->get('lang', $defaultLang->id);
        $lang = Lang::findOne($langId);
        TourSchedule::$langUrl = $lang->url;

        $scheduleQuery = TourSchedule::find()->innerJoinWith([
            'tour' => function($query){
                $query->from('tour as t');
            }
        ])->where([
            'tour_id' => $tourId,
        ]);
        $expression = new Expression('CEIL((tour_schedule.date - t.date_start)/3600/24) - :day = 0');
        $scheduleQuery->andWhere($expression, [
            'day' => $dayNumber - 1,
        ]);

        $schedules = $scheduleQuery->all();

        return $this->render('index', [
            'model' => $tourModel,
            'dayNumber' => $dayNumber,
            'schedules' => $schedules,
            'langId' => $langId,
        ]);
    }

    public function findModel($id){
        return parent::_findModel(TourSchedule::className(), $id);
    }
} 