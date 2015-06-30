<?php

namespace modules\directory\controllers\console;

use Yii;
use yii\console\Controller;

/**
 * Blogs RBAC controller.
 */
class RbacController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'add';

    /**
     * @var array Main module permission array
     */
    public $mainPermission = [
        'name' => 'administrateDirectories',
        'description' => 'Can administrate all "Directories" module'
    ];

    /**
     * @var array Permission
     */
    public $permissions = [
        'BViewShowplace' => [
            'description' => 'Can view backend showplaces list'
        ],
        'BCreateShowplace' => [
            'description' => 'Can create backend showplaces'
        ],
        'BUpdateShowplace' => [
            'description' => 'Can update backend showplaces'
        ],
        'BDeleteShowplace' => [
            'description' => 'Can delete backend showplaces'
        ],
        'BViewShowplaceType' => [
            'description' => 'Can view backend showplace types list'
        ],
        'BCreateShowplaceType' => [
            'description' => 'Can create backend showplace types'
        ],
        'BUpdateShowplaceType' => [
            'description' => 'Can update backend showplace types'
        ],
        'BDeleteShowplaceType' => [
            'description' => 'Can delete backend showplace types'
        ],
        'BViewTourType' => [
            'description' => 'Can view backend tour types list'
        ],
        'BCreateTourType' => [
            'description' => 'Can create backend tour types'
        ],
        'BUpdateTourType' => [
            'description' => 'Can update backend tour types'
        ],
        'BDeleteTourType' => [
            'description' => 'Can delete backend tour types'
        ],
        'BViewLang' => [
            'description' => 'Can view backend lang list'
        ],
        'BCreateLang' => [
            'description' => 'Can create backend lang'
        ],
        'BUpdateLang' => [
            'description' => 'Can update backend lang'
        ],
        'BDeleteLang' => [
            'description' => 'Can delete backend lang'
        ],
        'BViewTranslation' => [
            'description' => 'Can view backend translations list'
        ],
        'BCreateTranslation' => [
            'description' => 'Can create backend translations'
        ],
        'BUpdateTranslation' => [
            'description' => 'Can update backend translations'
        ],
        'BDeleteTranslation' => [
            'description' => 'Can delete backend translations'
        ],
        'BViewCity' => [
	        'description' => 'Can view backend cities list'
        ],
        'BCreateCity' => [
	        'description' => 'Can create backend cities'
        ],
        'BUpdateCity' => [
	        'description' => 'Can update backend cities'
        ],
        'BDeleteCity' => [
	        'description' => 'Can delete backend cities'
        ],
        'BViewRegion' => [
	        'description' => 'Can view backend regions list'
        ],
        'BCreateRegion' => [
	        'description' => 'Can create backend regions'
        ],
        'BUpdateRegion' => [
	        'description' => 'Can update backend regions'
        ],
        'BDeleteRegion' => [
	        'description' => 'Can delete backend regions'
        ],
        'BCreatePlacementType' => [
            'description' => 'Can create placement type'
        ],
        'BViewPlacementType' => [
            'description' => 'Can view placement type'
        ],
        'BUpdatePlacementType' => [
            'description' => 'Can update placement type'
        ],
        'BDeletePlacementType' => [
            'description' => 'Can create placement type'
        ],
        'BCreateRestaurant' => [
            'description' => 'Can delete backend tour types'
        ],
        'BUpdateRestaurant' => [
            'description' => 'Can delete backend tour types'
        ],
        'BDeleteRestaurant' => [
            'description' => 'Can delete backend tour types'
        ],
        'BViewRestaurant' => [
            'description' => 'Can delete backend tour types'
        ],
        'BViewHub' => [
	        'description' => 'Can view backend hubs list'
        ],
        'BCreateHub' => [
	        'description' => 'Can create backend hubs'
        ],
        'BUpdateHub' => [
	        'description' => 'Can update backend hub'
        ],
        'BDeleteHub' => [
	        'description' => 'Can delete backend hub'
        ],
        'BViewTour' => [
            'description' => 'Can view backend tour list'
        ],
        'BCreateTour' => [
            'description' => 'Can create backend tours'
        ],
        'BUpdateTour' => [
            'description' => 'Can update backend tours'
        ],
        'BDeleteTour' => [
            'description' => 'Can delete backend tours'
        ],
        'BCreatePlacement' => [
            'description' => 'Can create backend Placement'
        ],
        'BUpdatePlacement' => [
            'description' => 'Can update backend Placement'
        ],
        'BDeletePlacement' => [
            'description' => 'Can delete backend Placement'
        ],
        'BViewPlacement' => [
            'description' => 'Can view backend tour types'
        ],
        'BCreateRoom' => [
            'description' => 'Can create backend Room'
        ],
        'BUpdateRoom' => [
            'description' => 'Can update backend Room'
        ],
        'BDeleteRoom' => [
            'description' => 'Can delete backend Room'
        ],
        'BViewRoom' => [
            'description' => 'Can view backend Room'
        ],
        'BViewPlacementOptions' => [
	        'description' => 'Can view backend placement options list'
        ],
        'BCreatePlacementOptions' => [
	        'description' => 'Can create backend placement options'
        ],
        'BUpdatePlacementOptions' => [
	        'description' => 'Can update backend placement option'
        ],
        'BDeletePlacementOptions' => [
	        'description' => 'Can delete backend placement option'
        ],
        'BServiceTour' => [
            'description' => 'Can view backend services of tours'
        ],
    ];

    /**
     * Add comments RBAC.
     */
    public function actionAdd()
    {
        $auth = Yii::$app->authManager;
        $superadmin = $auth->getRole('superadmin');
        $mainPermission = $auth->createPermission($this->mainPermission['name']);
        if (isset($this->mainPermission['description'])) {
            $mainPermission->description = $this->mainPermission['description'];
        }
        if (isset($this->mainPermission['rule'])) {
            $mainPermission->ruleName = $this->mainPermission['rule'];
        }
        if($auth->getPermission($mainPermission->name))
            $auth->update($mainPermission->name, $mainPermission);
        else
            $auth->add($mainPermission);

        foreach ($this->permissions as $name => $option) {
            $permission = $auth->createPermission($name);
            if (isset($option['description'])) {
                $permission->description = $option['description'];
            }
            if (isset($option['rule'])) {
                $permission->ruleName = $option['rule'];
            }
            if($auth->getPermission($permission->name)){
                $auth->update($permission->name, $permission);
            }
            else{
                $auth->add($permission);
            }
            if(!$auth->hasChild($mainPermission, $permission))
                $auth->addChild($mainPermission, $permission);
        }

        if(!$auth->hasChild($superadmin, $mainPermission))
            $auth->addChild($superadmin, $mainPermission);

        return static::EXIT_CODE_NORMAL;
    }

    /**
     * Remove comments RBAC.
     */
    public function actionRemove()
    {
        $auth = Yii::$app->authManager;
        $permissions = array_keys($this->permissions);

        foreach ($permissions as $name => $option) {
            $permission = $auth->getPermission($name);
            $auth->remove($permission);
        }

        $mainPermission = $auth->getPermission($this->mainPermission['name']);
        $auth->remove($mainPermission);

        return static::EXIT_CODE_NORMAL;
    }
}
