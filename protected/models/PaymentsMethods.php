<?php

Yii::import('application.models._base.BasePaymentsMethods');

class PaymentsMethods extends BasePaymentsMethods
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}