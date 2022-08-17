<?php

Yii::import('application.models._base.BasePaymentsState');

class PaymentsState extends BasePaymentsState
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}