<?php

Yii::import('application.models._base.BaseDebtorsTasksSupport');

class DebtorsTasksSupport extends BaseDebtorsTasksSupport
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}