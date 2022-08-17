<?php

Yii::import('application.models._base.BaseTypeImport');

class TypeImport extends BaseTypeImport
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}