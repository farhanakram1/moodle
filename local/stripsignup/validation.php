<?php
require('../../config.php');
require_once($CFG->dirroot . '/user/editlib.php');
require_once($CFG->libdir . '/authlib.php');
require_once('lib.php');
global $DB,$USER;

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
if($_REQUEST['func'] == 'updateCourseStatus'){
    $course_status = new \stdClass();
    $course_status->course_id = $_REQUEST['course_id'];
    $course_status->student_id = $USER->id;
    $course_status->status = 1;
    $data = $DB->get_record_sql("SELECT * FROM {course_status} WHERE course_id=? and student_id=?  LIMIT 1", array( $_REQUEST['course_id'],$USER->id));
    if(empty($data)){
        $DB->insert_record('course_status', $course_status);
    }else{
        $course_status->id = $data->id;
        $DB->update_record('course_status', $course_status);
    }
    echo 'ok';
}

?>