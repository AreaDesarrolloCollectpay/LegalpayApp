<?php

Yii::import('application.models._base.BaseUsersState');

class UsersState extends BaseUsersState
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}