<?php
		require_once("db_connect.php");
		require_once("config.php");
		global $dbc;


		////////testing joins
function testing_joins(){
  global $dbc;
  // $sql_inner_join = "SELECT blacklisted_numbers.blacklist_phone as bp, users.fname as fn, users.lname as ln, blacklisted_numbers.blacklist_id as bi 
  //         FROM users
  //         INNER JOIN blacklisted_numbers ON blacklisted_numbers.blacklisted_user_id = users.unique_id";

  // $sql_left_join1 = "SELECT blacklisted_numbers.blacklist_phone as bp, users.fname as fn, users.lname as ln, blacklisted_numbers.blacklist_id as bi 
  //         FROM blacklisted_numbers
  //         LEFT JOIN users ON blacklisted_numbers.blacklisted_user_id = users.unique_id";

   // $sql_left_join2 = "SELECT blacklisted_numbers.blacklist_phone as bp, users.fname as fn, users.lname as ln, blacklisted_numbers.blacklist_id as bi 
   //        FROM users
   //        LEFT JOIN blacklisted_numbers ON blacklisted_numbers.blacklisted_user_id = users.unique_id";

  
     // $sql_right_join1 = "SELECT blacklisted_numbers.blacklist_phone as bp, users.fname as fn, users.lname as ln, blacklisted_numbers.blacklist_id as bi 
     //      FROM users
     //      RIGHT JOIN blacklisted_numbers ON blacklisted_numbers.blacklisted_user_id = users.unique_id";


  // $sql_right_join2 = "SELECT blacklisted_numbers.blacklist_phone as bp, users.fname as fn, users.lname as ln, blacklisted_numbers.blacklist_id as bi 
  //         FROM blacklisted_numbers
  //         RIGHT JOIN users ON blacklisted_numbers.blacklisted_user_id = users.unique_id";


  $sql_full_join1 = "SELECT blacklisted_numbers.blacklist_phone as bp, users.fname as fn, users.lname as ln, blacklisted_numbers.blacklist_id as bi 
          FROM blacklisted_numbers
          FULL  JOIN users ON blacklisted_numbers.blacklisted_user_id = users.unique_id";



  $qry = mysqli_query($dbc,$sql_full_join1);
  
  while($row = mysqli_fetch_array($qry)){
         echo $row['bp'].'---'.$row['fn'].'---'.$row['ln'].'-----'.$row['bi'].'<br>';
  }
  // echo json_encode($disp);
  // var_dump(mysqli_fetch_array($qry));

}



		function format_date_two($style,$date){
	        $date = secure_database($date);
	        $new_date_format = date($style, strtotime($date));
	        return $new_date_format;
		}

		function format_date($date){
	        $date = secure_database($date);
	        $new_date_format = date('F-d-Y', strtotime($date));

	        return $new_date_format;
 		 }

		function getDateForSpecificDayBetweenDates($startDate,$endDate,$day_number){
                  $endDate = strtotime($endDate);
                  $days=array('1'=>'Monday','2' => 'Tuesday','3' => 'Wednesday','4'=>'Thursday','5' =>'Friday','6' => 'Saturday','7'=>'Sunday');
                  for($i = strtotime($days[$day_number], strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i))
                  // $date_array[]=date('F-d-Y',$i);
                  $date_array[]=date('Y-m-d',$i);

                  return $date_array;
 		 }

		  function email_function($email, $subject, $content){
			  $headers = "From: ChurchWorldv1\r\n";
			  @$mail = mail($email, $subject, $content, $headers);
			  return $mail;
		  }


function files_upload($file_name, $size, $tmpName,$type){
    // global $dbc;
    $upload_path33 = "church_files/".$file_name;
    $file_extensions = ['pdf','docx','doc'];//pdf,PDF
    $file_extension = substr($file_name,strpos($file_name, '.') + 1);
        //$file_extension = strtolower(end(explode('.', $file_name)));
    
    if(!in_array($file_extension, $file_extensions)){
      return json_encode(["status"=>"0","msg"=>"incorrect_format"]);
    }else{
        // $upload_path33 = 'ebooks/'.$file_name;
        //2Mb
        if($size > 5000000){
          return json_encode(["status"=>"130","msg"=>"too_big"]);
        }else{
          $upload = move_uploaded_file($tmpName, $upload_path33);
          if($upload == true){
              return json_encode(["status"=>"111","msg"=>$upload_path33]);
          }else{
              return json_encode(["status"=>"104","msg"=>"failurerr   ".$upload_path33]);  
          }
        }

    }


}


