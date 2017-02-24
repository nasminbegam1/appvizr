<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
        
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="text/javascript">
       var _baseUrl= '<?=Url::home(true);?>';
    </script>    

</head>
<body>
<?php $this->beginBody() ?>

<div>
    <!--BEGIN BACK TO TOP--><a id="totop" href=""><i class="fa fa-angle-up"></i></a><!--END BACK TO TOP--><!--BEGIN TOPBAR-->
    <div id="header-topbar-option-demo" class="page-header-topbar">
        <nav id="topbar" role="navigation" style="margin-bottom: 0; z-index: 2;" class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                <a id="logo" href="<?= Url::toRoute('/user/dashboard')?>" class="navbar-brand"><span class="fa fa-rocket"></span><span class="logo-text"><?php echo Html::img(Yii::$app->urlManager->baseUrl.'/images/logo1.png') ?></span></a>
            </div>
            <div class="topbar-main">
                <ul class="nav navbar navbar-top-links navbar-right mbn">
                    <li class="dropdown topbar-user">
                    <a data-hover="dropdown" href="<?= Url::toRoute('/user/dashboard')?>" class="dropdown-toggle">
                    &nbsp;<span class="hidden-xs"><?php echo ucfirst(Yii::$app->user->identity->username); ?></span>&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-user pull-right">
                            <li><a href="<?= Url::toRoute('/user/editprofile')?>"><i class="fa fa-edit"></i>Edit profile</a></li>
                            <li><a href="<?= Url::toRoute('/user/changepassword')?>"><i class="fa fa-key"></i>Change Password</a></li>
                            <li><a href="<?= Url::toRoute('/site/logout')?>" data-method="post"><i class="fa fa-sign-out"></i>Log Out</a></li>
                        </ul>
                    </li>
                   
                </ul>
            </div>
        </nav>
    </div>
    
    <div id="wrapper">
    <nav id="sidebar" role="navigation" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">
                    <li class="user-panel">
                        <!--<div class="thumb">
                            <img src="">
                        </div>-->
                        <div class="info"><p><?php echo ucfirst(Yii::$app->user->identity->username); ?></p>
                            <ul class="list-inline list-unstyled">
                                <li><a href="<?= Url::toRoute('/user/editprofile')?>" data-hover="tooltip" title="Profile"><i class="fa fa-user"></i></a></li>
                              <li><a href="<?= Url::toRoute('/site/logout')?>" data-method="post" data-hover="tooltip" title="Logout"><i class="fa fa-sign-out"></i></a></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                    <li class="<?php echo Yii::$app->helpers->isActiveRoute('user','dashboard'); ?>" ><a href="<?= Url::toRoute('/user/dashboard')?>"><i class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Dashboard</span></a></li>
                    <li class="<?php echo Yii::$app->helpers->isActiveRoute('sitesettings','index');echo Yii::$app->helpers->isActiveRoute('sitesettings','update');?>"><a href="<?= Url::toRoute('/sitesettings/index')?>"><i class="fa fa-cogs fa-fw">
                        <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">Site Settings</span></a>
		     </li>
                     <li class="<?php echo Yii::$app->helpers->isActiveRoute('pricerange','index');echo Yii::$app->helpers->isActiveRoute('pricerange','update');echo Yii::$app->helpers->isActiveRoute('pricerange','create');?>"><a href="<?= Url::toRoute('/pricerange/index')?>"><i class="fa fa-ticket">
                        <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">Set Price range</span></a>
		     </li>
                    <li class="<?php echo Yii::$app->helpers->isActiveRoute('category','index');echo Yii::$app->helpers->isActiveRoute('category','create'); echo Yii::$app->helpers->isActiveRoute('category','update'); echo Yii::$app->helpers->isActiveRoute('category','view'); ?>" ><a href="<?= Url::toRoute('/category/index')?>"><i class="fa fa-list">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Category</span></a></li>
                    <li class="<?php echo Yii::$app->helpers->isActiveRoute('subcategory','index');echo Yii::$app->helpers->isActiveRoute('subcategory','create'); echo Yii::$app->helpers->isActiveRoute('subcategory','update'); echo Yii::$app->helpers->isActiveRoute('subcategory','view'); ?>" ><a href="<?= Url::toRoute('/subcategory/index')?>"><i class="fa fa-outdent">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Sub-Category</span></a></li>
                    <li class="<?php echo Yii::$app->helpers->isActiveRoute('qualification','index');echo Yii::$app->helpers->isActiveRoute('qualification','create'); echo Yii::$app->helpers->isActiveRoute('qualification','update'); echo Yii::$app->helpers->isActiveRoute('qualification','view'); ?>" ><a href="<?= Url::toRoute('/qualification/index')?>"><i class="fa fa-graduation-cap">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Qualification</span></a></li>
                    <li class="<?php echo Yii::$app->helpers->isActiveRoute('country','index'); echo Yii::$app->helpers->isActiveRoute('country','update'); echo Yii::$app->helpers->isActiveRoute('country','view'); ?>" ><a href="<?= Url::toRoute('/country/index')?>"><i class="fa fa-flag">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Country</span></a></li>
                    <li class="<?php echo Yii::$app->helpers->isActiveRoute('consultant','index'); echo Yii::$app->helpers->isActiveRoute('consultant','update'); echo Yii::$app->helpers->isActiveRoute('consultant','view');echo Yii::$app->helpers->isActiveRoute('customer','index'); echo Yii::$app->helpers->isActiveRoute('customer','update'); echo Yii::$app->helpers->isActiveRoute('customer','view'); ?>"><a href="javascript:void(0);"><i class="fa fa-users fa-fw">
                        <div class="icon-bg bg-violet"></div>
                        </i><span class="menu-title">User</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" style="height: 0px;">
                            <li class="<?php echo Yii::$app->helpers->isActiveRoute('consultant','index'); echo Yii::$app->helpers->isActiveRoute('consultant','update'); echo Yii::$app->helpers->isActiveRoute('consultant','view'); ?>"><a href="<?= Url::toRoute('/consultant')?>"><i class="fa fa-user"></i><span class="submenu-title">Consultant</span></a></li>
                            <li class="<?php echo Yii::$app->helpers->isActiveRoute('customer','index'); echo Yii::$app->helpers->isActiveRoute('customer','update'); echo Yii::$app->helpers->isActiveRoute('customer','view'); ?>"><a href="<?= Url::toRoute('/customer')?>"><i class="fa fa-user"></i><span class="submenu-title">Customers</span></a></li>
                        </ul>
                    </li>
                 </ul>
            </div>
    </nav>
    <div id="page-wrapper">
        <?php if(Yii::$app->session->hasFlash('success')) { ?>
            <div id="flashmessage" class="page_mess_animate page_mess_ok"><?= Yii::$app->session->getFlash('success');?></div>
        <?php } ?>
        <?php if(Yii::$app->session->hasFlash('error')) { ?>
            <div id="flashmessage" class="page_mess_animate page_mess_error"><?= Yii::$app->session->getFlash('error');?></div>
        <?php } ?>    
        <?= $content ?>
    </div>
    <!--BEGIN FOOTER-->
        <div id="footer">
            <div class="copyright"><?php echo date('Y');?> &copy; appvizr</div>
        </div>
    <!--END FOOTER--><!--END PAGE WRAPPER-->
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
