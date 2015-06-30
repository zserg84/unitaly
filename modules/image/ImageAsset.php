<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 09.06.15
 * Time: 12:08
 */

namespace modules\image;


use yii\web\AssetBundle;

class ImageAsset extends AssetBundle
{
    public function init()
    {
        parent::init();
        $this->sourcePath = \Yii::getAlias('@statics'); ;
    }

    public static function imgSrc($relativePath,$assetImageDir = 'img' ){
        $obj = new self();
        return \Yii::$app->assetManager->getPublishedUrl($obj->sourcePath)
        . "/" . $assetImageDir . "/" . $relativePath;
    }
} 