<?php
$table = "";
$app_name = 'CHURCHWORLDV1';
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


function confirm_acct_entry_reversal($uid2,$entry_id){
      global $dbc;

          $check_exist = check_record_by_one_param('accounting_entries','entry_id',$entry_id);

          if($check_exist == false){
              //exists
            return json_encode(array( "status"=>102, "msg"=>"This entry does not exist or has been reversed" ));

          }else{     
                     $get_entry_details = get_one_row_from_one_table_by_id('accounting_entries','entry_id',$entry_id,'date_entered');
                     $item_id = $get_entry_details['item_id'];
                     $description = $get_entry_details['item_description'];
                     $transaction_type = $get_entry_details['transaction_type'];
                     $amount = $get_entry_details['amount'];
                     $uid = $get_entry_details['entered_by'];
                     $date_of_transaction = $get_entry_details['date_of_transaction'];
                     //return $date_of_transaction;
                     $sqlins = "INSERT INTO `deleted_accounting_entries` SET
                            `entry_id` = '$entry_id',
                            `item_id` = '$item_id',
                            `item_description` = '$description',
                            `transaction_type` = '$transaction_type',
                            `amount` = '$amount',
                            `entered_by` = '$uid',
                            `date_of_transaction`= '$date_of_transaction',
                            `date_entered` = now()
                            ";
                    $queryins = mysqli_query($dbc, $sqlins) or die(mysqli_error($dbc));


                    $sql = "DELETE FROM `accounting_entries` WHERE `entry_id` = '$entry_id'";
                    $qryy = mysqli_query($dbc,$sql);
                    if($qryy){
                        return json_encode(array( "status"=>111, "msg"=>"success" ));
                    }else{
                        return json_encode(array( "status"=>109, "msg"=>"This entry does not exist or has been reversed" ));
                    }

          }



}


function in_array_all($needles, $haystack) {
   return empty(array_diff($needles, $haystack));
}


function get_accounting_entries_within_a_range($to_date,$from_date){
    global $dbc;
    $sql = "SELECT * FROM `accounting_entries` WHERE `date_of_transaction` >= '$from_date' AND `date_of_transaction` <= '$to_date'";
    $qryy = mysqli_query($dbc,$sql);
    $count = mysqli_num_rows($qryy);
    if($count <= 0){
                return json_encode(array( "status"=>109, "msg"=>"No record found" ));
    }else{
           while($row = mysqli_fetch_array($qryy)){
                  $display[] = $row;
           }

           return json_encode(array( "status"=>111, "msg"=>$display ));

    }
}


function add_users($uid,$first_name,$last_name,$email,$phone,$password,$role){
  global $dbc;

   $check_exist = check_record_by_one_param('admin_users','phone',$phone);

   if($check_exist){
                return json_encode(array( "status"=>109, "msg"=>"This User exists" ));
         }

         else{

            if( $first_name == "" || $last_name == ""  || $email == ""  || $phone == "" 
            || $password == "" || $role == ""  ){
                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));
                }
              else{
                $unique_id = unique_id_generator($first_name.$phone);
                $enc_password = md5($password);
                $sql = "INSERT INTO `admin_users` SET
                `unique_id` = '$unique_id',
                `fname` = '$first_name',
                `lname` = '$last_name',
                `email` = '$email',
                `phone` = '$phone',
                `password` = '$enc_password',
                `added_by` = '$uid',
                `role` = '$role',
                `date_created` = now()
                ";
                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        
              if($query){
          
                 return json_encode(array( "status"=>111, "msg"=>"success"));

                }else{

                 return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                  }
                }
         }
}




function edit_users($user_id,$first_name,$last_name,$email,$phone,$password,$role){
  global $dbc;



            if( $first_name == "" || $last_name == ""  || $email == ""  || $phone == "" 
             || $role == "" || $user_id == ""  ){
                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));
                }
              else{

                if($password == ""){
                    $sql = "UPDATE `admin_users` SET
                    `fname` = '$first_name',
                    `lname` = '$last_name',
                    `email` = '$email',
                    `phone` = '$phone',
                    `role` = '$role' WHERE `unique_id`='$user_id'
                    ";
                }else {
                    $enc_password = md5($password);
                    $sql = "UPDATE `admin_users` SET
                    `fname` = '$first_name',
                    `lname` = '$last_name',
                    `email` = '$email',
                    `phone` = '$phone',
                    `password` = '$enc_password',
                    `role` = '$role' WHERE `unique_id`='$user_id'
                    ";
                }
              

                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        
              if($query){
          
                 return json_encode(array( "status"=>111, "msg"=>"success"));

                }else{

                 return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                  }
                }
         

}


function add_role_privileges($uid,$role_name,$read_write_access,$pages_access){
  global $dbc;
  $check_exist = check_record_by_one_param('role_privileges','role_name',$role_name);

   if($check_exist){
                return json_encode(array( "status"=>109, "msg"=>"This Role exists" ));
         }

    else{
            if( $role_name == "" || $read_write_access == ""  ){
                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));
                }
            if(count($pages_access) <= 0){
                  return json_encode(array( "status"=>101, "msg"=>"Please select atleast a page to access" ));
              }
              else{
                $role_id = unique_id_generator($role_name.rand(1111,5555));
                $enc_pages_access = json_encode($pages_access);



                $sql = "INSERT INTO `role_privileges` SET
                `role_id` = '$role_id',
                `role_name` = '$role_name',
                `read_write_access` = '$read_write_access',
                `pages_access` = '$enc_pages_access',
                `added_by` = '$uid',
                `date_added` = now()
                ";
                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        
              if($query){
          
                 return json_encode(array( "status"=>111, "msg"=>"success"));

                }else{

                 return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                  }
                }
         }
}

function edit_role_privileges($uid,$role_id,$pages_access){
  global $dbc;

            if( $role_id == ""){
                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found"));
                }
            if(count($pages_access) <= 0){
                  return json_encode(array( "status"=>101, "msg"=>"Please select atleast a page to access" ));
              }
              else{

                $enc_pages_access = json_encode($pages_access);
                $sql = "UPDATE `role_privileges` SET
                `pages_access` = '$enc_pages_access',
                `last_update_by` = '$uid',
                `date_added` = now() WHERE `role_id`='$role_id'
                ";
                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        
              if($query){
          
                 return json_encode(array( "status"=>111, "msg"=>"success"));

                }else{

                 return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                  }
                }
         
}


function log_each_acct_entry($uid,$transaction_type,$transaction_date,$item_id,$amount,$description){
  global $dbc;

  if($transaction_date == "" ||  $item_id == "" || $amount == "" || $transaction_type == ""){
                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));
  }else{
         $entry_id = unique_id_generator($item_id.$amount.rand(111111,999999));
          $sql = "INSERT INTO `accounting_entries` SET
                `entry_id` = '$entry_id',
                `item_id` = '$item_id',
                `item_description` = '$description',
                `transaction_type` = '$transaction_type',
                `amount` = '$amount',
                `entered_by` = '$uid',
                `date_of_transaction`= '$transaction_date',
                `date_entered` = now()
                ";
                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        
              if($query){
          
                 return json_encode(array( "status"=>111, "msg"=>"successful entry"));

                }else{

                return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                }

  }
}

// function log_expenses_entries(){
//   global $dbc;
// }

function update_visibility_for_acct_items($item_id,$visibility){
  global $dbc;
  $item_id = secure_database($item_id);
  $visibility = secure_database($visibility);

  if( $item_id == "" || $visibility == ""  ){
                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));
    }else{

              $sql = "UPDATE `accounting_items` SET
                `visibility`= '$visibility'   
                WHERE `item_id`='$item_id'
                ";
              $queryupd = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        
              if($queryupd){
          
                 return json_encode(array( "status"=>111, "msg"=>"success"));

                }else{

                return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                }

  }

}

