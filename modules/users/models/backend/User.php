<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 08.06.15
 * Time: 12:44
 */

namespace modules\users\models\backend;

use modules\users\Module as UserModule;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class User extends \modules\users\models\User
{

    public $permissions = [];

    /**
     * @var string|null Password
     */
    public $password;

    /**
     * @var string|null Repeat password
     */
    public $repassword;

    /**
     * @var string Model status.
     */
    private $_status;

    /**
     * @return string Model status.
     */
    public function getStatus()
    {
        if ($this->_status === null) {
            $statuses = self::getStatusArray();
            $this->_status = $statuses[$this->status_id];
        }
        return $this->_status;
    }

    /**
     * @return array Status array.
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE => UserModule::t('users', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => UserModule::t('users', 'STATUS_INACTIVE'),
            self::STATUS_BANNED => UserModule::t('users', 'STATUS_BANNED')
        ];
    }

    /**
     * @return array Role array.
     */
    public static function getRoleArray()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
            [['username', 'email'], 'required'],
            [['password', 'repassword'], 'required', 'on' => ['admin-create']],
            // Trim
            [['username', 'email', 'password', 'repassword', 'name', 'surname'], 'trim'],
            // String
            [['password', 'repassword'], 'string', 'min' => 6, 'max' => 30],
            // Unique
            [['username', 'email'], 'unique'],
            // Username
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/'],
            ['username', 'string', 'min' => 3, 'max' => 30],
            // E-mail
            ['email', 'string', 'max' => 100],
            ['email', 'email'],
            // Repassword
            ['repassword', 'compare', 'compareAttribute' => 'password'],
            // Role
            ['role', 'in', 'range' => array_keys(self::getRoleArray())],
            // Status
            ['status_id', 'in', 'range' => array_keys(self::getStatusArray())],
            ['permissions', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'admin-create' => ['username', 'email', 'password', 'repassword', 'status_id', 'role'],
            'admin-update' => ['username', 'email', 'password', 'repassword', 'status_id', 'role']
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        return array_merge(
            $labels,
            [
                'password' => UserModule::t('users', 'PASSWORD'),
                'repassword' => UserModule::t('users', 'REPASSWORD')
            ]
        );
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord || (!$this->isNewRecord && $this->password)) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
                $this->generateToken();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        call_user_func([
            get_parent_class(get_parent_class($this)), 'afterSave'
        ], $insert, $changedAttributes);

        if ($this->profile !== null) {
            $this->profile->save(false);
        }

        $auth = \Yii::$app->authManager;
        $modelPermissions = $this->permissions ? $this->permissions : [];

        if (!$insert) {
            $auth->revokeAll($this->id);
        }

        $roles = $auth->getRoles();
        $permissions = $auth->getPermissions();
        foreach($modelPermissions as $permission){
            $permissionValue = false;
            if(array_key_exists($permission, $permissions)){
                $permissionValue = $auth->getPermission($permission);
            }
            if(array_key_exists($permission, $roles)){
                $permissionValue = $auth->getRole($permission);
            }
            if($permissionValue)
                $auth->assign($permissionValue, $this->id);
        }
    }

    public static function defaultRolesPermissions(){
        return [
            'superadmin' => [
                'accessBackend',
                'administrateDirectories',
                'administrateRbac',
                'administrateUsers',
            ],
            'admin' => [
                'accessBackend',
                'administrateDirectories',
            ],
            'user' => [],
        ];
    }

    public static function getDefaultRolePermission($role){
        $permisssions = self::defaultRolesPermissions();
        return isset($permisssions[$role]) ? $permisssions[$role] : null;
    }
} 