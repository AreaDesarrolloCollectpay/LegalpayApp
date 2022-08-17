<?php

Yii::import('application.models._base.BaseUsersImport');

class UsersImport extends BaseUsersImport
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}