//sms functions starts here
   function send_sms($destination_no, $message, $developer_id, $cloud_sms_password)
    {

        // The cloudsms api only accepts numbers in the format 234xxxxxxxxxx (without the + sign.)
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://developers.cloudsms.com.ng/api.php?userid=" . $developer_id . "&password=" . $cloud_sms_password . "&type=0&destination=". $destination_no."&sender=CLOUDSMS&message=$message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return $response;
    }

/////////////sms functions ends here



function get_one_row_from_one_table_with_sql_param($sql_array,$table,$conditions,$order_option){
         global $dbc;
         $array_ppt = "";
         $conditions_param = "";
        if(count($sql_array) == 0){
            $array_ppt .= "*";
        }else{
            for($j=0; $j < count($sql_array);$j++){
            if($j == (count($sql_array) - 1) ){
                $array_ppt .= $sql_array[$j];
            }else{
                $array_ppt .= $sql_array[$j].',';
            }
           }
        }

        //conditions
        if(count($conditions) == 0){
            $conditions_param .= "";
        }else{
            $k =1;
            $conditions_param .= " WHERE ";
            foreach($conditions as $key=>$value){
            if($k == (count($conditions)) ){
                $conditions_param .= "`".$key."`='".$value."'";
            }else{
                $conditions_param .= "`".$key."`='".$value."' AND ";
            }
            $k++;
           }
        }
      
        $sql = "SELECT $array_ppt FROM `$table`  $conditions_param ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){  
             $row = mysqli_fetch_array($query);               
             return $row;
          }
          else{
             return null;
          }
}


function get_rows_from_one_table_with_sql_param($sql_array,$table,$conditions,$order_option){
         global $dbc;
         $array_ppt = "";
         $conditions_param = "";
        if(count($sql_array) == 0){
            $array_ppt .= "*";
        }else{
            for($j=0; $j < count($sql_array);$j++){
            if($j == (count($sql_array) - 1) ){
                $array_ppt .= $sql_array[$j];
            }else{
                $array_ppt .= $sql_array[$j].',';
            }
           }
        }

        //conditions
        if(count($conditions) == 0){
            $conditions_param .= "";
        }else{
            $k =1;
            $conditions_param .= " WHERE ";
            foreach($conditions as $key=>$value){
            if($k == (count($conditions)) ){
                $conditions_param .= "`".$key."`='".$value."'";
            }else{
                $conditions_param .= "`".$key."`='".$value."' AND ";
            }
            $k++;
           }
        }
      
        $sql = "SELECT $array_ppt FROM `$table`  $conditions_param ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
           while($row = mysqli_fetch_array($query)){
             $row_display[] = $row;
           }
                          
            return $row_display;
          }
          else{
             return null;
          }
}



function check_record_by_one_param($table,$param,$value){
    global $dbc;
    $sql = "SELECT id FROM `$table` WHERE `$param`='$value'";
    $query = mysqli_query($dbc, $sql);
    $count = mysqli_num_rows($query);
    if($count > 0){
      return true; ///exists
    }else{
      return false; //does not exist
    }
    
} 

function check_record_by_two_params($table,$param,$value,$param2,$value2){
    global $dbc;
    $sql = "SELECT id FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2'";
    $query = mysqli_query($dbc, $sql);
    $count = mysqli_num_rows($query);
    if($count > 0){
      return true; ///exists
    }else{
      return false; //does not exist
    }
    
}   



function secure_database($value){
    global $dbc;
    $new_value = mysqli_real_escape_string($dbc,$value);
    return $new_value;
}

function get_row_count_no_param($table){
    global $dbc;
    $sql = "SELECT id FROM `$table`";
    $qry = mysqli_query($dbc,$sql);
    $count = mysqli_num_rows($qry);
    if($count > 0){
        return $count;
    }else{
        return 0;
    }
}

function get_row_count_one_param($table,$param,$value){
    global $dbc;
    $sql = "SELECT id FROM `$table` WHERE `$param`='$value'";
    $qry = mysqli_query($dbc,$sql);
    $count = mysqli_num_rows($qry);
    if($count > 0){
        return $count;
    }else{
        return 0;
    }
}


function unique_id_generator($data){
    $data = secure_database($data);
    $newid = md5(uniqid().time().rand(11111,99999).rand(11111,99999).$data);
    return $newid;
}


