<?php

Yii::import('application.models._base.BaseTypeContract');

class TypeContract extends BaseTypeContract
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}