function add_accounting_items($uid,$title,$type,$description){
  global $dbc;
  $uid = secure_database($uid);
  $title = secure_database($title);
  $type = secure_database($type);
  $description = secure_database($description);
  $unique_id = unique_id_generator($title.$type);
  
  $check_exist = check_record_by_one_param('accounting_items','item_name',$title);


        if($check_exist){
                return json_encode(array( "status"=>109, "msg"=>"This Title exists" ));
         }

         else{

            if( $title == "" || $type == ""  ){
                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));
                }
              else{
                $sql = "INSERT INTO `accounting_items` SET
                `item_id` = '$unique_id',
                `item_name` = '$title',
                `item_type` = '$type',
                `item_description` = '$description',
                `added_by` = '$uid',
                `visibility`= 1,
                `date_added` = now()
                ";
                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        
              if($query){
          
                 return json_encode(array( "status"=>111, "msg"=>"success"));

                }else{

                return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                }


                }

         }
}

function add_files($title,$visibility,$uid,$file_name,$type,$size,$tmp_name){
  global $dbc;
  $title = secure_database($title);
  $uid = secure_database($uid);
  $visibility = secure_database($visibility);


 //check if material exists
  $check_exist = check_record_by_one_param('files_tbl','title',$title);
  if($check_exist){
        return json_encode(["status"=>"103","msg"=>"This record exists already"]);
  }else{
        $files_upload = files_upload($file_name,$size,$tmp_name,$type);
        $decode_files = json_decode($files_upload,true);
        if($decode_files['status'] != 111){
        return json_encode(["status"=>"100","msg"=>$decode_files['msg']]);
        }else{
        $file_id = unique_id_generator($title.$file_name.time());
        $docs_path = $decode_files['msg'];
        $sql = "INSERT INTO `files_tbl` SET
        `file_id` = '$file_id',
        `title` = '$title',
        `file_path` = '$docs_path',
        `visibility` = '$visibility',
        `file_type` = '$type',
        `added_by`='$uid',
        `date_created`= now(),
        `last_updated`= now()
        ";
        $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        if($query){
        return json_encode(["status"=>"111","msg"=>"This File Name was succesfully added"]); 
        }

        }

    }

}

function log_or_update_service_attendance($uid,$elements_to_insert){
  global $dbc;
  $elements_marked = $elements_to_insert;
  $service_date = $elements_to_insert[0];
  $unit = $elements_to_insert[1];
  $service_id = unique_id_generator($uid.rand(100000000,99999999));
  $new_array = array();
  $all_members_in_unit_array = array();
  $final_removal = array();
  // steps
  //check if there is a row....
  
  ///if there is no row, just dump elements to insert into attendance list

  //if there is a row, get attendance list

  //loop through elements to insert, if present in attendance list, then, skip, else, add that userid to attendance list array
  ///create a fresh array to add list not found, then add finally to attendace list and then dump to db

  array_shift($elements_marked); //removes index 1
  array_shift($elements_marked); //removes index 2

 
  ///getallmembersinaunit
   $get_members_now =  get_members_belonging_to_a_unit($unit);
   $get_members_now_dec = json_decode($get_members_now,true);

  

   // print_r($get_members_now_dec['msg']['fname']);
   foreach ($get_members_now_dec['msg'] as $key => $mem) {
       $all_members_in_unit_array[] = $mem['unique_id'];
   }
    
    $elements_marked = array_values($elements_marked);
    $not_marked2 = array_diff($all_members_in_unit_array,$elements_marked);
    $not_marked = array_values($not_marked2);


    // print_r($all_members_array);
    // echo '<hr>';

    // print_r($elements_marked);
    // echo '<hr>';
    // print_r($not_marked);
    // echo '<hr>';


if(  count($elements_marked)  <= 0 ){
      return json_encode(["status"=>"103","msg"=>"no user was selected"]);
}
else{

      $check_service_attendance_for_a_date =  check_service_attendance_for_a_date($service_date);
      $check_dec = json_decode($check_service_attendance_for_a_date,true);
      if($check_dec['status'] != '111'){
      //preseent-- so update
        
        ///get members in a unit---laters

        //get attendancelist

        $service_params = [];
        $conditions = ['service_date'=>$service_date];
        $get_service_det = get_one_row_from_one_table_with_sql_param($service_params,'service_attendance_log',$conditions,'date_created');
        // var_dump($get_service_det);
        $attendance_list = $get_service_det['attendance_list'];
        $attendance_list_dec = json_decode($attendance_list,true);

        for( $i = 1; $i < count($elements_marked); $i++  ){
          if( !in_array( $elements_marked[$i], array_map('trim',$attendance_list_dec)) ){
              $attendance_list_dec[] = $elements_marked[$i];
            
           }
        }


    //if it's there before commot am
        //check if 'not_marked' is not  empyt
        if( count($not_marked) > 0){
          for( $kp = 0; $kp < count($not_marked); $kp++ ){
              if( in_array($not_marked[$kp], array_map('trim',$attendance_list_dec)) ){
                    $final_removal[] = $not_marked[$kp];
                   
              }
          }

           $newest_attendance_list = array_diff($attendance_list_dec,$final_removal);
           $newest_attendance_list = array_values($newest_attendance_list);
           $attendance_list_json = json_encode($newest_attendance_list);

        }else{
          ///all was selected
         $merged =  array_values( array_merge( array_map('trim',$attendance_list_dec) , $elements_marked ) );   
         $unique_list = array_unique($merged);
         $attendance_list_json = json_encode($unique_list);
       

        }
      //////////this is just to remove a marked user id that is now considered unmarked


      
       $sqlupd = "UPDATE `service_attendance_log` SET `attendance_list`='$attendance_list_json',`last_updated`=now() WHERE `service_date`='$service_date'";
        $qryupd = mysqli_query($dbc,$sqlupd) or die(mysqli_error($dbc));

        return json_encode(["status"=>"111","msg"=>"successupdate"]);



      }else{
      ///fresh insert
        //this is to remove the first element::date which is not needed
       

        $elements_to_insert_json = json_encode($elements_marked);
        $sqlins = "INSERT INTO `service_attendance_log` SET `attendance_list`='$elements_to_insert_json',`service_id`='$service_id',`service_date`='$service_date',`logged_by`='$uid',`date_created`=now()";
        $qryins = mysqli_query($dbc,$sqlins);
        return json_encode(["status"=>"111","msg"=>"success"]);
          
      }

}





}


///for service attendance
function check_if_member_is_marked_present($member_id,$service_date){
  global $dbc;
  $service_params = [];
  $conditions = ['service_date'=>$service_date];
  $get_service_det = get_one_row_from_one_table_with_sql_param($service_params,'service_attendance_log',$conditions,'date_created');


 if($get_service_det == null){
      return json_encode(["status"=>"119","msg"=>"No user record found"]);
  }else{
          $mapped_array = array_map('trim',json_decode($get_service_det['attendance_list'],true));

          if( in_array( $member_id, $mapped_array)  ){
               return json_encode(["status"=>"111","msg"=>"marked"]);
          }else{
               return json_encode(["status"=>"105","msg"=>"not marked"]);
          }
  }


}



function get_members_belonging_to_a_unit($unit_id){
  global $dbc;
  $param = ['unique_id','fname','lname','phone','units_array','date_created'];
  $conditions = ['role'=>2];
  $users = get_rows_from_one_table_with_sql_param($param,'users',$conditions,'date_created');
  $countt = 0;

  if($users == null){
      return json_encode(["status"=>"119","msg"=>"No user record found"]);

  }else{


      foreach ($users as $key => $userdet) {
          if(in_array($unit_id, array_map('trim',json_decode($userdet['units_array'],true), )  )){
          $disp[] = $userdet;
          $countt++;    
          }
      }

      if($countt > 0){
        return json_encode(["status"=>"111","msg"=>$disp]);
      }else{
        return json_encode(["status"=>"105","msg"=>"No Member found in this Unit"]);
      }


  }

}



