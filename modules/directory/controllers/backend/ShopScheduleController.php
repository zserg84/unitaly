<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 25.06.15
 * Time: 16:50
 */

namespace modules\directory\controllers\backend;


use common\actions\CreateAction;
use common\actions\UpdateAction;
use modules\directory\models\form\ShopScheduleForm;
use modules\directory\models\Shop;
use modules\directory\models\ShopSchedule;
use modules\directory\models\ShopScheduleLang;
use modules\translations\models\Lang;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ShopScheduleController extends Controller
{
    public function actions()
    {
        return [
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => ShopSchedule::className(),
                'formModelClass' => ShopScheduleForm::className(),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel){
                    $shopId = \Yii::$app->getRequest()->get('shopId');
                    $model->shop_id = $shopId;
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => ShopSchedule::className(),
                'formModelClass' => ShopScheduleForm::className(),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel){
                    $defaultLang = Lang::getDefaultLang();
                    $langId = \Yii::$app->getRequest()->get('lang', $defaultLang->id);

                    $languages = Lang::find()->all();
                    $ssLangs = $model->shopScheduleLangs;
                    $ssLangs = ArrayHelper::index($ssLangs, 'lang_id');
                    foreach($languages as $language){
                        $ssLang = isset($ssLangs[$language->id]) ? $ssLangs[$language->id] : new ShopScheduleLang();
                        if($langId == $language->id)
                            $formModel->text = $ssLang->text;
                    }

                    $formModel->date_from = $formModel->date_from ? \Yii::$app->getFormatter()->asDate($formModel->date_from) : null;
                    $formModel->date_to = $formModel->date_to ? \Yii::$app->getFormatter()->asDate($formModel->date_to) : null;

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

        $action->redirectUrl = Url::toRoute(['shop-schedule/index', 'shopId'=>$model->shop_id, 'lang'=>$langId]);

        $formModel->translationText = [
            $langId => $formModel->text,
        ];
        $model->saveLangsRelations('shopScheduleLangs', $formModel, 'translationText', 'text', 'shop_schedule_id');

        return $model;
    }

    public function actionIndex($shopId){
        $shopModel = Shop::findOne($shopId);

        $defaultLang = Lang::getDefaultLang();
        $langId = \Yii::$app->getRequest()->get('lang', $defaultLang->id);
        $lang = Lang::findOne($langId);
        ShopSchedule::$langUrl = $lang->url;

        $scheduleQuery = ShopSchedule::find()->innerJoinWith([
            'shop' => function($query){
                $query->from('shop as s');
            }
        ])->where([
            'shop_id' => $shopId,
        ]);
        $schedules = $scheduleQuery->all();

        return $this->render('index', [
            'model' => $shopModel,
            'schedules' => $schedules,
            'langId' => $langId,
        ]);
    }

    public function findModel($id){
        return parent::_findModel(ShopSchedule::className(), $id);
    }
} 