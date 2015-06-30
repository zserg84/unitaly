<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.06.15
 * Time: 10:24
 */

namespace modules\base\widgets\map;


use yii\web\AssetBundle;

class Asset extends AssetBundle
{

    public $sourcePath = '@modules/base/widgets/map/assets';

    public $js = [
//        'js/main.js',
    ];

    public $css = [
        'css/main.css',
    ];

} 