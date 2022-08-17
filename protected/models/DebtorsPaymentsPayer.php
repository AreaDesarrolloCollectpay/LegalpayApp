<?php

Yii::import('application.models._base.BaseDebtorsPaymentsPayer');

class DebtorsPaymentsPayer extends BaseDebtorsPaymentsPayer
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}