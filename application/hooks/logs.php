<?php

class logs_hook {

    function index() {

        $ci = & get_instance();

        $user = $ci->dx_auth->get_user_id()." - ".$ci->dx_auth->get_username()." - ".$ci->dx_auth->get_name()." - ".$ci->dx_auth->get_role_id()." - ".$ci->dx_auth->get_role_name();

        $dbs = array();

        foreach (get_object_vars($ci) as $CI_object)
        {
            if (is_object($CI_object) && is_subclass_of(get_class($CI_object), 'CI_DB') )
            {
                $dbs[] = $CI_object;
            }
        }

        $output  = "";

        $querys = "";

        foreach ($dbs as $db)
        {
            if (count($db->queries) == 0)
            {
                $output .= "no_queries\n";
            }
            else
            {
                foreach ($db->queries as $key => $val)
                {
                    if($this->filter_query($val)) {

                        $time = number_format($db->query_times[$key], 4);

                        $querys .= "\n--------------\n".$time."\n".$val."\n--------------\n";
                    }
                }
            }

            if($querys != '') {

                $output .= 'database: '.$db->database.' / queries : '.count($db->queries).'';

                $output .= $querys;
            }
        }

        if($output != '') {

            $handle = fopen(APPPATH.'logs/db/db-log-'.date('Y-m-d').'.log', "a+");

            fwrite($handle, "//-----------------------------//\r\n".date('j.m.Y G:i:s')."\r\n--------------\r\n".$user."\r\n");

            fwrite($handle, $output."//-----------------------------//\r\n");

            fclose($handle);
        }
    }

    function filter_query($query) {

        $allow_query = array('INSERT', 'UPDATE', 'DELETE');

        $disallow_query = array('bd_sessions', 'last_ip');

        foreach($disallow_query as $q) {

            if(strpos($query, $q) !== false) {

                return false;

            } else {

                foreach($allow_query as $i) {

                    if(strpos($query, $i) !== false) return true;
                }
            }
        }

        return false;
    }
}

?>