function display_hc_attendance_by_range($home_cell_id,$start_date,$end_date){
  global $dbc;

  if($home_cell_id == 'all'){
      $sql = "SELECT * FROM `home_cell_attendance_log` WHERE `date_of_fellowship` >= '$start_date' AND `date_of_fellowship` <= '$end_date' ORDER BY `date_of_fellowship` DESC";
  }
  else{
     $sql = "SELECT * FROM `home_cell_attendance_log` WHERE `home_cell_id`='$home_cell_id' AND `date_of_fellowship` >= '$start_date' AND `date_of_fellowship` <= '$end_date' ORDER BY `date_of_fellowship` DESC";
  }
  
  
  $qry = mysqli_query($dbc,$sql) or die(mysqli_error($dbc));
  $num_count = mysqli_num_rows($qry);

  if($num_count <= 0){
      // echo "No record found";
      return json_encode(["status"=>"105","msg"=>"No record found"]);

  }else{
        
      while ( $row = mysqli_fetch_array($qry)) {
          $disp[] = $row;
      }
      return json_encode(["status"=>"111","msg"=>$disp]);


  }


}

function log_hc_attendance($logged_by,$elements_to_insert_arr){
    global $dbc;
    //////
    if(count($elements_to_insert_arr) > 2 ){
        $home_cell_id =  $elements_to_insert_arr[0]; 
        $hc_attendance_date =  $elements_to_insert_arr[1] ; 

        $hc_attendance_date2 = date("Y-m-d", strtotime($hc_attendance_date));

        $checkbox_array = [];
        $check_hc_attendance_for_a_date = check_hc_attendance_for_a_date($home_cell_id,$hc_attendance_date2);
        $check_hc_dec = json_decode($check_hc_attendance_for_a_date,true);

        for($i = 2; $i < count($elements_to_insert_arr); $i++  ){
        //echo $elements_to_insert_arr[$i].'<br>';
        $checkbox_array[] = $elements_to_insert_arr[$i];
        }

        $new_array = array(
        "home_cell_id"=>$home_cell_id,
        "hc_attendance_date"=>$hc_attendance_date,
        "attendance_list"=>$checkbox_array
        );
        $new_array = json_encode($new_array);


        if($check_hc_dec['status'] != '111'){
        //exists..just update
        $sqlupd = "UPDATE `home_cell_attendance_log` SET `attendance_list`='$new_array',`last_updated`=now() WHERE `home_cell_id`='$home_cell_id'";
        $qryupd = mysqli_query($dbc,$sqlupd) or die(mysqli_error($dbc));

        return json_encode(["status"=>"111","msg"=>"successupdate"]);


        }else{

        //insert
        $sqlins = "INSERT INTO `home_cell_attendance_log` SET `attendance_list`='$new_array',`home_cell_id`='$home_cell_id',`date_of_fellowship`='$hc_attendance_date2',`logged_by`='$logged_by',`date_created`=now()";
        $qryins = mysqli_query($dbc,$sqlins);

        return json_encode(["status"=>"111","msg"=>"success"]);


        }

    }else{
        return json_encode(["status"=>"113","msg"=>"no member was selected"]);
    }



 
    
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


function check_hc_attendance_for_a_date($home_cell_id,$attendance_date){
  global $dbc;
  $check_exist = check_record_by_two_params('home_cell_attendance_log','home_cell_id',$home_cell_id,'date_of_fellowship',$attendance_date);
  if($check_exist){
        return json_encode(["status"=>"109","msg"=>"This record exists"]);
  }else{
        return json_encode(["status"=>"111","msg"=>"success::you can log"]);
  }

}

function check_service_attendance_for_a_date($service_date){
  global $dbc;
  $check_exist = check_record_by_one_param('service_attendance_log','service_date',$service_date);
  if($check_exist){
        return json_encode(["status"=>"109","msg"=>"This record exists"]);
  }else{
        return json_encode(["status"=>"111","msg"=>"success::you can log"]);
  }

}


function get_hc_params_for_attendance_logging($uid,$home_cell_id,$hc_attendance_date){
  global $dbc;
  $hc_params = [];
  $conditions = ['home_cell_id'=>$home_cell_id];
  $get_hc_det = get_one_row_from_one_table_with_sql_param($hc_params,'home_cell_map',$conditions,'date_created');

   return $get_hc_det;

}



///
 function getDateForSpecificDayBetweenDates($startDate,$endDate,$day_number){
                  $endDate = strtotime($endDate);
                  $days=array('1'=>'Monday','2' => 'Tuesday','3' => 'Wednesday','4'=>'Thursday','5' =>'Friday','6' => 'Saturday','7'=>'Sunday');
                  for($i = strtotime($days[$day_number], strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i))
                  // $date_array[]=date('F-d-Y',$i);
                  $date_array[]=date('Y-m-d',$i);

                  return $date_array;
  }

////send birthday sms by Cron
function send_birthday_sms_cron(){
  global $dbc;
  $adminid = "13e0d49b6481b7ad094e65a057f2000b";
  $message_param = ['message'];
  $conditions = ['id'=>1];
  $get_set_message = get_one_row_from_one_table_with_sql_param($message_param,'bday_message',$conditions,'last_updated');
  if($get_set_message != null){
          $phone_merge = "";
          $count = 1;
          $message_gan_gan = urlencode($get_set_message['message']);
          $routing = 2;
          $param = ['dob','fname','lname','phone'];
          $current_month = date('F',strtotime(date('Y-m-d')));
          $current_day = date('d',strtotime(date('Y-m-d')));
          $conditions = ['role'=>'2','dob_day'=>$current_day,'dob_month'=>$current_month];
          $users = get_rows_from_one_table_with_sql_param($param,'users',$conditions,'date_created');

          if($users != null){
          foreach ($users as $user) {
                
              if(count($users) == $count){
              $phone_merge .= $user['phone'];
              }else{
              $phone_merge .= $user['phone'].',';
              }

              $count++;


          }
              $smss= send_sms_smart($adminid,$message_gan_gan,$routing,$phone_merge);
              $smss_decode = json_decode($smss,true);
              //echo $smss_decode['msg'];
              echo email_function('samuel.adebunmi@cloudware.ng',"Birthday Automatic SMS Sent Today","Great, birthday sms was automatically sent today. Regards");
          }

          else{
          echo "No Birthdays today";
          }
          //echo $current_day;


  } else{
        echo email_function('samuel.adebunmi@cloudware.ng',"Please Set Birthday Message","Oops, a member could not get birthday sms because message was not set. Please go to admin to do that. Regards");
  }

}


function email_function($email, $subject, $content){
  $headers = "From: ChurchWorldv1\r\n";
  @$mail = mail($email, $subject, $content, $headers);
  return $mail;
}

function add_audio($title,$description,$author,$visibility,$audio_link,$uid){
   global $dbc;
   $check_exist = check_record_by_one_param('youtube_videos','title',$title);
   if($check_exist){
        return json_encode(["status"=>"109","msg"=>"This record exists"]);
   }else if($title == "" ||  $description == "" ||  $author == "" ||  $visibility == "" ||  $audio_link== "" ||  $uid == "" ){
        return json_encode(["status"=>"105","msg"=>"Empty field(s) found"]);
   }else{
        $audio_id = unique_id_generator($title.$author);
        $sqladd = "INSERT INTO `audios` SET 
        `audio_id`='$audio_id',
        `title`='$title',
        `description`='$description',
        `author`='$author',
        `visibility`='$visibility',
        `audio_link`='$audio_link',
        `added_by`='$uid',
        `date_added`=now()
        ";
        $qryadd = mysqli_query($dbc,$sqladd);
        if($qryadd){
        return json_encode(["status"=>"111","msg"=>"Audio was successfully created."]);
        }else{
        return json_encode(["status"=>"103","msg"=>"Server Error"]);
        }


   }
        // return json_encode(["status"=>"103","msg"=>"This record exists already"]);

   


}


function add_youtube_link($title,$description,$author,$visibility,$embedded_code,$uid){
  global $dbc;
  $title = secure_database($title);
  $visibility = secure_database($visibility);
  $author = secure_database($author);
  $uid = secure_database($uid);
  $description = secure_database($description);
 
 //check if material exists
  $check_exist = check_record_by_one_param('youtube_videos','title',$title);
  if($check_exist){
        return json_encode(["status"=>"103","msg"=>"This record exists already"]);
  }else{
        // $upload_type = "ebook";
        // $materials_upload = materials_upload($upload_type,$file_name,$size,$tmpName,$type);
        // $decode_mat = json_decode($materials_upload,true);
        // if($decode_mat['status'] != 111){
        // return json_encode(["status"=>"100","msg"=>$decode_mat['msg']]);
        // }else{
        $youtube_id = unique_id_generator($title.$embedded_code.time());
        // $docs_path = $decode_mat['msg'];
        $sql = "INSERT INTO `youtube_videos` SET
        `youtube_id` = '$youtube_id',
        `title` = '$title',
        `embedded_code` = '$embedded_code',
        `author` = '$author',
        `visibility` = '$visibility',
        `description` = '$description',
        `date_added` = now(),
        `added_by`='$uid'
        ";
        $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        if($query){
        return json_encode(["status"=>"111","msg"=>"This Youtube video was succesfully added"]); 
        }

        // }
  }
}

// $file_name, $size, $tmpName,$type,
function add_hardcopy_book($title,$author,$visibility,$price_type,$price,$description,$uid){
  global $dbc;
  $title = secure_database($title);
  $visibility = secure_database($visibility);
  $price_type = secure_database($price_type);
  $price = secure_database($price);
  $description = secure_database($description);

 //check if material exists
  $check_exist = check_record_by_one_param('hardcopy_books_tbl','title',$title);
  if($check_exist){
        return json_encode(["status"=>"103","msg"=>"This record exists already"]);
  }else{
        // $upload_type = "ebook";
        // $materials_upload = materials_upload($upload_type,$file_name,$size,$tmpName,$type);
        // $decode_mat = json_decode($materials_upload,true);
        // if($decode_mat['status'] != 111){
        // return json_encode(["status"=>"100","msg"=>$decode_mat['msg']]);
        // }else{
        $hardcopy_book_id = unique_id_generator($title.$price.time());
        // $docs_path = $decode_mat['msg'];
        $sql = "INSERT INTO `hardcopy_books_tbl` SET
        `hardcopy_book_id` = '$hardcopy_book_id',
        `title` = '$title',
        `author` = '$author',
        `visibility` = '$visibility',
        `price_type` = '$price_type',
        `price_value` = '$price',
        `description` = '$description',
        `date_added` = now(),
        `added_by`='$uid'
        ";
        $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        if($query){
        return json_encode(["status"=>"111","msg"=>"This Hardcopy Book was succesfully added"]); 
        }

        // }
  }
}

function add_ebook($title,$author,$visibility,$price_type,$price,$description,$file_name, $size, $tmpName,$type,$uid){
  global $dbc;
  $title = secure_database($title);
  $visibility = secure_database($visibility);
  $price_type = secure_database($price_type);
  $price = secure_database($price);
  $description = secure_database($description);

 //check if material exists
  $check_exist = check_record_by_one_param('ebook_tbl','title',$title);
  if($check_exist){
        return json_encode(["status"=>"103","msg"=>"This record exists already"]);
  }else{
        $upload_type = "ebook";
        $materials_upload = materials_upload($upload_type,$file_name,$size,$tmpName,$type);
        $decode_mat = json_decode($materials_upload,true);
        if($decode_mat['status'] != 111){
        return json_encode(["status"=>"100","msg"=>$decode_mat['msg']]);
        }else{
        $ebook_id = unique_id_generator($title.$file_name.time());
        $docs_path = $decode_mat['msg'];
        $sql = "INSERT INTO `ebook_tbl` SET
        `ebook_id` = '$ebook_id',
        `title` = '$title',
        `author` = '$author',
        `visibility` = '$visibility',
        `price_type` = '$price_type',
        `price_value` = '$price',
        `description` = '$description',
        `docs_path` = now(),
        `date_added` = now(),
        `added_by`='$uid'
        ";
        $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        if($query){
        return json_encode(["status"=>"111","msg"=>"This Ebook was succesfully added"]); 
        }

        }
  }
}


function materials_upload($upload_type,$file_name, $size, $tmpName,$type){
    //global $dbc;

    if($upload_type == 'ebook'){
        $upload_path33 = "ebooks/".$file_name;
        $file_extensions = ['pdf','docx','doc'];//pdf,PDF
        $file_extension = substr($file_name,strpos($file_name, '.') + 1);
        //$file_extension = strtolower(end(explode('.', $file_name)));
    }
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


//////////sms functions starts
      function send_sms_smart($adminid,$message,$routing,$to){
        //$message = urlencode($message);
        //global $senderid;

        global $dbc;
        $message = secure_database($message);
        $senderid = urlencode("SmartSMS");
        $token = "nHVJu7NGqF7DyZYJxJ6jDjrpemVqEvnf80cNuZZd6mCBjFwHLVBRqS0NjTnfMJT8upmvRgKqYG6YLBKkedcgAUaBdyctSMhuZIpy";
    
        $type = 0;
        $baseurl = 'https://smartsmssolutions.com/api/json.php?';
        $sendsms = $baseurl.'message='.$message.'&to='.$to.'&sender='.$senderid.'&type='.$type.'&routing='.$routing.'&token='.$token;

        $response = file_get_contents($sendsms);

        $decode = json_decode($response,true);
        
        if($decode['code'] == '1000'){
           $logid = unique_id_generator($message);
           $sql_create_log = "INSERT INTO `sms_log` SET `status`='successful', `message`='$message', `log_id`='$logid',  `log_json` = '$response', `added_by`='$adminid', `date_created`=now() ";
           $qry_created_log = mysqli_query($dbc,$sql_create_log);
          return json_encode(array( "status"=>111, "msg"=>$response,"message"=>"success" ));

        }else{
          $logid = unique_id_generator($message);
          $sql_create_log = "INSERT INTO `sms_log` SET `status`='failed', `message`='$message', `log_id`='$logid',  `log_json` = '$response', `added_by`='$adminid', `date_created`=now() ";
          $qry_created_log = mysqli_query($dbc,$sql_create_log);

          return json_encode(array( "status"=>101, "msg"=>$response,"message"=>"failed" ));

        }

      }



    function send_sms_smart_to_group($adminid,$group_id,$message, $routing,$to){
        //$message = urlencode($message);
        //global $senderid;
       global $dbc;
       $message = secure_database($message);
        $senderid = urlencode("SmartSMS");
        $token = "nHVJu7NGqF7DyZYJxJ6jDjrpemVqEvnf80cNuZZd6mCBjFwHLVBRqS0NjTnfMJT8upmvRgKqYG6YLBKkedcgAUaBdyctSMhuZIpy";
    
        $type = 0;
        $baseurl = 'https://smartsmssolutions.com/api/json.php?';
        $sendsms = $baseurl.'message='.$message.'&to='.$to.'&sender='.$senderid.'&type='.$type.'&routing='.$routing.'&token='.$token;

        $response = file_get_contents($sendsms);

        $decode = json_decode($response,true);
        if($decode['code'] == '1000'){
         
          $logid = unique_id_generator($message);
          $sql_create_log = "INSERT INTO `sms_log` SET `status`='successful', `message`='$message', `log_id`='$logid', `group_id`='$group_id', `log_json` = '$response', `added_by`='$adminid', `date_created`=now() ";
          $qry_created_log = mysqli_query($dbc,$sql_create_log);

         
          return json_encode(array( "status"=>111, "msg"=>$response,"message"=>"success" ));

        }else{

          $logid = unique_id_generator($message);
          $sql_create_log = "INSERT INTO `sms_log` SET `status`='failed', `message`='$message', `log_id`='$logid', `group_id`='$group_id', `log_json` = '$response', `added_by`='$adminid', `date_created`=now() ";
          $qry_created_log = mysqli_query($dbc,$sql_create_log);

          return json_encode(array( "status"=>101, "msg"=>$response,"message"=>"failed" ));

        }

      }


  function smart_balance(){
        $token = 'nHVJu7NGqF7DyZYJxJ6jDjrpemVqEvnf80cNuZZd6mCBjFwHLVBRqS0NjTnfMJT8upmvRgKqYG6YLBKkedcgAUaBdyctSMhuZIpy';
        $checkbalance = "https://smartsmssolutions.com/api/?checkbalance=1&token=".$token;
        $balance = file_get_contents($checkbalance);
        return $balance;
        }

  ///////nigeria bulk sms site
   function send_sms_new($username, $password, $message, $sender_id,$mobiles)
    {
      $message = secure_database($message);
     $url = "https://portal.nigeriabulksms.com/api/?username=".$username."&password=".$password."&message=".$message."&sender=".$sender_id."&mobiles=".$mobiles; 
     
     $ch = curl_init(); 
     curl_setopt($ch,CURLOPT_URL, $url); 
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
     curl_setopt($ch, CURLOPT_HEADER, 0); 
     $resp = curl_exec($ch); 
     return $resp; // Add double slash or delete “echo” echo "<br>Thank you for using Interbound Media SMSAPI"; // Your notification message here 
     curl_close($ch); 
   }

   ///nigeria bulk sms site ends here

   function check_sms_balance($username, $password){
   
     // The cloudsms api only accepts numbers in the format 234xxxxxxxxxx (without the + sign.)
        $curl = curl_init();
        //http://smsprovider.com.ng/api/
        //nigeriabulksms.com
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://portal.nigeriabulksms.com/api/?username=".$username."&password=".$password."&action=balance",
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



function update_sms_group($uid,$grid,$number_list){
  global $dbc;
  if($uid == "" || $grid == "" || $number_list == ""){
        return json_encode(array( "status"=>103, "msg"=>"Empty record(s) found" ));
  }else{
       $numbers_list_enc = json_encode($number_list);
       $sql = "UPDATE `sms_groups` SET `numbers_list`='$numbers_list_enc' WHERE `sms_group_id`='$grid'  ";
       $qry = mysqli_query($dbc,$sql);
       if($qry){
        return json_encode(array( "status"=>111, "msg"=>"success" ));

       }else{
        return json_encode(array( "status"=>103, "msg"=>"Server Error Found" ));

       }
  }
}



/////////very logical function
function check_if_member_in_another_home_cell($member_id){
  global $dbc;
  $in_another_hc  = array();
  $not_in_another_hc  = array();
     $hc_map = get_rows_from_one_table('home_cell_map','date_created');

     // if($hc_map == null){
     //    return json_encode(array( "status"=>114, "msg"=>"Empty Record Found" ));
     // }else{
        foreach ($hc_map as $key => $each_cell_row) {
            $get_member_list = $each_cell_row['members_list'];
            $get_member_list_dec = json_decode($get_member_list,true);
            $get_member_list_dec2 = array_map('trim', $get_member_list_dec);
            //now loop through to get member list and compare
            if(in_array($member_id, $get_member_list_dec2)){
                $home_cell_id = $each_cell_row['home_cell_id'];
                $get_homecell_det = get_one_row_from_one_table_by_id('home_cell_definition','unique_id',$home_cell_id,'date_created');
                $home_cell_name = $get_homecell_det['cell_name'];

                return json_encode(array( "status"=>105, "msg"=>"Exists in: ".$home_cell_name ));

            }
        }

        ///this is a good state::::member id not found all through
        return json_encode(array( "status"=>111, "msg"=>"success"));


     //}
}

function update_home_cell_members($uid,$home_cell_id,$member_list){
  global $dbc;
  if($uid == "" || $home_cell_id == "" || $member_list == ""){
        return json_encode(array( "status"=>103, "msg"=>"Empty record(s) found" ));
  }else{
       $members_list_enc = json_encode($member_list);
       $sql = "UPDATE `home_cell_map` SET `members_list`='$members_list_enc' WHERE `home_cell_id`='$home_cell_id'";
       $qry = mysqli_query($dbc,$sql);
       if($qry){
        return json_encode(array( "status"=>111, "msg"=>"success" ));

       }else{
        return json_encode(array( "status"=>103, "msg"=>"Server Error Found" ));

       }
  }
}



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

function remove_from_blacklist($blacklist_string,$adminid){
  global $dbc;
  $display = "<br><div class='alert alert-warning'>";
  $blacklist_string = secure_database($blacklist_string);
  $blacklist_to_array = explode(',', $blacklist_string);
  foreach ($blacklist_to_array as $user_id){
           $check_exist = check_record_by_one_param('blacklisted_numbers','blacklisted_user_id',$user_id);
           $userdet = get_one_row_from_one_table_by_id('users','unique_id',$user_id,'date_created');
           $fullname = $userdet['fname'].' '.$userdet['lname'];
           $phone = $userdet['phone'];
         
           if($check_exist){

              $blacklist_id = unique_id_generator($phone.$userdet['fname'].$userdet['lname']);
              $sql = "DELETE FROM `blacklisted_numbers` WHERE `blacklisted_user_id`='$user_id' ";
              $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));

              if($query){

                  $display .= '<small style="color:green;">'.$phone.": removed from blacklisted</small><br>";                           
              }
  
            }

            else{
                $display .= '<small style="color:red;">'.$phone.": not a blacklisted number </small><br>";
              }
    }

    $display .= "<br> redirecting shortly...</div>";

    return $display;
}



function add_to_blacklist($blacklist_string,$adminid){
  global $dbc;
  $display = "<br><div class='alert alert-warning'>";
  $blacklist_string = secure_database($blacklist_string);
  $blacklist_to_array = explode(',', $blacklist_string);
  foreach ($blacklist_to_array as $user_id){
           $check_exist = check_record_by_one_param('blacklisted_numbers','blacklisted_user_id',$user_id);
           $userdet = get_one_row_from_one_table_by_id('users','unique_id',$user_id,'date_created');
           $fullname = $userdet['fname'].' '.$userdet['lname'];
           $phone = $userdet['phone'];
         
           if($check_exist){
              
              $display .= '<small style="color:red;">'.$phone.": exists already</small><br>";

            }else{

            $blacklist_id = unique_id_generator($phone.$userdet['fname'].$userdet['lname']);
            $sql = "INSERT INTO `blacklisted_numbers` SET
                `blacklist_id` = '$blacklist_id',
                `blacklisted_user_id` = '$user_id',
                `blacklist_phone` = '$phone',
                `date_created` = now(),
                `created_by`='$adminid'
                ";
                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));

                if($query){
                   
              $display .= '<small style="color:green;">'.$phone.": blacklisted</small><br>";
              
                                     
               }


          }
    }

    $display .= "<br> redirecting shortly...</div>";
    

    return $display;
}

