<?php

namespace modules\translations\models;

use modules\directory\models\AdditionalServiceLang;
use modules\directory\models\CafeLang;
use modules\directory\models\CityLang;
use modules\directory\models\GoodCategoryLang;
use modules\directory\models\HubLang;
use modules\directory\models\PlacementTypeLang;
use modules\directory\models\RegionLang;
use modules\directory\models\RestaurantLang;
use modules\directory\models\RoomLang;
use modules\directory\models\ShopCategoryLang;
use modules\directory\models\ShopLang;
use modules\directory\models\ShopScheduleLang;
use modules\directory\models\ShopTypeLang;
use modules\directory\models\ShowplaceLang;
use modules\directory\models\ShowplaceTypeLang;
use modules\directory\models\TourLang;
use modules\directory\models\TourScheduleLang;
use modules\directory\models\TourTypeLang;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use modules\translations\Module as TranslationModule;

/**
 * This is the model class for table "lang".
 *
 * @property integer $id
 * @property string $url
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AdditionalServiceLang[] $additionalServiceLangs
 * @property CafeLang[] $cafeLangs
 * @property CityLang[] $cityLangs
 * @property GoodCategoryLang[] $goodCategoryLangs
 * @property HubLang[] $hubLangs
 * @property Message[] $messages
 * @property PlacementTypeLang[] $placementTypeLangs
 * @property ProvinceLang[] $provinceLangs
 * @property RegionLang[] $regionLangs
 * @property RestaurantLang[] $restaurantLangs
 * @property RoomLang[] $roomLangs
 * @property ShopCategoryLang[] $shopCategoryLangs
 * @property ShopLang[] $shopLangs
 * @property ShopScheduleLang[] $shopScheduleLangs
 * @property ShopTypeLang[] $shopTypeLangs
 * @property ShowplaceLang[] $showplaceLangs
 * @property ShowplaceTypeLang[] $showplaceTypeLangs
 * @property TourLang[] $tourLangs
 * @property TourScheduleLang[] $tourScheduleLangs
 * @property TourTypeLang[] $tourTypeLangs
 */
class Lang extends \yii\db\ActiveRecord
{
    /**
     * Переменная, для хранения текущего объекта языка
     */
    public static $current = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['default', 'filter', 'filter' => function ($value) {
                return $value ? $value : 0;
            }],
            [['url', 'local', 'name'], 'required'],
            [['default', 'created_at', 'updated_at'], 'integer'],
            [['url'], 'string', 'max' => 5],
            [['local'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => TranslationModule::t('lang', 'ID'),
            'url' => TranslationModule::t('lang', 'URL'),
            'local' => TranslationModule::t('lang', 'LOCAL'),
            'name' => TranslationModule::t('lang', 'NAME'),
            'default' => TranslationModule::t('lang', 'DEFAULT'),
            'created_at' => TranslationModule::t('lang', 'CREATED_AT'),
            'updated_at' => TranslationModule::t('lang', 'UPDATED_AT'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalServiceLangs()
    {
        return $this->hasMany(AdditionalServiceLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCafeLangs()
    {
        return $this->hasMany(CafeLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityLangs()
    {
        return $this->hasMany(CityLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodCategoryLangs()
    {
        return $this->hasMany(GoodCategoryLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHubLangs()
    {
        return $this->hasMany(HubLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacementLangs()
    {
        return $this->hasMany(PlacementTypeLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacementTypeLangs()
    {
        return $this->hasMany(PlacementTypeLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionLangs()
    {
        return $this->hasMany(RegionLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantLangs()
    {
        return $this->hasMany(RestaurantLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomLangs()
    {
        return $this->hasMany(RoomLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopCategoryLangs()
    {
        return $this->hasMany(ShopCategoryLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopLangs()
    {
        return $this->hasMany(ShopLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopScheduleLangs()
    {
        return $this->hasMany(ShopScheduleLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopTypeLangs()
    {
        return $this->hasMany(ShopTypeLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShowplaceLangs()
    {
        return $this->hasMany(ShowplaceLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShowplaceTypeLangs()
    {
        return $this->hasMany(ShowplaceTypeLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourLangs()
    {
        return $this->hasMany(TourLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourScheduleLangs()
    {
        return $this->hasMany(TourScheduleLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourTypeLangs()
    {
        return $this->hasMany(TourTypeLang::className(), ['lang_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \modules\translations\models\query\LangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\translations\models\query\LangQuery(get_called_class());
    }

    /**
     * Получение текущего объекта языка
     * @return Lang | ActiveRecord
     */
    static function getCurrent()
    {
        if( self::$current === null ){
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

    /**
     * Установка текущего объекта языка и локаль пользователя
     */
    static function setCurrent($url = null)
    {
        $language = self::getLangByUrl($url);
        if($language === null){
            $language = Yii::$app->session->get('language');
        }
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->session->set('language', self::$current);
        Yii::$app->language = self::$current->local;
    }

    /**
     * Получения объекта языка по умолчанию
     * @return Lang | ActiveRecord
     */
    static function getDefaultLang()
    {
        return Lang::find()->where('`default` = :default', [':default' => 1])->one();
    }

    /**
     * Получения объекта языка по буквенному идентификатору
     */
    static function getLangByUrl($url = null)
    {
        if ($url === null) {
            return null;
        } else {
            $language = Lang::find()->where('url = :url', [':url' => $url])->one();
            if ( $language === null ) {
                return null;
            }else{
                return $language;
            }
        }
    }

    /**
     * Возвращает список всех языков
     * @param string $fieldVal
     * @param string $filedKey
     * @return array
     */
    public static function getArr($fieldVal='name', $filedKey='id') {
        $list = self::find()->all();
        return ($list) ? ArrayHelper::map($list, $filedKey, $fieldVal) : [];
    }

}
