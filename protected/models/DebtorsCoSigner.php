<?php

Yii::import('application.models._base.BaseDebtorsCoSigner');

class DebtorsCoSigner extends BaseDebtorsCoSigner
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}