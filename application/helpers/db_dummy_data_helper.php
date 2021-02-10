<?php
if ( ! function_exists('add_dummy_data_v_0_3')){
    function add_dummy_data_v_0_3(){        
        $table_names = [
            "shift_type",
            "privilege",
            "bid_schedule_state",
            "bid_schedule",
            "subcategory",
            "subcategory_bid_order",
            "users",
            "subcategory_user",
            "time_slot",
            "work_day_override",
            "vacation_bid_request",
            "accepted_vacation_bid",
            "shift_bid",
            "overtime_request",
            "overtime_accepted"
        ];
        
        $db_version = "v_0_3";
        foreach($table_names as $tn)
            add_data($tn, $db_version);
        
    }    
}

if ( ! function_exists('add_dummy_data_v_0_4')){
    function add_dummy_data_v_0_4(){  
        $table_names = [            
            "privilege",
            "bid_schedule_state",
            "bid_schedule",
            "shift_type",
            "subcategory",
            "subcategory_bid_order",
            "users",
            "user_turn_notice",
            "subcategory_user",
            "time_slot",
            "work_day_override",
            "vacation_bid_request",
            "accepted_vacation_bid",
            "overtime_request",
            "overtime_accepted",
        ];
        
        $db_version = "v_0_4";
        foreach($table_names as $tn)            
            add_data($tn, $db_version);
    }    
}

if ( ! function_exists('add_dummy_data_v_0_5')){
    function add_dummy_data_v_0_5(){  
        $table_names = [            
            "day_of_week",
            "privilege",
            "bid_schedule_state",
            "bid_schedule",
            "schedule_vehicle",
            "shift_type",
            "subcategory",
            "subcategory_bid_order",
            "users",
            "user_turn_notice",
            "subcategory_user",
            "time_slot",
            "day_off",
            "work_day_override",
            "p_sheet",
            "ps_time_slot",
            "day_off_request",
            "overtime_notice",
            "overtime_request"
        ];
        
        $db_version = "v_0_5";
        foreach($table_names as $tn)            
            add_data($tn, $db_version);
    }    
}

//returns a 2-d array representation of the .csv file with name
// 'file_name' located in the assets/dummy_data/[database version] folder.
// The db version should be a string value, such as "v_0_4" or "v_0_11".
if( ! function_exists('file_contents_to_csv_arr')){
    {
        function file_contents_to_csv_arr($file_name, $db_version){
            echo "<!DOCTYPE html><html><body>";
            
            //$RELATIVE_PATH = "assets/dummy_data/v_0_3/";
            $RELATIVE_PATH = "assets/dummy_data/$db_version/";
            $url = base_url() . $RELATIVE_PATH . $file_name;
            
            $file_content = file_get_contents($url);
                
            $csv = explode("\n", $file_content);
            
            $csv_content = print_r($csv, TRUE);
            
            
            //the 2d array
            $arr = [];
            
            //convert the content of the file into a 2D array.
            $x = 0;  
            foreach($csv as $csvline){                
                $cells = explode(',', $csvline); 
                if(!$csvline)
                    break; //EOF
                
                $arr[$x] = [];
                
                $y = 0;
                foreach($cells as $data){
                    $data = str_replace(["\n", "\r"], "", $data);
                    //TODO: trim \n?
                    $arr[$x][$y] = $data;
                    echo "[x:$x|y:$y] = " . $arr[$x][$y] . "<br>";
                    $y++;
                }
                $x++;
            }
            
            echo '</body></html>';
            
            return $arr;
        }
    }
}

//Adds the data from a CSV file (located in assets/dummy/[version number] rel path)
//to the database. The name of the file must be: [name of table]_v_0_[database version].csv
//the name of the csv file (excluding version suffix) must be the same name as the database table name
//Here's an example of the path, and file name of a csv file, and the name of the table in the database:
// Path: assets/dummy_data_v_0_3/bid_schedule_state_v_0_3.csv
// File name: bid_schedule_state_v_0_3
// Database table name: bid_schedule_state
// NOTE: If an attribute's value is empty (that is, 
// an attribute's value cell was left empty) it will be interpreted as
// NULL. Also, if a string is written into an attribute's value cell 
// as 'NULL', without quotes, the value will be interpreted as NULL 
// instead of a string that says NULL.
if ( !function_exists('add_data')){    
    function add_data($table_name, $db_version){
        $ci=& get_instance();
        $ci->load->database();        
        $an = []; //attribute names
        $FILE_NAME = $table_name . "_" . $db_version;
        $csv_arr = file_contents_to_csv_arr($FILE_NAME, $db_version);//2d representation of spreadsheet
        $rows = count($csv_arr);
        $cols = count($csv_arr[0]);    
        
        //add all the attributes names from the first line
        //of the spreadsheet to the 'an' array
        foreach($csv_arr[0] as $att_name)
            array_push($an, $att_name); 
        
        $data = []; 
        
        //traverse 2d array, inserting data to the database
        //one row at a time.
        for($i=1; $i<$rows; $i++){
            
            //generate the row
            for($j=0; $j<$cols; $j++){
                $att_name = $an[$j];                
                $data[$att_name] = trim($csv_arr[$i][$j], " ");   
                if($data[$att_name] === '' || $data[$att_name] == 'NULL'){
                    echo "<b>detected an empty cell or cell that has the text 'NULL' in it, interpreting it as NULL</b><br>";
                    $data[$att_name] = NULL;
                }            
            }
            
            //add the row
            $ci->db->insert($table_name, $data);
        }
        
        return; 
    }
}




