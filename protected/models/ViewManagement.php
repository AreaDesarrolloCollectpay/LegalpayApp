<?php

Yii::import('application.models._base.BaseViewManagement');

class ViewManagement extends BaseViewManagement
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}