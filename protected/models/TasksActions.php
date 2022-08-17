<?php

Yii::import('application.models._base.BaseTasksActions');

class TasksActions extends BaseTasksActions
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}