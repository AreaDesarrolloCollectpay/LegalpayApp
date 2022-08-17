<?php

Yii::import('application.models._base.BaseDebtorsPayments');

class DebtorsPayments extends BaseDebtorsPayments
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}