function get_rows_from_one_table($table,$order_option){
         global $dbc;
       
        $sql = "SELECT * FROM `$table` ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
           while($row = mysqli_fetch_array($query)){
             $row_display[] = $row;
           }
                          
            return $row_display;
          }
          else{
             return null;
          }
}

function get_rows_from_one_table_by_id($table,$param,$value,$order_option){
         global $dbc;
        $table = secure_database($table);
       
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             while($row = mysqli_fetch_array($query)){
                $display[] = $row;
             }              
             return $display;
          }
          else{
             return null;
          }
}


function get_rows_from_one_table_by_two_params($table,$param,$value,$param2,$value2,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             while($row = mysqli_fetch_array($query)){
                $display[] = $row;
             }              
             return $display;
          }
          else{
             return null;
          }
}


function get_rows_from_one_table_by_three_params($table,$param,$value,$param2,$value2,$param3,$value3,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' AND `$param3`='$value3' ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             while($row = mysqli_fetch_array($query)){
                $display[] = $row;
             }              
             return $display;
          }
          else{
             return null;
          }
}


function get_one_row_from_one_table_by_id($table,$param,$value,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             $row = mysqli_fetch_array($query);              
             return $row;
          }
          else{
             return null;
        }
    }

function get_one_row_from_one_table_by_two_params($table,$param,$value,$param2,$value2,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             $row = mysqli_fetch_array($query);              
             return $row;
          }
          else{
             return null;
        }
    }


    function get_one_row_from_one_table_by_three_params($table,$param,$value,$param2,$value2,$param3,$value3,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' AND `$param3`='$value3' ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             $row = mysqli_fetch_array($query);              
             return $row;
          }
          else{
             return null;
        }
    }


function delete_old_image($unique_id){
    global $dbc;
     $sql = "SELECT * FROM `other_events_images` WHERE `id`='$unique_id'";
     $query = mysqli_query($dbc, $sql);
     $row = mysqli_fetch_array($query);
     $img_url = $row['image_path'];
     return unlink($img_url);
     

}

function  delete_record($table,$param,$value){
    global $dbc;
    $sql = "DELETE FROM `$table` WHERE `$param`='$value'";
    $query = mysqli_query($dbc,$sql);
    if($query){
      return true;
    }else{
      return false;
    }
}


function get_visible_rows_from_events_with_pagination($table,$offset,$no_per_page){
         global $dbc;
        $table = secure_database($table);
        $offset = secure_database($offset);
        $no_per_page = secure_database($no_per_page);
        $sql = "SELECT * FROM `events_tbl` WHERE visibility = 1 ORDER BY date_added DESC LIMIT $offset,$no_per_page ";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
            while($row = mysqli_fetch_array($query)){
                $row_display[] = $row;
                }
            return $row_display;
          }
          else{
             return null;
          }
}

function get_visible_rows_from_events_with_limit($table,$limit){
         global $dbc;
        $table = secure_database($table);
       
        $sql = "SELECT * FROM `events_tbl` WHERE visibility = 1 ORDER BY date_added DESC LIMIT $limit";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
            while($row = mysqli_fetch_array($query)){
                $row_display[] = $row;
                }
            return $row_display;
          }
          else{
             return null;
          }
}


function get_total_pages($table,$no_per_page){
    global $dbc;
    $no_per_page = secure_database($no_per_page);
    $total_pages_sql = "SELECT COUNT(id) FROM  `$table` ";
    $result = mysqli_query($dbc,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_per_page);
    return $total_pages;
}



function get_rows_from_one_table_with_pagination($table,$offset,$no_per_page){
         global $dbc;
        $table = secure_database($table);
        $offset = secure_database($offset);
        $no_per_page = secure_database($no_per_page);
        $sql = "SELECT * FROM `$table` ORDER BY date_added DESC LIMIT $offset,$no_per_page ";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
            while($row = mysqli_fetch_array($query)){
                $row_display[] = $row;
                }
            return $row_display;
          }
          else{
             return null;
          }
}


function update_by_one_param($table,$param,$value,$condition,$condition_value){
  global $dbc;
  $sql = "UPDATE `$table` SET `$param`='$value' WHERE `$condition`='$condition_value'";
  $qry = mysqli_query($dbc,$sql);
  if($qry){
     return true;
  }else{
      return false;
  }
}


?>