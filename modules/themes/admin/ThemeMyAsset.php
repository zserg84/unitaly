<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 01.06.15
 * Time: 14:57
 */

namespace modules\themes\admin;


use yii\web\AssetBundle;

class ThemeMyAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@modules/themes/admin/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/style.css'
    ];

    public $js = [
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];

} 