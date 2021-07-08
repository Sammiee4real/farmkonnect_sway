<?php
$table = "";
$app_name = 'CHURCHWORLDV1';
require_once("db_connect.php");
require_once("config.php");
// require_once("generic_functions.php");
global $dbc;
global $project_base_path;



////////////////////MY NEW GENERIC FUNCTIONS 07-JULY-2021 STARTS

function verify_password_link($passcode){
    global $dbc;
    global $project_base_path;
    $table = 'reset_password';
    $link_in_db = $project_base_path.'/change_password?passcode='.$passcode;
    $check_expiry = check_record_by_two_params($table,'link_code',$link_in_db,'expiration_status',1);
    $check_exist = check_record_by_one_param($table,'link_code',$link_in_db);


  if($passcode == ""){
        //means expiration has expired
       return  json_encode(["status"=>108, "msg"=>"Code not found"]);
    }

   else if($check_expiry){
        //means expiration has expired
       return  json_encode(["status"=>108, "msg"=>"This link has expired"]);
    }
    else if(!$check_exist){
       return  json_encode(["status"=>102, "msg"=>"This link does not exist"]);
    
    }
    else{
       return  json_encode(["status"=>111, "msg"=>"This link is good"]);

    }

}

function confirm_password_change($passcode,$password,$cpassword){
    global $dbc;
    global $project_base_path;
    $link_in_db = $project_base_path.'/change_password?passcode='.$passcode;
    $table = 'reset_password';
    $table2 = 'users';

    if($password != $cpassword){
       return  json_encode(["status"=>108, "msg"=>"Pasword mismatch found"]);
    }

    if($password  == "" || $cpassword == ""){
       return  json_encode(["status"=>108, "msg"=>"Empty record found"]);
    }


    $hashpassword = md5($password);
    $user_id = explode('_',$passcode)[0];

    $update_reset_pass_link  = "UPDATE `$table` SET `expiration_status`=1 WHERE `link_code`='$link_in_db'";
    $qry_update_reset_pass_link = mysqli_query($dbc,$update_reset_pass_link);

    $update_pass = "UPDATE `$table2` SET `password`='$hashpassword' WHERE `unique_id`='$user_id'";
    $qry_update_pass = mysqli_query($dbc,$update_pass);

    if($qry_update_pass == true && $qry_update_reset_pass_link == true){
        //means expiration has expired
       return  json_encode(["status"=>111, "msg"=>"success"]);
    }
    else{
       return  json_encode(["status"=>108, "msg"=>"Server error"]);
    }

}

function password_reset($email){
    global $dbc;
    global $project_base_path;
    $table = 'reset_password';
     $user_details = get_one_row_from_one_table_by_id('users','email',$email,'date_created');
     if($user_details == null){
       return  json_encode(["status"=>101, "msg"=>"This record does not Exists"]);
     }

    $uid = $user_details['unique_id'];
    $passgener = unique_id_generator(rand(99999999,11111111));
    //means there is a record sent to mail already
    $check = check_record_by_two_params($table,'email',$email,'expiration_status',0);
    if($check){
        $rand_val = rand(1111111,9999999);
        $actual_link = $project_base_path.'/change_password?passcode='.$uid.'_'.$passgener.'_'.$rand_val;
        //do no insertion/ but update
       $update = "UPDATE `reset_password` SET `link_code`='$actual_link' WHERE `email`='$email'";
       $qryup = mysqli_query($dbc,$update);
    }else{
        //insertion
        $rand_val = rand(1111111,9999999);
        $actual_link = $project_base_path.'/change_password?passcode='.$uid.'_'.$passgener.'_'.$rand_val;
        $unique_id = unique_id_generator($email.$rand_val);
        $insert = "INSERT INTO `reset_password` SET `link_code`='$actual_link',`unique_id`='$unique_id',`email`='$email'";
        $qry_insert = mysqli_query($dbc,$insert);
    }

        $email_subject = 'Password Reset Link';
        $content = '<p>Please click the link below to reset your password</p>';
        $content .= '<p>'.$actual_link.'</p>';
        $content .= 'Thank you';
        if(email_function($email, $email_subject, $content)){
          return json_encode(array("status"=>111,"msg"=>"Password reset link was sent to your inbox, check spam too."));
        }else{
          return json_encode(array("status"=>107, "msg"=>"Password reset link not sent"));
        }

}


