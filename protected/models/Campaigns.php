<?php

Yii::import('application.models._base.BaseCampaigns');

class Campaigns extends BaseCampaigns
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}