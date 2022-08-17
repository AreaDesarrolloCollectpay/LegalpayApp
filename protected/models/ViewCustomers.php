<?php

Yii::import('application.models._base.BaseViewCustomers');

class ViewCustomers extends BaseViewCustomers
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}