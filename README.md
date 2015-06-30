Yii2-start
==========

DEMO:
-----

**Frontend:** [http://yii2-start.find-freelancer.pro](http://yii2-start.find-freelancer.pro)  
**Backend:** [http://yii2-start.find-freelancer.pro/backend/](http://yii2-start.find-freelancer.pro/backend/)  

**Authentication:**  
_Login:_ `admin`  
_Password:_ `admin12345`  

Installation and getting started:
---------------------------------

**If you do not have Composer, you may install it by following the instructions at getcomposer.org.**

**If you do not have Composer-Asset-Plugin installed, you may install it by running command:** `php composer.phar global require "fxp/composer-asset-plugin:1.0.0"`

1. Run command: `cd /my/path/to/unitaly/` and go to main application directory.
2. Run command: `php requirements.php` and check the requirements.
3. Run command: `php init` to initialize the application with a specific environment.
4. Run command: `composer install`
5. Create a new database and adjust it configuration in `common/config/db.php` accordingly.
6. Apply migrations with console commands:
   - `php yii migrate --migrationPath=@vova07/users/migrations`
   - `php yii migrate
   - This will create tables needed for the application to work.
7. Run modules RBAC commands:
   - `php yii rbac/rbac/init`
   - `php yii users/rbac/add`
8. Run command: `php yii make/all`
Themes:
-------
- Application backend it's based on "AdminLTE" template. More detail about this nice template you can find [here](http://www.bootstrapstage.com/admin-lte/).
- Application frontend it's based on "Flat Theme". More detail about this nice theme you can find [here](http://shapebootstrap.net/item/flat-theme-free-responsive-multipurpose-site-template/).
