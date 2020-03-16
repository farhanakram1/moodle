<?php
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot.'/enrol/
stripepayment/lib.php');

class registration_fees_observer {

    public static function init($plugin) {
       
    }


    public static function user_signup(\core\event\user_created $event) {
        global $DB, $CFG;
        $user = $DB->get_record('user', array('id' => $event->objectid));
        self::update_moodle_user($user);
        return true;
    }

    public static function user_loggedin(\core\event\user_loggedin $event) {
        global $DB, $CFG;
        $user = $DB->get_record('user', array('id' => $event->objectid));
        self::update_moodle_user($user);
        return true;
    }

    public static function get_wp_data($wpurl,$m_email) { 
        if ( $wpurl != '' && $m_email !='') {
            $url = $wpurl.'/wp-json/wp/v2/users/byemail';
            $fields = array(  "email" => $m_email);
            $fields_string = '';
            foreach($fields as $key=>$value) { 
                if ( is_array($value) ) {
                        foreach($value as $k=>$v) { 
                            $fields_string .= $key.'['.$k.']='.$v.'&';      
                        }
                } else {
                    $fields_string .= $key.'='.$value.'&';      
                }
            }
            $fields_string = substr($fields_string, 0,strlen($fields_string)-1);
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            $output = curl_exec($ch); 
            if(curl_error($ch)){echo 'error:' . curl_error($ch);}
            $response = json_decode($output,true);
            $wpuser = $response['data'];
            return $wpuser;
        } else {
            return false;
        }
    }

    public static function update_moodle_user($user) {
        global $DB, $CFG;
        $plugin = get_config('enrol_wordpress');
        $m_user_id = $user->id;
        $m_email = $user->email;
        $wpuser = false;
        $fields = self::init($plugin);
        $user_data_fields = $fields['user_data_fields'];
        $custom_fields = $fields['custom_fields'];
        if ( $plugin->wordpress_url != '' && $m_user_id > 0 && $m_email != '' ) { 
            $wpuser = self::get_wp_data($plugin->wordpress_url,$m_email);
            if ($wpuser){
                // start update user fields process
                $updateuser['id'] = $m_user_id;
                if ( !empty($user_data_fields) && $m_user_id > 0 ) {
                    foreach ($user_data_fields as $mfield => $wpfield) {
                        if ($mfield=='firstname' || $mfield=='lastname' || $mfield=='description') {
                            $updateuser[$mfield] = $wpuser['meta'][$wpfield][0];
                        }  else if ($mfield=='password' || $mfield=='username' || $mfield=='email') {
                            
                        } else {
                            $updateuser['alternatename'] = $wpuser['display_name'];    
                        }
                    }
                    user_update_user($updateuser, false);
                }
                // END

                // start update user custom fields process
                if ( !empty($custom_fields) && $m_user_id > 0 ) {
                    $customfieldname = $DB->get_records('user_info_field', null, '', 'id as fieldid,shortname, name');
                    foreach ($custom_fields as $key => $settings_custom_fields) {
                        $settings_custom_field = '';
                        foreach ($customfieldname as $key2 => $mood_db_custom_filed) {
                            $settings_custom_field  = str_replace("_", "", $settings_custom_fields);
                            if ($mood_db_custom_filed->shortname == $settings_custom_field);
                            $custom_fields['fieldid'] = $mood_db_custom_filed->fieldid;
                        }
                    }

                    $query = " UPDATE {user_info_data} SET data = CASE ";
                    foreach ($customfieldname as $key => $mcustomfield) {
                        $wpfield = $custom_fields[$mcustomfield->shortname];
                        if ( $mcustomfield->fieldid > 0 ) {
                            if ( $mcustomfield->shortname=='displayname' ) {
                                $query .= ' WHEN fieldid = '.$mcustomfield->fieldid ." THEN '".$wpuser[$wpfield]."'";    
                            } else {
                                if ( isset($wpuser['meta'][$wpfield]) )
                                $query .= ' WHEN fieldid = '.$mcustomfield->fieldid ." THEN '".$wpuser['meta'][$wpfield][0]."'";    
                            }
                        }
                    }
                    $query .= ' ELSE data END WHERE userid = '.$m_user_id;
                    $DB->execute($query);
                }
            }
        }        
        return true;
    }


    
    // END develpers use only
}
