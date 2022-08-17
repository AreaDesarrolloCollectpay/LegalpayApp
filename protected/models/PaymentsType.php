<?php

Yii::import('application.models._base.BasePaymentsType');

class PaymentsType extends BasePaymentsType
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}