function members_search_by_birthmonth($birth_month){
    global $dbc;
    $current_month = date('F',strtotime(date('F-d-Y')));
    $users = get_rows_from_one_table_by_two_params('users','role',2,'dob_month',$birth_month,'fname');
     if($users != null){

    
         ?>
          <div class="row">
                     <div class="col-md-12">
                      <div class="card-body">
                      <div class="table-responsive">
                    <h6><span style="color:blue;"><?php echo count($users) ." record(s) found";  ?></span></h6>
                   <table class="table table-responsive table-bordered" id="dataTable" style="width:100%" cellspacing="0">
                  <thead>
                    <tr>
                      
                      <th>Fullame</th>
                      <th>Phone</th>
                      <th>Date of Birth</th>
                      <th>Gender</th>
                
                      <!-- <th>Marital Status</th> -->
                      
                      <th>Date Created</th>
                      <th>Actions</th>
                      
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      
                    <th>Fullame</th>
                      <th>Phone</th>
                      <th>Date of Birth</th>
                      <th>Gender</th>
               
                      <!-- <th>Marital Status</th> -->
                      <th>Date Created</th>
                      <th>Actions</th>
                   
                    </tr>
                  </tfoot>
                  <tbody>
                   <?php 
                  
                    foreach($users as $user){
                    $dob = $user['dob'];
                    $month = date('F',strtotime($dob));
                    
                      ?>
                    <tr>
                      <td><?php echo $user['fname'].' '.$user['lname'];?></td>
                      <td><?php echo $user['phone'];?></td>
                      <td><?php echo date('F-d',strtotime($user['dob']));?></td>
                      <td><?php echo $user['gender'];?></td>  
                      <td><?php echo date('F-d-Y',strtotime($user['date_created'])); ?></td>
                      <td>
                       
                        <select class="form-control form-control-sm member_ops" id="<?php echo $user['unique_id']; ?>">
                             <option value="">select an option</option>
                             <option value="edit">Edit</option>
                             <option value="view">View</option>
                        </select>
                      </td>
                    </tr>

                  <?php } ?>
                    
                      <script type="text/javascript">
                      $('.member_ops').change(function (e) {
                      e.preventDefault();

                      var userid = $(this).attr('id');
                      var option_value = $('#'+userid).val();
                      // var 
                      if(option_value == 'view'){

                      $.ajax({
                      url:"ajax/single_member_view2.php",
                      method: "GET",
                      data:{userid:userid},
                      beforeSend: function(){
                      toastr.success("Loading...", "Please wait!");

                      },
                      success:function(data){
                      toastr.clear();

                      $(".modal-content").html(data);
                      $('#memberOps').modal('show');
                      //toastr.error(option_value, "Caution!");
                      $('#'+userid).val("");

                      }


                      });


                      }



                      if(option_value == 'edit'){

                      toastr.success("Please wait as you are redirected shortly", "Success!");
                      setTimeout( function(){ window.location.href = "edit_member.php?id="+userid; }, 2000);


                      }


                      });
                      </script>
                  
                  </tbody>
                </table>
                
              </div></div>
              </div>
             </div>

             



              <!-- Upload Cleaned Data -->
              <div class="modal fade" id="memberOps" tabindex="-1" role="dialog" aria-labelledby="memberOps" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Record for</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              </button>
              </div>
              <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

              </div>
              </div>
              </div>
              </div>

<?php     
      }else{

          echo "No record found";

      }

}







