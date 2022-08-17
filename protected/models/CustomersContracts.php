<?php

Yii::import('application.models._base.BaseCustomersContracts');

class CustomersContracts extends BaseCustomersContracts
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}