<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 01.06.15
 * Time: 14:55
 */

namespace modules\themes\admin;

class Theme extends \vova07\themes\admin\Theme
{

    /**
     * @inheritdoc
     */
    public $pathMap = [
        '@backend/views' => '@modules/themes/admin/views',
        '@backend/modules' => '@modules/themes/admin/modules'
    ];
} 