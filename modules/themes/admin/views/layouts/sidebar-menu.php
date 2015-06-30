<div style="font-size: 12px">

<?php

/**
 * Sidebar menu layout.
 *
 * @var \yii\web\View $this View
 */

//use vova07\themes\admin\widgets\Menu;
use modules\themes\Module;
use kartik\sidenav\SideNav;

echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
    //'heading' => 'Options',
    'encodeLabels' => false,
    'activateParents' => true,
    'items' => [
        [
            'label' => Module::t('themes-admin', 'Directories'),
            'icon' => 'book',
            'items' => [
                [
                    'label' => Module::t('themes-admin', 'Geo'),
                    'items' => [
                        [
                            'label' => Module::t('themes-admin', 'Regions'),
                            'url' => ['/directory/region/index'],
                            'active'=>\Yii::$app->controller->id == 'region',
                            'visible' => Yii::$app->user->can('BViewRegion'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'Provinces'),
                            'url' => ['/directory/province/index'],
                            'active'=>\Yii::$app->controller->id == 'province',
                            'visible' => Yii::$app->user->can('BViewProvince'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'Cities'),
                            'url' => ['/directory/city/index'],
                            'active'=>\Yii::$app->controller->id == 'city',
                            'visible' => Yii::$app->user->can('BViewCity'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'Hubs'),
                            'url' => ['/directory/hub/index'],
                            'active'=>\Yii::$app->controller->id == 'hub',
                            'visible' => Yii::$app->user->can('BViewHub'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'Showplaces'),
                            'url' => ['/directory/showplace/index'],
                            'active'=>\Yii::$app->controller->id == 'showplace',
                            'visible' => Yii::$app->user->can('BViewShowplace'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'ShowplacesTypes'),
                            'url' => ['/directory/showplace-type/index'],
                            'active'=>\Yii::$app->controller->id == 'showplace-type',
                            'visible' => Yii::$app->user->can('BViewShowplaceType'),
                        ],
                    ]
                ],
                [
                    'label' => Module::t('themes-admin', 'Tour'),
                    'items' => [
                        [
                            'label' => Module::t('themes-admin', 'TourTypes'),
                            'url' => ['/directory/tour-type/index'],
                            'visible' => Yii::$app->user->can('BViewTourType'),
                            'active'=>\Yii::$app->controller->id == 'tour-type',
                        ],
                        [
                            'label' => Module::t('themes-admin', 'Tours'),
                            'url' => ['/directory/tour/index'],
                            'visible' => Yii::$app->user->can('BViewTour'),
                            'active'=>\Yii::$app->controller->id == 'tour',
                        ],
                    ]
                ],
                [
                    'label' => Module::t('themes-admin', 'Placement'),
                    'items' => [
	                    [
                            'label' => Module::t('themes-admin', 'Placements'),
                            'url' => ['/directory/placement/index'],
                            'active'=>\Yii::$app->controller->id == 'placement',
                            'visible' => Yii::$app->user->can('BViewPlacement'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'PlacementTypes'),
                            'url' => ['/directory/placement-type/index'],
                            'active'=>\Yii::$app->controller->id == 'placement-type',
                            'visible' => Yii::$app->user->can('BViewPlacementType'),
                        ],
	                    [
		                    'label' => Module::t('themes-admin', 'PlacementOptions'),
		                    'url' => ['/directory/placement-options/index'],
		                    'active'=>\Yii::$app->controller->id == 'placement-options',
		                    'visible' => Yii::$app->user->can('BViewPlacementOptions'),
	                    ],
                        [
                            'label' => Module::t('themes-admin', 'Room'),
                            'url' => ['/directory/room/index'],
                            'active'=>\Yii::$app->controller->id == 'room',
                            'visible' => Yii::$app->user->can('BViewRoom'),
                        ],
	                    [
		                    'label' => Module::t('themes-admin', 'RoomType'),
		                    'url' => ['/directory/room-type/index'],
		                    'active'=>\Yii::$app->controller->id == 'room-type',
		                    'visible' => Yii::$app->user->can('BViewRoomType'),
	                    ],
	                    [
		                    'label' => Module::t('themes-admin', 'RoomOptions'),
		                    'url' => ['/directory/room-options/index'],
		                    'active'=>\Yii::$app->controller->id == 'room-options',
		                    'visible' => Yii::$app->user->can('BViewRoomOptions'),
	                    ],
                    ]
                ],
                [
                    'label' => Module::t('themes-admin', 'Places'),
                    'items' => [
                        [
                            'label' => Module::t('themes-admin', 'Restaurants'),
                            'url' => ['/directory/restaurant/index'],
                            'active'=>\Yii::$app->controller->id == 'restaurant',
                            'visible' => Yii::$app->user->can('BViewRestaurant'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'Cafes'),
                            'url' => ['/directory/cafe/index'],
                            'active'=>\Yii::$app->controller->id == 'cafe',
                            'visible' => Yii::$app->user->can('BViewCafe'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'Shop-categories'),
                            'url' => ['/directory/shop-category/index'],
                            'active'=> in_array(\Yii::$app->controller->id, ['shop-category']),
                            'visible' => Yii::$app->user->can('BViewShopCategory'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'Market-categories'),
                            'url' => ['/directory/market-category/index'],
                            'active'=> in_array(\Yii::$app->controller->id, ['market-category']),
                            'visible' => Yii::$app->user->can('BViewShopCategory'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'Shops'),
                            'url' => ['/directory/shop/index'],
                            'active'=> in_array(\Yii::$app->controller->id, ['shop', 'outlet', 'mall', 'supermarket', 'store', 'market']),
                            'visible' => Yii::$app->user->can('BViewShop'),
                        ],
                        [
                            'label' => Module::t('themes-admin', 'ShopTypes'),
                            'url' => ['/directory/shop-type/index'],
                            'active'=> \Yii::$app->controller->id == 'shop-type',
                            'visible' => Yii::$app->user->can('BViewShopType'),
                        ],
                    ]
                ]
            ],
        ],
        [
            'label' => Module::t('themes-admin', 'Users'),
            'url' => ['/users/default/index'],
            'icon' => 'user',
            'visible' => Yii::$app->user->can('administrateUsers') || Yii::$app->user->can('BViewUsers'),
        ],
        [
            'label' => Module::t('themes-admin', 'Access control'),
            'icon' => 'cloud',
            'items' => [
                [
                    'label' => Module::t('themes-admin', 'Permissions'),
                    'url' => ['/rbac/permissions/index'],
                    'active'=>\Yii::$app->controller->id == 'permissions',
                    'visible' => Yii::$app->user->can('administrateRbac') || Yii::$app->user->can('BViewPermissions')
                ],
                [
                    'label' => Module::t('themes-admin', 'Roles'),
                    'url' => ['/rbac/roles/index'],
                    'active'=>\Yii::$app->controller->id == 'roles',
                    'visible' => Yii::$app->user->can('administrateRbac') || Yii::$app->user->can('BViewRoles')
                ],
                [
                    'label' => Module::t('themes-admin', 'Rules'),
                    'url' => ['/rbac/rules/index'],
                    'active'=>\Yii::$app->controller->id == 'rules',
                    'visible' => Yii::$app->user->can('administrateRbac') || Yii::$app->user->can('BViewRules')
                ]
            ]
        ],
        [
            'label' => Module::t('themes-admin', 'Lang'),
            'icon'=> 'bullhorn',
            'items' => [
                [
                    'label' => Module::t('themes-admin', 'Lang'),
                    'url' => ['/translations/lang/index'],
                    'active'=>\Yii::$app->controller->id == 'lang',
                    'visible' => Yii::$app->user->can('administrateUsers') || Yii::$app->user->can('BViewLang'),
                ],
                [
                    'label' => Module::t('themes-admin', 'Translations'),
                    'url' => ['/translations/default/index'],
                    'active'=> \Yii::$app->controller->id == 'default' && Yii::$app->module && Yii::$app->module->id == 'translations',
                ],
            ]
        ],
    ],
]);

?>

</div>