<?php

Yii::import('application.models._base.BaseCampaignsCoordinators');

class CampaignsCoordinators extends BaseCampaignsCoordinators
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}