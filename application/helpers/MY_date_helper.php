<?php
if(!function_exists('td_date_time_picker_default_to_mysql_date_time')){
    
    //Using tempus dominus's (td for short) default date time picker, convert its default
    //format into its valid mysql DATETIME format
    function td_date_time_picker_default_to_mysql_date_time($date_time){
        // add EST because if not then the time is actually interpreted by php's
        // date_create_from_format as UTC if a timezone is not specified.
        $date_time = $date_time . " EST";
        
        // The format that tempus dominus's default datetime picker sends
        // datetime data. 
        $form_format = "m/d/Y h:i A T"; //based off php format documentation
        $mysql_format = "Y-m-d H:i:s"; //based off php format documentation
        
        $php_date_time = date_create_from_format($form_format, $date_time);
        $mysql_date_time = date_format($php_date_time, $mysql_format);
        
        return $mysql_date_time;
    }
}

//td stands for tempus dominus, LT is the format that was used to set up
//the input box.
if(!function_exists('td_time_picker_LT_to_mysql_time')){
    // Converts a time-only formated tempus dominus input value to a mysql formated TIME type.
    // Here's an example snippet from their introduction tutorial on time-only input boxes:
    //   https://tempusdominus.github.io/bootstrap-4/Usage/#time-only
    // The "LT" in the method signature is for the abbreviation "LT", a time format. LT is the format 
    // that we chose for for certain input boxes that make use of tempus dominus. Assigning the format 
    // of "LT" to a tempus dominus input box makes the input box show the time ONLY rather
    // than the usual date-time
    // LT, according to the moment.js documentation, is the format for "Time (without seconds)" with 
    // leading zeros for the hours such as 09:54 PM
    function td_time_picker_LT_to_mysql_time($time){
        // echo "time argument is: $time <br>";//test
        // add EST because if not then the time is actually interpreted by php's
        // date_create_from_format as UTC if a timezone is not specified.
        $time = $time . " EST";
        
        // NOTE:
        // As of tempus dominus 5.0.1, it's suppose to add leading 0 to the hours
        // of a datetimepicker whose format was set to "LT" but it doesn't add it! 
        // This seems like a bug. If you read the moment.js documentation on format,
        // the example that they used for the format "LT" has a leading zero in front of the hour
        // which is contradictory to what tempus dominus's "LT" format does. Because of this
        // we will consider the hours in an "LT" format datetimepicker to be missing leading zeros in 
        // front of the hour
        
        //example data from a form: 9:34 PM EST
        $form_format = "g:i A T"; //based off php format documentation
        
        //example format: 16:23:00 for 4:23 PM
        $mysql_format = "H:i:s"; //based off php format documentation
        
        $php_date_time = date_create_from_format($form_format, $time);
        $mysql_date_time = date_format($php_date_time, $mysql_format);
        
        return $mysql_date_time;
    }
}



