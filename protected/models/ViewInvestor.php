<?php

Yii::import('application.models._base.BaseViewInvestor');

class ViewInvestor extends BaseViewInvestor
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}