function members_search_by_birthday(){
    global $dbc;
    //$birthmonth = date('F',strtotime(date('F-d-Y')));
    $birthday = date('d',strtotime(date('F-d-Y')));
   
    // $users = get_rows_from_one_table_by_three_params('users','role',2,'dob_month',$birthmonth,'birthday',$birthday,'fname');
    $users = get_rows_from_one_table_by_two_params('users','role',2,'dob_day',$birthday,'fname');
   
     if($users != null){

    
         ?>
                
          <div class="row">

             <div class="col-lg-12">

          <div class="card-body">
              <div class="table-responsive">
                    <h6><span style="color:blue;"><?php echo count($users) ." birthday celebrant(s) today";  ?></span></h6>
                     <table class="table table-responsive table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      
                      <th>Fullame</th>
                      <th>Phone</th>
                      <th>Date of Birth</th>
                      <th>Gender</th>
                
                      <!-- <th>Marital Status</th> -->
                      
                      <th>Date Created</th>
                      <th>Actions</th>
                      
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      
                    <th>Fullame</th>
                      <th>Phone</th>
                      <th>Date of Birth</th>
                      <th>Gender</th>
               
                      <!-- <th>Marital Status</th> -->
                      <th>Date Created</th>
                      <th>Actions</th>
                   
                    </tr>
                  </tfoot>
                  <tbody>
                   <?php 
                  
                    foreach($users as $user){
                    $dob = $user['dob'];
                    $month = date('F',strtotime($dob));
                    
                      ?>
                    <tr>
                      <td><?php echo $user['fname'].' '.$user['lname'];?></td>
                      <td><?php echo $user['phone'];?></td>
                      <td><?php echo date('F d',strtotime($user['dob']));?></td>
                      <td><?php echo $user['gender'];?></td>  
                      <td><?php echo date('F-d-Y',strtotime($user['date_created'])); ?></td>
                      <td></td>
                    </tr>
                    <?php } ?>
                  
                  
                  </tbody>
                </table>
                
              </div></div>

             </div>

           </div>
<?php     
      }else{

          echo "<span style='padding: 10px;'>No record found</span>";

      }

}



