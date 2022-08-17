<?php

Yii::import('application.models._base.BaseUsersDocuments');

class UsersDocuments extends BaseUsersDocuments
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}