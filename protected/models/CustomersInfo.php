<?php

Yii::import('application.models._base.BaseCustomersInfo');

class CustomersInfo extends BaseCustomersInfo
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}