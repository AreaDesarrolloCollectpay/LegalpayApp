<?php

Class ManagementCommand extends CConsoleCommand{
    
    public function run(){ 
        
        $command = Yii::app()->db->createCommand()
                ->select("SELECT td.id, td.name, tdt.date ,td.idCustomers, tdt.dateCreated, COUNT(idCustomers) AS cant FROM tbl_debtors_tasks tdt
                JOIN tbl_debtors_obligations tdo ON tdt.idDebtor = tdo.`id`
                JOIN tbl_debtors td ON td.id = tdo.idDebtor
                WHERE TIMESTAMPDIFF(DAY, tdt.date, CURDATE()) <= 20 AND DATE_FORMAT(tdt.dateCreated,'%Y-%m-%d') = CURDATE()
                GROUP BY td.idCustomers")
                ->queryAll();
        
        foreach($command as $data){
            $controller = new CController('context');
            $view = "mail-cron-management.php";
            $message = $controller->renderInternal(__DIR__.'/../views/email/'.$view.'.php', array('data' => $data), true);
            $email = "";
            $subject = "Nuevas Gestiones";
            @Controller::SendGridMail($email, $subject, $message);
        }
    
    }
}

