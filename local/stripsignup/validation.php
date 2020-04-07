<?php
require('../../config.php');
require_once($CFG->dirroot . '/user/editlib.php');
require_once($CFG->libdir . '/authlib.php');
require_once('lib.php');
global $DB;

if($_REQUEST['func'] == 'chkUName'){
   $user_username = $DB->get_record('user', array('username' =>  $_REQUEST['uname']));
   if(empty($user_username)){
       echo 'ok';
   }else{
       echo 'notok';
   }
}

if($_REQUEST['func'] == 'chkEmail'){
   $user_email = $DB->get_record('user', array('email' =>  $_REQUEST['email']));
   if(empty($user_email)){
       echo 'ok';
   }else{
       echo 'notok';
   }
}

if($_REQUEST['func'] == 'chkDiscount'){
    $email = $_REQUEST['email'];
    $discount_code = $_REQUEST['discount_code'];
    
    $data = $DB->get_record_sql("SELECT * FROM {local_discounts} WHERE discount_code=? LIMIT 1", array($discount_code));
    if(empty($data)){
        echo 'notfound';
    }else{
        $emails = $data->emailto;
        $emails = explode(',', $emails);
        if(in_array($email, $emails)){
            $amount = get_config('local_stripsignup', 'cost');
            $percentage = intval($data->percentage);
            if(round($percentage) == 100){
                $amount = 0;
            }else{
                $percentage = $percentage/100;
                $discount_amout = $amount*$percentage;
                $amount = $amount-$discount_amout;
            }
            echo 'USD $'.$amount;
        }else{
            echo 'notok';
        }
    }
}

?>