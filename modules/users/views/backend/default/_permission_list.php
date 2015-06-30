<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.06.15
 * Time: 17:00
 */

use modules\users\Module as UserModule;
use modules\users\models\backend\User;
use yii\widgets\Pjax;
use wbraganca\fancytree\FancytreeWidget;

Pjax::begin(['id'=>'pjax-permissions-container', 'enablePushState'=>false]);
if(!isset($permissionsAccess)){
    if($user->isNewRecord){
        $role = 'superadmin';
        $permissionsAccess = User::getDefaultRolePermission($role);
    }
    else{
        $auth = \Yii::$app->authManager;
        $assignments = $auth->getAssignments(1);
        $permissions = $auth->getPermissionsByUser(1);
        $permissionsAccess = [];
        foreach($assignments as $key=>$value){
            $permissionsAccess[] = $key;
        }
        foreach($permissions as $key=>$value){
            $permissionsAccess[] = $key;
        }
    }
}
$permissionsArray = UserModule::getPermissionsTree('superadmin', $permissionsAccess);
?>
    <div id="permissions-tree" name="selNodes">
    </div>
<?
echo FancytreeWidget::widget([
    'options' =>[
        'id' => 'permissions-tree',
        'source' => $permissionsArray,
        'extensions' => ['dnd'],
        'checkbox'=> 'true',
        'selectMode'=> 3,
        'generateIds' => true,
        'idPrefix' => 'asd',
        'dnd' => [
            'preventVoidMoves' => true,
            'preventRecursiveMoves' => true,
            'autoExpandMS' => 400,
        ],
    ]
]);
Pjax::end();

$this->registerJs("
    $('#user-form').on('beforeSubmit', function () {
        $('#permissions-tree').fancytree('getTree').generateFormElements('permissions[]');
        console.log(jQuery.param($(this).serializeArray()));
    });
");
