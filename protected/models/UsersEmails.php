<?php

Yii::import('application.models._base.BaseUsersEmails');

class UsersEmails extends BaseUsersEmails
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}