function members_search_by_unit($unit_search_array){
  global $dbc;
  //first loop throug search
  $display = array();
  
        $count = 0;
        $sql = "SELECT * FROM `users` WHERE `role`='2'";
        $qry = mysqli_query($dbc,$sql);
        while($row_per_user = mysqli_fetch_array($qry)){
              
              foreach ($unit_search_array as $search) {
                   $units_array = json_decode($row_per_user['units_array'],true);
                    if(in_array ( $search, array_map('trim',$units_array)) ){
                        $count++;
                    }

              }    

              ///after the loop, &&  count($units_array) == count($unit_search_array)   count($units_array)
              if($count > 0  ){
                  $display[] = $row_per_user;

              }   

              //reset $count for next user     
              $count = 0;

             
        }



        if($display == null){
                  return json_encode(array( "status"=>103, "msg"=>"No record Found" ));
        }else{
                  return json_encode(array( "status"=>111, "msg"=>$display  )); 
        }

}


function members_search_by_home_cell($home_cell){
  global $dbc;
  //first loop throug search
  $display = array();
  
              foreach ($home_cell_array as $each_cell) {
                   $member_det = json_decode($each_cell,true);
                    if(in_array ( $search, $units_array )){
                        $count++;
                    }



              }    

        if($display == null){
                  return json_encode(array( "status"=>103, "msg"=>"No record Found" ));
        }else{
                  return json_encode(array( "status"=>111, "msg"=>$display  )); 
        }

}


function create_outreach_member($added_by,$fname,$lname,$email,$phone,$address){
        global $dbc;
        $table = 'outreach_members';
        $fname = secure_database($fname);
        $lname = secure_database($lname);
        $email = secure_database($email);
        $phone = secure_database($phone);
        $added_by = secure_database($added_by);
      
        $address = secure_database($address);
       
        $unique_id = unique_id_generator($fname.$lname.$phone);
        $check_exist = check_record_by_one_param($table,'phone',$phone);


        if($check_exist){
                return json_encode(array( "status"=>109, "msg"=>"This Phone number exists" ));
         }

         else{

            if( $fname == "" || $lname == "" || $phone == "" || $address == "" || $added_by == ""){

                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));

                }

                else{


                $sql = "INSERT INTO `outreach_members` SET
                `unique_id` = '$unique_id',
                `fname` = '$fname',
                `lname` = '$lname',
                `phone` = '$phone',
                `email` = '$email',
                `address` = '$address',
                `added_by` = '$added_by',
                `date_created` = now()
                ";
                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));


              
              if($query){
          
                 return json_encode(array( "status"=>111, "msg"=>"success"));

                }else{

                return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                }


                }

         }


        
}


