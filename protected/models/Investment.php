<?php

Yii::import('application.models._base.BaseInvestment');

class Investment extends BaseInvestment
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}