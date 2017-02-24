<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800',
        'http://fonts.googleapis.com/css?family=Oswald:400,700,300',
        '../admin/vendors/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.10.3.custom.css',
        '../admin/vendors/font-awesome/css/font-awesome.min.css',
        '../admin/vendors/animate.css/animate.css',
        '../admin/vendors/iCheck/skins/all.css',
        '../admin/css/themes/style1/pink-blue.css',
        '../admin/css/style-responsive.css',
        '../admin/css/custom.css'
    ];
    public $js = [
        '../admin/js/jquery-ui.js',
        '../admin/js/jquery-migrate-1.2.1.min.js',
        '../admin/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js',
        '../admin/js/html5shiv.js',
        '../admin/js/respond.min.js',
        '../admin/vendors/iCheck/icheck.min.js',
        '../admin/vendors/iCheck/custom.min.js',
        '../admin/vendors/jquery-validate/jquery.validate.min.js',
        '../admin/js/form-validation.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