function create_member($fname,$lname,$email,$phone,$gender,$dob,$marital_status,$wedding_anniversary_date,$units,$address){
        global $dbc;
        $table = 'users';
        $fname = secure_database($fname);
        $lname = secure_database($lname);
        $email = secure_database($email);
        $phone = secure_database($phone);
        $gender = secure_database($gender);
        $dob = secure_database($dob);
        $dob_day = date('d',strtotime($dob));
        $dob_month = date('F',strtotime($dob));
        
        $marital_status = secure_database($marital_status);
        $wedding_anniversary_date = secure_database($wedding_anniversary_date);
        //$units = secure_database($units);
        $units = json_encode($units);
        $address = secure_database($address);
        $hashpassword = md5('password');
        $img_url = "profiles/default.jpg";
        $church_id = 'cf2494b4156ce77dcdceadd131081b1d';
       
        $unique_id = unique_id_generator($fname.$lname.$phone);
        $check_exist = check_record_by_one_param($table,'phone',$phone);


        if($check_exist){
                return json_encode(array( "status"=>109, "msg"=>"This Phone number exists" ));
         }

         else{

            if( $fname == "" || $lname == "" || $email == "" || $phone == "" || $gender == "" || $dob == "" || $marital_status == "" || $wedding_anniversary_date == "" || $address == ""){

                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));

                }

                else{


                $sql = "INSERT INTO `users` SET
                `unique_id` = '$unique_id',
                `church_id` = '$church_id',
                `fname` = '$fname',
                `lname` = '$lname',
                `phone` = '$phone',
                `email` = '$email',
                `password` = '$hashpassword',
                `img_url` = '$img_url',
                `role`= 2,
                `gender`= '$gender',
                `address`= '$address',
                `marital_status`= '$marital_status',
                `units_array`= '$units',
                `wedding_anniversary`= '$wedding_anniversary_date',
                `dob`= '$dob',
                `dob_day`= '$dob_day',
                `dob_month`= '$dob_month',
                `access_status`= 1,
                `date_created` = now()
                ";
                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));


              
              if($query){
          
                 return json_encode(array( "status"=>111, "msg"=>"success"));

                }else{

                return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                }


                }

         }


        
}



function update_member($member_id,$fname,$lname,$email,$phone,$gender,$dob,$marital_status,$wedding_anniversary_date,$units,$address){
        global $dbc;
        $table = 'users';
        $member_id = secure_database($member_id);
        $fname = secure_database($fname);
        $lname = secure_database($lname);
        $email = secure_database($email);
        $phone = secure_database($phone);
        $gender = secure_database($gender);
        $dob = secure_database($dob);
        $dob_day = date('d',strtotime($dob));
        $dob_month = date('F',strtotime($dob));
        
        $marital_status = secure_database($marital_status);
        $wedding_anniversary_date = secure_database($wedding_anniversary_date);
        
        //$units = secure_database($units);
        $units = json_encode($units);
        $address = secure_database($address);
        //$hashpassword = md5('password');
        //$img_url = "profiles/default.jpg";
        //$church_id = 'cf2494b4156ce77dcdceadd131081b1d';
       
        //$unique_id = unique_id_generator($fname.$lname.$phone);
        $check_exist = check_record_by_one_param($table,'email',$email);


       

            if($member_id == "" ||  $fname == "" || $lname == "" || $email == "" || $phone == "" || $gender == "" || $dob == "" || $marital_status == "" || $wedding_anniversary_date == "" || $address == ""){

                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));

                }

                else{


                $sql = "UPDATE `users` SET
                `fname` = '$fname',
                `lname` = '$lname',
                `phone` = '$phone',
                `email` = '$email',
                `gender`= '$gender',
                `address`= '$address',
                `marital_status`= '$marital_status',
                `units_array`= '$units',
                `wedding_anniversary`= '$wedding_anniversary_date',
                `dob`= '$dob',
                `dob_day`= '$dob_day',
                `dob_month`= '$dob_month',
                `access_status`= 1
                WHERE `unique_id`='$member_id' 
                ";
                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));


              
              if($query){
          
                 return json_encode(array( "status"=>111, "msg"=>"success"));

                }else{

                return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                }


                

         }


        
}


function set_bday_message($uid,$message){
  global $dbc;
  $message = secure_database($message);
            if($message == ""){
              
              return json_encode(array( "status"=>107, "msg"=>"Message field cannot be empty" ));

            }else{

              $sql_update = "UPDATE `bday_message` SET `message` = '$message',`last_update_by`='$uid',`last_updated`=now() WHERE `id`=1
              ";
              $qryupdate = mysqli_query($dbc, $sql_update) or die(mysqli_error($dbc));
              if($qryupdate){
              return json_encode(array( "status"=>111, "msg"=>"success" ));
              }else{
              return json_encode(array( "status"=>105, "msg"=>"Server error occured" ));
              }

            }
        
}



function create_unit($uid,$unit_name){
  global $dbc;

  $check_exist = check_record_by_one_param('units','unit_name',$unit_name);
  if($uid == '' || $unit_name == ''){
          return json_encode(array( "status"=>103, "msg"=>"Empty field(s) found" ));
  }

  else if($check_exist){
          return json_encode(array( "status"=>103, "msg"=>"Sorry, this record exists" ));
  }
  else{
            $unique_id = unique_id_generator($uid.$unit_name);
            $sqlinsert = "INSERT INTO `units` SET
            `unit_id` = '$unique_id',
            `unit_name` = '$unit_name',
            `created_by` = '$uid',
            `date_created` = now()

            ";
            $queryinsert = mysqli_query($dbc, $sqlinsert) or die(mysqli_error($dbc));

            if($queryinsert){

                  return json_encode(array( "status"=>111, "msg"=>"success" ));


            }else{
                
                  return json_encode(array( "status"=>105, "msg"=>"Server error occured" ));

            }

  }

}


function add_home_cell($uid,$home_cell_name,$cell_leader,$cell_host,$cell_members,$cell_address,$other_info){
  global $dbc;

  $check_exist = check_record_by_one_param('home_cell_definition','cell_name',$home_cell_name);

  if($uid == '' || $home_cell_name == ''  || $cell_leader == '' || $cell_host == '' || empty($cell_members) || $cell_address == ''){
          return json_encode(array( "status"=>103, "msg"=>"Empty field(s) found" ));
  }

  else if($check_exist){
          return json_encode(array( "status"=>103, "msg"=>"Sorry, this record exists" ));
  }
  else{
            $cell_members = json_encode($cell_members);
            $unique_id = unique_id_generator($uid.$home_cell_name);
            $unique_id2 = unique_id_generator($cell_host.$home_cell_name);
            $sqlinsert = "INSERT INTO `home_cell_definition` SET
            `unique_id` = '$unique_id',
            `cell_name` = '$home_cell_name',
            `cell_host` = '$cell_host',
            `leaders_list`='$cell_leader',
            `address`='$cell_address',
            `other_info`='$other_info',
            `added_by`='$uid',
            `date_created` = now()

            ";
            $queryinsert = mysqli_query($dbc, $sqlinsert) or die(mysqli_error($dbc));


            ////insert into map tbl
            
            $sqlinsert_map = "INSERT INTO `home_cell_map` SET
            `unique_id` = '$unique_id2',
            `home_cell_id` = '$unique_id',
            `members_list` = '$cell_members',
            `added_by`='$uid',
            `date_created` = now()

            ";
            $queryinsert_map = mysqli_query($dbc, $sqlinsert_map) or die(mysqli_error($dbc));

            if($queryinsert == true && $queryinsert_map == true){

                  return json_encode(array( "status"=>111, "msg"=>"success" ));


            }else{
                
                  return json_encode(array( "status"=>105, "msg"=>"Server error occured" ));

            }

  }

}





