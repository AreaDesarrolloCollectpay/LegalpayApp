<?php

Yii::import('application.models._base.BasePaymentsWhopaid');

class PaymentsWhopaid extends BasePaymentsWhopaid
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}