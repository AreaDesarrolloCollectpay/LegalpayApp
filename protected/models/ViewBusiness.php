<?php

Yii::import('application.models._base.BaseViewBusiness');

class ViewBusiness extends BaseViewBusiness
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}