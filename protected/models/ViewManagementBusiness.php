<?php

Yii::import('application.models._base.BaseViewManagementBusiness');

class ViewManagementBusiness extends BaseViewManagementBusiness
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}