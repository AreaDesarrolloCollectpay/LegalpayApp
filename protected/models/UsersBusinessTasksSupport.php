<?php

Yii::import('application.models._base.BaseUsersBusinessTasksSupport');

class UsersBusinessTasksSupport extends BaseUsersBusinessTasksSupport
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}