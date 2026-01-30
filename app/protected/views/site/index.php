<?php
/* @var $this SiteController */

/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = Yii::app()->name;

$this->renderPartial('/book/index', ['dataProvider' => $dataProvider]);
?>
