<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.06.15
 * Time: 15:48
 */

namespace modules\directory\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\directory\models\City;
use modules\directory\models\form\ShopForm;
use modules\directory\models\form\ShopMallForm;
use modules\directory\models\form\ShopOutletForm;
use modules\directory\models\Province;
use modules\directory\models\form\ShopSupermarketForm;
use modules\directory\models\search\ShopSearch;
use modules\directory\models\Shop;
use modules\directory\models\ShopGoodCategory;
use modules\directory\models\ShopLang;
use modules\directory\models\ShopType;
use modules\translations\models\Lang;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

class ShopController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['index'],
            'roles' => ['BViewShop']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateShop']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdateShop']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteShop']
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'create' => ['get', 'post'],
                'update' => ['get', 'put', 'post'],
                'delete' => ['post', 'delete'],
                'batch-delete' => ['post', 'delete'],
            ]
        ];

        return $behaviors;
    }

    public function actions()
    {
        return array_merge(
	        [
	            'index' => [
	                'class' => IndexAction::className(),
	                'modelClass' => ShopSearch::className(),
	            ],
	            'delete' => [
		            'class' => DeleteAction::className(),
		            'modelClass' => Shop::className(),
		            'redirectUrl' => Url::toRoute(['index']),
	            ],
	            'batch-delete' => [
		            'class' => BatchDeleteAction::className(),
		            'modelClass' => Shop::className(),
	            ],
            ]
        );
    }

	public function actionUpdate($id){
		if ($model = $this->_findModel(Shop::className(), $id)) {
			$controllerName = $this->getEditController($model->shop_type_id);
			$this->redirect([$controllerName . '/update', 'id' => $id]);
		} else {
			$this->redirect(['index']);
		}
	}

    public function actionsSupermarket(){
        return [
	        'create-supermarket' => [
		        'class' => CreateAction::className(),
		        'modelClass' => Shop::className(),
		        'formModelClass' => ShopSupermarketForm::className(),
		        'view' => 'supermarket/create',
		        'ajaxValidation' => true,
		        'redirectUrl' => Url::toRoute('index'),
		        'afterAction' => function($action, $model, $formModel){
			        return $this->afterEdit($action, $model, $formModel);
		        }
	        ],
        ];
    }

    public function actionCreate(){
        $formModel = new ShopForm();
        if($formModel->load(\Yii::$app->getRequest()->post())){
            $shopTypeId = $formModel->shop_type_id;
            $actionName = self::getEditController($shopTypeId).'/create';
            $this->redirect(Url::toRoute([$actionName]));
        }
        return $this->render('create', [
            'formModel' => $formModel,
        ]);
    }

    public function beforeUpdate($model, $formModel){
        $formModel->logo_image = $model->logoImage;
        $formModel->main_image = $model->mainImage;
        $formModel->additional_image = $model->additionalImage;

        $city = City::findOne($formModel->city_id);
        if($city){
            $formModel->province_id = $city->province_id;
            $province = Province::findOne($city->province_id);
            $formModel->region_id = $province->region_id;
        }

        $languages = Lang::find()->all();
        $shopLangs = $model->shopLangs;
        $shopLangs = ArrayHelper::index($shopLangs, 'lang_id');
        foreach($languages as $language){
            $shopLang = isset($shopLangs[$language->id]) ? $shopLangs[$language->id] : new ShopLang();
            $formModel->translationName[$language->id] = $shopLang->name;
            $formModel->translationSpellings[$language->id] = $shopLang->spellings;
            $formModel->translationShortDescription[$language->id] = $shopLang->short_description;
            $formModel->translationDescription[$language->id] = $shopLang->description;
            $formModel->translationWorktime[$language->id] = $shopLang->worktime;
        }

        $formModel->categories = ArrayHelper::getColumn($model->shopGoodCategories, 'good_category_id');
        return $formModel;
    }

	/**
	 * @param $action
	 * @param $model \modules\directory\models\Shop
	 * @param $formModel
	 *
	 * @return mixed
	 */
    public function afterEdit($action, $model, $formModel){
        $formModel->logo_image = UploadedFile::getInstance($formModel, 'logo_image');
        $image = $formModel->getImage('logo_image');
        if($image){
            $model->image_id = $image->id;
            $model->save();
        }

        $formModel->main_image = UploadedFile::getInstance($formModel, 'main_image');
        $image = $formModel->getImage('main_image');
        if($image){
            $model->image_id = $image->id;
            $model->save();
        }

        $formModel->additional_image = UploadedFile::getInstance($formModel, 'additional_image');
        $image = $formModel->getImage('additional_image');
        if($image){
            $model->additional_image_id = $image->id;
            $model->save();
        }

        $model->saveLangsRelations('shopLangs', $formModel, 'translationName', 'name', 'shop_id');
        $model->saveLangsRelations('shopLangs', $formModel, 'translationSpellings', 'spellings', 'shop_id');
        $model->saveLangsRelations('shopLangs', $formModel, 'translationWorktime', 'worktime', 'shop_id');
        $model->saveLangsRelations('shopLangs', $formModel, 'translationShortDescription', 'short_description', 'shop_id');
        $model->saveLangsRelations('shopLangs', $formModel, 'translationDescription', 'description', 'shop_id');

        /*Сохраняем связанные категории товаров*/
        $model->saveShopGoodCategories($formModel->categories);
        return $model;
    }

    public static function editShopControllerNames(){
        return [
            ShopType::TYPE_OUTLET => 'outlet',
            ShopType::TYPE_MALL => 'mall',
            ShopType::TYPE_SUPERMARKET => 'supermarket',
            ShopType::TYPE_STORE => 'store',
            ShopType::TYPE_MARKET => 'market',
        ];
    }

    public static function getEditController($shopTypeId){
        $controllerNames = self::editShopControllerNames();
        return isset($controllerNames[$shopTypeId]) ? $controllerNames[$shopTypeId] : $controllerNames[ShopType::TYPE_OUTLET];
    }

}