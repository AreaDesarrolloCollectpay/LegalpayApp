<?php

Yii::import('application.models._base.BaseTypeDocuments');

class TypeDocuments extends BaseTypeDocuments
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}