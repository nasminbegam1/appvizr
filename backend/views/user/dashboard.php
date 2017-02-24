<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = 'Appvizr';
?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Dashboard</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="javascript:void(0);">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="hidden"><a href="javascript:void(0);">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Dashboard</li>
                </ol>
                <div class="clearfix"></div>
    </div>
        <div class="page-content">
                <!--<h2 align="center">Welcome to admin panel</h2>-->
                        <div id="sum_box" class="row mbl">
                        <div class="col-sm-6 col-md-4">
                        <a href="<?= Url::toRoute('/category')?>">
                            <div class="panel visit db mbm">
                                <div class="panel-body"><p class="icon" style="font-size: 42px"><i class="fa fa-list" style="color : #A4BB24"></i></p><h4 class="value"><span><b><?= $category ?></b></span></h4>

                                    <p class="description">Number of Category</p>

                                </div>
                            </div>
                        </a>
                        </div>
                        
                        <div class="col-sm-6 col-md-4">
                        <a href="<?= Url::toRoute('/subcategory')?>">
                            <div class="panel visit db mbm">
                                <div class="panel-body"><p class="icon" style="font-size: 42px"><i class="fa fa-outdent" style="color : #E0ED6A"></i></p><h4 class="value"><span><b><?= $subcat; ?></b></span></h4>

                                    <p class="description">Number of Sub-category</p>

                                </div>
                            </div>
                        </a>
                        </div>
                        
                        <div class="col-sm-6 col-md-4">
                        <a href="<?= Url::toRoute('/qualification')?>">
                            <div class="panel visit db mbm">
                                <div class="panel-body"><p class="icon" style="font-size: 42px"><i class="fa fa-graduation-cap" style="color : #947EE5"></i></p><h4 class="value"><span><b><?= $qualification; ?></b></span></h4>

                                    <p class="description">Number of Qualification</p>

                                </div>
                            </div>
                        </a>
                        </div>
                        <div class="col-sm-6 col-md-4">
                        <a href="<?= Url::toRoute('/country')?>">
                            <div class="panel visit db mbm">
                                <div class="panel-body"><p class="icon" style="font-size: 42px"><i class="fa fa-flag"></i></p><h4 class="value"><span><b><?= $country; ?></b></span></h4>

                                    <p class="description">Number of Country</p>

                                </div>
                            </div>
                        </a>
                        </div>
                        
                    </div>

    </div>
