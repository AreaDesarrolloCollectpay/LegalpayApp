<?php

Yii::import('application.models._base.BasePaymentsDiscrimination');

class PaymentsDiscrimination extends BasePaymentsDiscrimination
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}