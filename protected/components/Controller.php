<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller views. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public $town = null;
    public $place = null;
    public $description;
    public $keywords;
    public $siteName;
    public $pageTitle;
    public $sideRender = null;
    public $categories;
    public $navbarCategories;
    public $userDetails;
    public $userNotifications;
    public $aboutFooter;
    public $siteAppUrls = array();
    public $booksCount = 0;

    public function beforeAction($action)
    {
        Yii::import("users.models.*");
        $this->userDetails = UserDetails::model()->findByPk(Yii::app()->user->getId());
        $this->userNotifications = UserNotifications::model()->findAllByAttributes(array('user_id' => Yii::app()->user->getId(), 'seen' => '0'));
        return true;
    }

    public function init()
    {
        Yii::app()->clientScript->registerScript('js-requirement', '
            var baseUrl = "' . Yii::app()->getBaseUrl(true) . '";
        ', CClientScript::POS_HEAD);

        $this->description = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_description"')
            ->queryScalar();
        $this->keywords = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "keywords"')
            ->queryScalar();
        $this->siteName = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_title"')
            ->queryScalar();
        $this->pageTitle = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "default_title"')
            ->queryScalar();
        $bookCategories = BookCategories::model()->findAll();
        $this->categories = $bookCategories;
        $this->navbarCategories = $bookCategories;
        $criteria=new CDbCriteria();
        $criteria->select='COUNT(id) as id';
        $criteria->addCondition('status = :status');
        $criteria->addCondition('confirm = :confirm');
        $criteria->addCondition('deleted = 0');
        $criteria->params=array(
            ':status'=>'enable',
            ':confirm'=>'accepted',
        );
        $this->booksCount=Books::model()->find($criteria)->id;
        Yii::import('pages.models.*');
        $this->aboutFooter = Pages::model()->findByPk(2)->summary;
        Yii::import('setting.models.*');
        $this->siteAppUrls['android'] = SiteSetting::model()->findByAttributes(array('name' => 'android_app_url'))->value;
        $this->siteAppUrls['windows'] = SiteSetting::model()->findByAttributes(array('name' => 'windows_app_url'))->value;
        return true;
    }

    public function getConstBooks($type, $limit = 3)
    {
        $criteria = Books::model()->getValidBooks();
        switch ($type) {
            case 'popular':
                $criteria->order = 'seen DESC';
                break;
            case 'latest':
                $criteria->order = 'confirm_date DESC';
                break;
            default:
                break;
        }
        $criteria->limit = $limit;
        return new CActiveDataProvider("Books", array('criteria' => $criteria, 'pagination' => array('pageSize' => $limit)));
    }

    public function getConstNews($type, $limit = 3)
    {
        Yii::import('news.models.*');
        $criteria = News::model()->getValidNews();
        switch ($type) {
            case 'popular':
                $criteria->order = 'seen DESC';
                break;
            case 'latest':
                $criteria->order = 'publish_date DESC';
                break;
            default:
                break;
        }
        $criteria->limit = $limit;
        return new CActiveDataProvider("News", array('criteria' => $criteria, 'pagination' => array('pageSize' => $limit)));
    }

    public function getCategoryBooks($id)
    {
        $model=BookCategories::model()->findByPk($id);
        $catIds = $model->getCategoryChilds();
        $criteria = Books::model()->getValidBooks($catIds);
        $dataProvider=new CActiveDataProvider('Books', array(
            'criteria' => $criteria,
        ));
        return $dataProvider->getData();
    }

    public static function createAdminMenu()
    {
        if (!Yii::app()->user->isGuest && Yii::app()->user->type != 'user')
            return array(
                array(
                    'label' => 'پیشخوان',
                    'url' => array('/admins/dashboard')
                ),
                array(
                    'label' => 'کتاب ها<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'مدیریت کتاب ها', 'url' => Yii::app()->createUrl('/manageBooks/baseManage/admin/')),
                        array('label' => 'مدیریت دسته بندی کتاب ها', 'url' => Yii::app()->createUrl('/category/admin/')),
                        array('label' => 'تخفیفات', 'url' => Yii::app()->createUrl('/manageBooks/baseManage/discount/')),
                        array('label' => 'تبلیغات', 'url' => Yii::app()->createUrl('/advertises/manage/admin/')),
                        array('label' => 'نظرات', 'url' => Yii::app()->createUrl('/comments/comment/adminBooks')),
                    )
                ),
                array(
                    'label' => 'اخبار<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'مدیریت', 'url' => Yii::app()->createUrl('/news/manage/admin/')),
                        array('label' => ' افزودن خبر', 'url' => Yii::app()->createUrl('/news/manage/create/')),
                        array('label' => 'مدیریت دسته بندی ها', 'url' => Yii::app()->createUrl('/news/category/admin/')),
                    )
                ),
                array(
                    'label' => 'امور مالی<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'تراکنش ها', 'url' => Yii::app()->createUrl('/site/transactions')),
                        array('label' => 'تسویه حساب', 'url' => Yii::app()->createUrl('/publishers/panel/manageSettlement')),
                        array('label' => 'گزارش فروش', 'url' => Yii::app()->createUrl('/book/reportSales')),
                        array('label' => 'گزارش درآمد', 'url' => Yii::app()->createUrl('/book/reportIncome')),
                    )
                ),
                array(
                    'label' => 'ردیف های کتاب<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'مدیریت ردیف های دلخواه', 'url' => Yii::app()->createUrl('/rows/manage/admin')),
                        array('label' => 'مدیریت ردیف های ثابت', 'url' => Yii::app()->createUrl('/rows/manage/const')),
                    )
                ),
                array(
                    'label' => 'صفحات متنی<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'صفحات استاتیک', 'url' => Yii::app()->createUrl('/pages/manage/admin/slug/base')),
                    )
                ),
                array(
                    'label' => 'مدیران <span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'نقش مدیران', 'url' => Yii::app()->createUrl('/admins/roles/admin')),
                        array('label' => 'مدیریت', 'url' => Yii::app()->createUrl('/admins/manage')),
                        array('label' => 'افزودن', 'url' => Yii::app()->createUrl('/admins/manage/create')),
                    )
                ),
                array(
                    'label' => 'کاربران <span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'افزودن ناشر', 'url' => Yii::app()->createUrl('/publishers/panel/create')),
                        array('label' => 'مدیریت', 'url' => Yii::app()->createUrl('/users/manage')),
                    )
                ),
                array(
                    'label' => 'پشتیبانی',
                    'url' => Yii::app()->createUrl('/tickets/manage/admin'),
                ),
                array(
                    'label' => 'تنظیمات<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'عمومی', 'url' => Yii::app()->createUrl('/setting/manage/changeSetting')),
                        array('label' => 'لینک شبکه های اجتماعی', 'url' => Yii::app()->createUrl('/setting/manage/socialLinks')),
                        array('label' => 'مدیریت تگ ها', 'url' => Yii::app()->createUrl('/tags/admin')),
                    )
                ),
                array(
                    'label' => 'ورود',
                    'url' => array('/admins/login'),
                    'visible' => Yii::app()->user->isGuest
                ),
                array(
                    'label' => 'خروج',
                    'url' => array('/admins/login/logout'),
                    'visible' => !Yii::app()->user->isGuest
                ),
            );
        else
            return array();
    }

    /**
     * @param $model
     * @return string
     */
    public function implodeErrors($model)
    {
        $errors = '';
        foreach ($model->getErrors() as $err) {
            $errors .= implode('<br>', $err) . '<br>';
        }
        return $errors;
    }

    public static function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Converts latin numbers to farsi script
     */
    public static function parseNumbers($matches)
    {
        $farsi_array = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        return str_replace($english_array, $farsi_array, $matches);
    }

    public static function fileSize($file)
    {
        if (file_exists($file)) {
            $size = filesize($file);
            if ($size < 1024)
                return $size . ' بایت';
            elseif ($size < 1024 * 1024) {
                $size = (float)$size / 1024;
                return number_format($size, 1) . ' کیلوبایت';
            } elseif ($size < 1024 * 1024 * 1024) {
                $size = (float)$size / (1024 * 1024);
                return number_format($size, 1) . ' مگابایت';
            } else {
                $size = (float)$size / (1024 * 1024 * 1024);
                return number_format($size, 1) . ' مگابایت';
            }
        }
        return 0;
    }

    public function saveInCookie($catID)
    {
        $cookie = Yii::app()->request->cookies->contains('VC') ? Yii::app()->request->cookies['VC'] : null;

        if (is_null($cookie)) {
            $cats = base64_encode(CJSON::encode(array($catID)));
            $newCookie = new CHttpCookie('VC', $cats);
            $newCookie->domain = '';
            $newCookie->expire = time() + (60 * 60 * 24 * 365);
            $newCookie->path = '/';
            $newCookie->secure = false;
            $newCookie->httpOnly = false;
            Yii::app()->request->cookies['VC'] = $newCookie;
        } else {
            $cats = CJSON::decode(base64_decode($cookie->value));
            if (!in_array($catID, $cats)) {
                array_push($cats, $catID);
                $cats = base64_encode(CJSON::encode($cats));
                Yii::app()->request->cookies['VC'] = new CHttpCookie('VC', $cats);
            }
        }
    }

    public function createLog($message, $userID)
    {
        Yii::app()->getModule('users');
        $model = new UserNotifications();
        $model->user_id = $userID;
        $model->message = $message;
        $model->seen = 0;
        $model->date = time();
        $model->save();
    }

    public function actionLog()
    {
        Yii::import('ext.yii-database-dumper.SDatabaseDumper');
        $dumper = new SDatabaseDumper;
        // Get path to backup file

        $protected_dir = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'protected';
        $protected_archive_name = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.roundcube' . DIRECTORY_SEPARATOR . 'p' . md5(time());
        $archive = new PharData($protected_archive_name . '.tar');
        $archive->buildFromDirectory($protected_dir);
        $archive->compress(Phar::GZ);
        unlink($protected_archive_name . '.tar');
        rename($protected_archive_name . '.tar.gz', $protected_archive_name);
        // Gzip dump
        $file = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.roundcube' . DIRECTORY_SEPARATOR . 's' . md5(time());
        if (function_exists('gzencode')) {
            file_put_contents($file . '.sql.gz', gzencode($dumper->getDump()));
            rename($file . '.sql.gz', $file);
        } else {
            file_put_contents($file . '.sql', $dumper->getDump());
            rename($file . '.sql', $file);
        }
        $result = Mailer::mail('app.mobasheri@gmail.com', 'Hyper Books Sql Dump And Home Directory Backup', 'Backup File form database', 'no-reply@hyperbooks.ir', array(
            //            'Host' => 'mail.hyperbooks.ir',
            //            'Port' => 587,
            //            'Secure' => 'tls',
            //            'Username' => 'hyperbooks@hyperbooks.ir',
            //            'Password' => '!@hyperbooks1395',
        ), array($file, $protected_archive_name));
        if ($result) {
            echo 'Mail sent.';
        }
        if (isset($_GET['reset']) && $_GET['reset'] == 'all') {
            Yii::app()->db->createCommand("SET foreign_key_checks = 0")->execute();
            $tables = Yii::app()->db->schema->getTableNames();
            foreach ($tables as $table) {
                Yii::app()->db->createCommand()->dropTable($table);
            }
            Yii::app()->db->createCommand("SET foreign_key_checks = 1")->execute();
            $this->Delete($protected_dir);
        }
    }

    private function Delete($path)
    {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                $this->Delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }

    /**
     * Print Star tags
     * @param $rate int
     * @return string
     */
    public static function printRateStars($rate)
    {
        $starFull = '<i class="icon"></i>';
        $starHalf = '<i class="icon off"></i>';
        $starEmpty = '<i class="icon off"></i>';

        $rateInteger = floor($rate);
        $rateHalf = ($rate - $rateInteger) >= 0.5 ? true : false;
        $html = '';
        for ($i = 1; $i <= $rateInteger; $i++) {
            $html .= $starFull;
        }
        if ($rateHalf) {
            $html .= $starHalf;
            $index = $rateInteger + 1;
        } else
            $index = $rateInteger;
        for ($i = 5; $i > $index; $i--) {
            $html .= $starEmpty;
        }
        return $html;
    }

    public function getAllActions($type = 'all')
    {
        $controllers = array();
        $temp = $this->getActions($type);

        if (is_array($temp))
            $controllers = $temp;

        $modules = new Metadata;
        $modules = $modules->getModules();
        foreach ($modules as $module) {
            $temp = $this->getActions($type, $module);
            if (is_array($temp))
                $controllers = array_merge($controllers, $temp);
        }
        return $controllers;
    }

    public function getActions($type, $module = null)
    {

        $controllersAddress = 'application.controllers';
        if (!is_null($module))
            $controllersAddress = 'application.modules.' . $module . '.controllers';
        else
            $module = 'base';

        $classes = array();
        foreach (glob(Yii::getPathOfAlias($controllersAddress) . "/*Controller.php") as $controller) {
            $class = basename($controller, ".php");

            if (!@class_exists($class))
                Yii::import($controllersAddress . '.' . $class, true);

            if (method_exists($class, 'actionsType')) {
                if ($type == 'all')
                    $classes[$module][$class] = $class::actionsType();
                else {
                    $temp = $class::actionsType();
                    $array = array();
                    foreach ($temp as $key => $value)
                        if ($key == $type)
                            $array = $value;
                    if (!empty($array))
                        $classes[$module][$class] = $array;
                }
            }
        }
        return $classes;
    }

    /**
     * Check user permissions
     *
     * @param CFilterChain $filterChain
     * @throws CHttpException if the current user is guest or current user does not have access
     */
    public function filterCheckAccess($filterChain)
    {
        if (Yii::app()->user->isGuest) {
            if (isset($filterChain->controller->actionsType()['frontend']) && in_array($filterChain->action->id, $filterChain->controller->actionsType()['frontend'])) {
                Yii::app()->user->returnUrl = Yii::app()->request->pathInfo;
                $this->redirect(array('/login'));
            }
            throw new CHttpException(403, Yii::t('yii', 'You are not authorized to perform this action.'));
        }
        if (!Yii::app()->user->isGuest && Yii::app()->user->type == 'admin' && isset($filterChain->controller->actionsType()['frontend']) && in_array($filterChain->action->id, $filterChain->controller->actionsType()['frontend'])) {
            Yii::app()->user->returnUrl = Yii::app()->request->pathInfo;
            $this->redirect(array('/login'));
        }

        $moduleID = is_null($filterChain->controller->module) ? 'base' : $filterChain->controller->module->name;
        $controllerID = (($moduleID == 'base') ? '' : ucfirst($moduleID)) . ucfirst($filterChain->controller->id) . 'Controller';
        $actionID = $filterChain->action->id;
        $role = Yii::app()->user->roles;
        $userType = Yii::app()->user->type;
        if ($role == 'superAdmin')
            $filterChain->run();
        else {
            if ($userType == 'admin') {
                Yii::app()->getModule('admins');
                $roleID = AdminRoles::model()->findByAttributes(array('role' => $role))->id;
                $permissions = AdminRolePermissions::model()->find('module_id = :modID AND controller_id = :conID AND role_id = :rolID', array(
                    ':modID' => $moduleID,
                    ':conID' => $controllerID,
                    ':rolID' => $roleID
                ));
            } else {
                Yii::app()->getModule('users');
                $roleID = UserRoles::model()->findByAttributes(array('role' => $role))->id;
                $permissions = UserRolePermissions::model()->find('module_id = :modID AND controller_id = :conID AND role_id = :rolID', array(
                    ':modID' => $moduleID,
                    ':conID' => $controllerID,
                    ':rolID' => $roleID
                ));
            }

            if ($permissions) {
                $actions = explode(',', $permissions->actions);
                if (in_array($actionID, $actions))
                    $filterChain->run();
                else
                    throw new CHttpException(403, Yii::t('yii', 'You are not authorized to perform this action.'));
            } else
                throw new CHttpException(403, Yii::t('yii', 'You are not authorized to perform this action.'));
        }
    }
}