<?php

class MapsCommand extends CConsoleCommand{
    
    public function run(){
        
        $command = Yii::app()->db->createCommand()
                ->select("td.id, td.address, vl.location")
                ->from("tbl_debtors td")
                ->join("view_location vl","td.idCity = vl.idCity")
                ->where("td.address_lat IS NULL OR td.address_lng IS NULL")
                ->limit("50")
                ->queryAll();
        
        foreach($command as $data){
            @Controller::getLocationDebtorCron($data);
        }
    }
    
}