function create_sms_group($uid,$sms_name,$numbers_list){
  global $dbc;

  $check_exist = check_record_by_one_param('sms_groups','sms_group_name',$sms_name);
  if($uid == '' || $sms_name == ''){
          return json_encode(array( "status"=>103, "msg"=>"Empty field(s) found" ));
  }

  else if($check_exist){
          return json_encode(array( "status"=>103, "msg"=>"Sorry, this record exists" ));
  }
  else{
            $unique_id = unique_id_generator($uid.$sms_name);
            $numbers_list = json_encode($numbers_list);
            $sqlinsert = "INSERT INTO `sms_groups` SET
            `sms_group_id` = '$unique_id',
            `sms_group_name` = '$sms_name',
            `numbers_list` = '$numbers_list',
            `created_by` = '$uid',
            `date_created` = now()

            ";
            $queryinsert = mysqli_query($dbc, $sqlinsert) or die(mysqli_error($dbc));

            if($queryinsert){

                  return json_encode(array( "status"=>111, "msg"=>"success" ));


            }else{
                
                  return json_encode(array( "status"=>105, "msg"=>"Server error occured" ));

            }

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





function update_basic_profile($first_name2,$last_name2,$phone2,$gender2,$uid){
     global $dbc;

     if ($first_name2 == "" || $last_name2 == "" || $phone2 == "" || $gender2 == "" ) {

          return json_encode(array( "status"=>103, "msg"=>"Empty field(s) found" ));
     
     }else{

        $sql = "UPDATE `users` SET `fname`='$first_name2',`lname`='$last_name2',`phone`='$phone2',`gender`='$gender2',`update_option`=1 WHERE `unique_id`='$uid'";
        $qry = mysqli_query($dbc,$sql);
        if($qry){
        return json_encode(array( "status"=>111, "msg"=>"success" ));

        }else{

        return json_encode(array( "status"=>102, "msg"=>"failure" ));

        }

     }
}


//1- bank to wallet 2 - wallet to bank 3 - from wallet to buy bitcin 4 - back to wallet to sell bitcoin
function view_recent_transactions_all_users($count){
  global $dbc;
  $sql = "SELECT * FROM `transactions` ORDER BY `date_confirmed` DESC LIMIT $count";
  $qry = mysqli_query($dbc,$sql);
  $couut = mysqli_num_rows($qry);
    
  if($couut > 0){
      while ($row = mysqli_fetch_array($qry)) {
      $display[] = $row;
      }
      return $display;

  }else{

      return null;
  }

  
}


//1- bank to wallet 2 - wallet to bank 3 - from wallet to buy bitcin 4 - back to wallet to sell bitcoin
function view_recent_transactions($uid,$count){
  global $dbc;
  $sql = "SELECT * FROM `transactions` WHERE `user_id`='$uid' ORDER BY `date_confirmed` DESC LIMIT $count";
  $qry = mysqli_query($dbc,$sql);
  $couut = mysqli_num_rows($qry);
    
  if($couut > 0){
      while ($row = mysqli_fetch_array($qry)) {
      $display[] = $row;
      }
      return $display;

  }else{

      return null;
  }

  
}



function update_bank_details($uid,$bank_name,$account_name,$account_no){
    global $dbc;

    if($bank_name == "Access Bank Plc"){
                 $bankcode = "044";         
    }

    if($bank_name == "Fidelity Bank Plc"){
                 $bankcode = "070";         
    }

    if($bank_name == "First City Monument Bank Limited"){
                 $bankcode = "214";         
    }

    if($bank_name == "First Bank of Nigeria Limited"){
                 $bankcode = "011";         
    }

    if($bank_name == "Guaranty Trust Bank Plc"){
                 $bankcode = "058";         
    }

    if($bank_name == "Union Bank of Nigeria Plc"){
                 $bankcode = "032";         
    }

    if($bank_name == "United Bank for Africa Plc"){
                 $bankcode = "033";         
    }

    if($bank_name == "Citibank Nigeria Limited"){
                 $bankcode = "023";         
    }

    if($bank_name == "Ecobank Nigeria Plc"){
                 $bankcode = "050";         
    }

    if($bank_name == "Heritage Banking Company Limited"){
                 $bankcode = "030";         
    }

     if($bank_name == "Keystone Bank Limited"){
                 $bankcode = "082";         
    }

     if($bank_name == "Standard Chartered Bank"){
                 $bankcode = "068";         
    }

     if($bank_name == "Stanbic IBTC Bank Plc"){
                 $bankcode = "221";         
    }

     if($bank_name == "Sterling Bank Plc"){
                 $bankcode = "232";         
    }

     if($bank_name == "Titan Trust Bank Limited"){
                 $bankcode = "022";         
    }
      if($bank_name == "Unity Bank Plc"){
                 $bankcode = "215";         
    }
      if($bank_name == "Wema Bank Plc"){
                 $bankcode = "035";         
    }

     

    
    $sql = "UPDATE `users` SET `bank_code`='$bankcode', `bank_name`='$bank_name',`account_name`='$account_name',`account_no`='$account_no',`update_option`=1 WHERE `unique_id`='$uid'";
    $qry = mysqli_query($dbc,$sql);
    if($qry){
    return json_encode(array( "status"=>111, "msg"=>"success" ));

    }else{

    return json_encode(array( "status"=>102, "msg"=>"failure" ));

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




function check_profile_update($uid,$bank_name,$account_name,$account_no,$update_option){
   global $dbc;
   $sql = "SELECT * FROM users WHERE `unique_id`='$uid'";
   $qry = mysqli_query($dbc,$sql);
   $count = mysqli_num_rows($qry);
   if($count >= 1){
         
         if( ($bank_name == NULL || $account_name == NULL || $account_no == NULL) && $update_option == 0 ){
                return json_encode(array( "status"=>101, "msg"=>"To continue, kindly update your profile..." ));
         }else{
                return json_encode(array( "status"=>111, "msg"=>"Good Standing" ));

         }
   }  
}





function user_login($email,$password){
   global $dbc;
   $email = secure_database($email);
   $password = secure_database($password);
   $hashpassword = md5($password);


   $sql = "SELECT * FROM `admin_users` WHERE `email`='$email' AND `password`='$hashpassword'";
   $query = mysqli_query($dbc,$sql);
   $count = mysqli_num_rows($query);
   if($count === 1){
      $row = mysqli_fetch_array($query);
      $fname = $row['fname'];
      $lname = $row['lname'];
      $phone = $row['phone'];
      $email = $row['email'];
      $unique_id = $row['unique_id'];
      $access_status = $row['access_status'];

      if($access_status != 1){
                return json_encode(array( "status"=>101, "msg"=>"Sorry, you currently do not have access. Contact Admin!" ));
      }else{
                return json_encode(array( 
                    "status"=>111, 
                    "user_id"=>$unique_id, 
                    "fname"=>$fname, 
                    "lname"=>$lname, 
                    "phone"=>$phone, 
                    "email"=>$email 
                  )
                 );

      }
    
   }else{
                return json_encode(array( "status"=>102, "msg"=>"Wrong username or password!" ));

   }
 

}




function admin_login($email,$password){
   global $dbc;
   $email = secure_database($email);
   $password = secure_database($password);
   $hashpassword = md5($password);

   $sql = "SELECT * FROM admin_users WHERE `email`='$email' AND `password`='$hashpassword' AND `role`=1";
   $query = mysqli_query($dbc,$sql);
   $count = mysqli_num_rows($query);
   if($count === 1){
      $row = mysqli_fetch_array($query);
      $fname = $row['fname'];
      $lname = $row['lname'];
      $phone = $row['phone'];
      $email = $row['email'];
      $unique_id = $row['unique_id'];
      $access_status = $row['access_status'];

      if($access_status != 1){
                return json_encode(array( "status"=>101, "msg"=>"Sorry, you currently do not have access. Contact Admin!" ));
      }else{
                return json_encode(array( 
                    "status"=>111, 
                    "user_id"=>$unique_id, 
                    "fname"=>$fname, 
                    "lname"=>$lname, 
                    "phone"=>$phone, 
                    "email"=>$email 
                  )
                 );

      }
    
   }else{
                return json_encode(array( "status"=>102, "msg"=>"Wrong username and password!" ));

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


/////////most important functions ends
