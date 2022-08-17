<?php

Yii::import('application.models._base.BasePaymentsPlatforms');

class PaymentsPlatforms extends BasePaymentsPlatforms
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}