function insert_into_db($table,$data,$param,$validate_value){
  global $dbc;
  $validate_value = secure_database($validate_value);
  $param = secure_database($param);
  $table = secure_database($table);
  $emptyfound = 0;
  $emptyfound_arr = [];
  $check = check_record_by_one_param($table,$param,$validate_value);
  
  if($check === true){
    return  json_encode(["status"=>"0", "msg"=>"This Record Exists"]);
  }
  else{
   if( is_array($data) && !empty($data) ){
      $unique_id = unique_id_generator($validate_value.md5(uniqid()));
     $sql = "INSERT INTO `$table` SET  `unique_id` = '$unique_id',";
     $sql .= "`date_added` = now(), ";
     //$sql .= "`privilege` = '1', ";
        for($i = 0; $i < count($data); $i++){
            $each_data = $data[$i];
            
            if($_POST[$each_data] == ""  ){
              $emptyfound++;
              $emptyfound_arr[] = $each_data;
            }


            if($i ==  (count($data) - 1)  ){
                 $sql .= " $data[$i] = '$_POST[$each_data]' ";
              }else{
                if($data[$i] === "password"){
                $enc_password = md5($_POST[$data[$i]]); 
                $sql .= " $data[$i] = '$enc_password' ,";
                }else{
                $sql .= " $data[$i] = '$_POST[$each_data]' ,";
                } 
            }

        }
    
      
      if($emptyfound > 0){
          return json_encode(["status"=>"100", "msg"=>"Empty Field(s)","details"=>$emptyfound_arr]);
      } 
       else{
        $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        if($query){
          return json_encode(["status"=>"111", "msg"=>"success"]);
        }else{
          return json_encode(["status"=>"102", "msg"=>"db_error"]);
        }

      }  


    }
    else{
      return json_encode(["status"=>"100", "msg"=>"error"]);
    }

  } 

}


function update_data_by_a_param($table,$data,$conditional_param,$conditional_value){
  global $dbc;
  $emptyfound = 0;
  $emptyfound_arr = [];

  if( is_array($data) && !empty($data) ){
   $sql = "UPDATE `$table` SET ";
      for($i = 0; $i < count($data); $i++){
          $each_data = $data[$i];

           if($_POST[$each_data] == ""  ){
              $emptyfound++;
              $emptyfound_arr[] = $each_data;
           }


          if($i ==  (count($data) - 1)  ){
            $sql .= " $data[$i] = '$_POST[$each_data]' ";
          }else{
            $sql .= " $data[$i] = '$_POST[$each_data]' ,";
          }

      }

    $sql .= "WHERE `$conditional_param` = '$conditional_value'";

       

    if($emptyfound > 0){
            return json_encode(["status"=>"103", "msg"=>"Empty field(s) were found<br>".json_encode($emptyfound_arr) ]);
    }else{
            $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
            if($query){
            return json_encode(["status"=>"111", "msg"=>"success"]);
            }else{
            return json_encode(["status"=>"102", "msg"=>"db_error"]);
            }
    }

  
  
  }
  else{
    return json_encode(["status"=>"106", "msg"=>"error"]);
  }

}


function update_data($table, $data,$conditional_param,$conditional_value_array){
  global $dbc;
  if( count($conditional_value_array) === 0  ){
      return json_encode(["status"=>"102", "msg"=>"no condition found"]);
  }


  if( is_array($data) && !empty($data) ){
   $sql = "UPDATE `$table` SET ";
      for($i = 0; $i < count($data); $i++){
          $each_data = $data[$i];
          if($i ==  (count($data) - 1)  ){
            $sql .= " $data[$i] = '$_POST[$each_data]' ";
          }else{
            $sql .= " $data[$i] = '$_POST[$each_data]' ,";
          }

      }

    $sql .= "WHERE `$conditional_param` = '$conditional_value'";
  
    $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    if($query){
       return json_encode(["status"=>"111", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"102", "msg"=>"db_error"]);
    }
  }
  else{
    return json_encode(["status"=>"106", "msg"=>"error"]);
  }
}

function delete_old_image($table,$path_name,$unique_id){
     global $dbc;
     $sql = "SELECT * FROM `$table` WHERE `id`='$unique_id'";
     $query = mysqli_query($dbc, $sql);
     $row = mysqli_fetch_array($query);
     $img_url = $row[$path_name];
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


// function view_a_record(){
//     global $dbc;
// }

// function view_many_records(){
//     global $dbc;
// }


///////////////////MY NEW GENERIC FUNCTIONS 07-JULY-2021 ENDS

function in_array_all($needles, $haystack) {
   return empty(array_diff($needles, $haystack));
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


///for the user
function user_signup($fname,$lname,$email,$phone,$password,$cpassword){
        global $dbc;
        $table = 'users';
        $fname = secure_database($fname);
        $lname = secure_database($lname);
        $email = secure_database($email);
        $phone = secure_database($phone);
        $password = secure_database($password);
        $cpassword = secure_database($cpassword);
        $hashpassword = md5($password);
        $role = '6253e1b3e7d39816a2be7de22e9e6h51';
        $check_exist = check_record_by_one_param($table,'email',$email);
        $check_exist_phone = check_record_by_one_param($table,'phone',$phone);

        if($check_exist){
                return json_encode(array( "status"=>109, "msg"=>"This Email address exists" ));
         }
        else if($check_exist_phone){
                return json_encode(array( "status"=>109, "msg"=>"This Phone number exists" ));
         }
         else if($password != $cpassword){
                return json_encode(array( "status"=>109, "msg"=>"Password mismatch found" ));
         }
         else{

            if( $fname == "" || $lname == "" || $email == "" || $phone == "" || $password == "" || $cpassword == ""){
                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));
                }

                else{
                $unique_id = unique_id_generator($fname.$lname.$phone);
                $sql = "INSERT INTO `users` SET
                `unique_id` = '$unique_id',
                `fname` = '$fname',
                `lname` = '$lname',
                `phone` = '$phone',
                `email` = '$email',
                `role` = '$role',
                `password` = '$hashpassword',
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


   $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$hashpassword'";
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

/////////most important functions ends


////////////GENERIC FUNCTIONS BELOW
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
