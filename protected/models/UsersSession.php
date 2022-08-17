<?php

Yii::import('application.models._base.BaseUsersSession');

class UsersSession extends BaseUsersSession
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}