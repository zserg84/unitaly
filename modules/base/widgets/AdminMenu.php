<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 11.06.15
 * Time: 10:50
 */

namespace modules\base\widgets;

use Yii;

class AdminMenu extends \vova07\themes\admin\widgets\Menu
{

    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $routes = [];
            $routes[] = $item['url'][0];

            $childUrls = isset($item['childUrls']) ? $item['childUrls'] : [];
            foreach($childUrls as $childUrl){
                if(is_array($childUrl) && isset($childUrl[0])){
                    $routes[] = $childUrl[0];
                }
            }
            $active = false;
            foreach($routes as $route){
                if ($route[0] !== '/' && Yii::$app->controller) {
                    $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
                }

                if (ltrim($route, '/') !== $this->route) {
                    continue;
                }
                $active = true;
            }
            if(!$active)
                return false;

            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }
} 