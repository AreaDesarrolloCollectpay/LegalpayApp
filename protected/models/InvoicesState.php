<?php

Yii::import('application.models._base.BaseInvoicesState');

class InvoicesState extends BaseInvoicesState
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}