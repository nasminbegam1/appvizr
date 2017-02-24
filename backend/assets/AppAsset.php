<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700',
        'http://fonts.googleapis.com/css?family=Oswald:400,700,300',
        //'../admin/vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css',
        '../admin/vendors/font-awesome/css/font-awesome.min.css',
        '../admin/vendors/animate.css/animate.css',
        '../admin/vendors/jquery-pace/pace.css',
        '../admin/vendors/iCheck/skins/all.css',
        '../admin/vendors/jquery-notific8/jquery.notific8.min.css',
        '../admin/css/themes/style1/orange-blue.css',
        '../admin/css/style-responsive.css',
        '../admin/css/custom.css',
        //'../admin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
        '../admin/vendors/bootstrap-datepicker/css/datepicker.css',
        '../admin/css/msgPop.css'
    ];
    public $js = [
        '../admin/vendors/bootstrap/js/bootstrap.min.js',
        //'../admin/js/jquery-ui.js',
        '../admin/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js',
        '../admin/js/html5shiv.js',
        '../admin/js/respond.min.js',
        '../admin/vendors/metisMenu/jquery.metisMenu.js',
        '../admin/vendors/slimScroll/jquery.slimscroll.js',
        '../admin/vendors/jquery-cookie/jquery.cookie.js',
        '../admin/vendors/iCheck/icheck.min.js',
        '../admin/vendors/iCheck/custom.min.js',
        '../admin/vendors/jquery-notific8/jquery.notific8.min.js',
        '../admin/vendors/jquery-highcharts/highcharts.js',
        //'../admin/vendors/js/jquery.menu.js',
        '../admin/vendors/jquery-pace/pace.min.js',
        '../admin/vendors/holder/holder.js',
        '../admin/vendors/responsive-tabs/responsive-tabs.js',
        '../admin/vendors/jquery-news-ticker/jquery.newsTicker.min.js',
        '../admin/vendors/moment/moment.js',
        '../admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js',
        //'../admin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js',
        '../admin/js/main.js',
        '../admin/vendors/jquery-validate/jquery.validate.min.js',
        '../admin/js/form-validation.js',
        '../admin/vendors/bootstrap-markdown/js/bootstrap-markdown.js',
        '../admin/vendors/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        '../admin/vendors/ckeditor/ckeditor.js',
        '../admin/vendors/summernote/summernote.js',
        '../admin/js/ui-editors.js',
        '../admin/js/jquery.msgPop.js',
        '../admin/js/custom_function.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
