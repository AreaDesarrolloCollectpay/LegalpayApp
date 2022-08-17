<?php

Yii::import('application.models._base.BaseDebtors');

class Debtors extends BaseDebtors
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}