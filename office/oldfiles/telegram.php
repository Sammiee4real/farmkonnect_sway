<?php   require_once("config/validations.php");
        //   echo '1614986733:AAGrnwiZt_VplJb711VboHpbr0g8fZtPzsc';
        //   echo "Bot Webhook Test";

        $path = "https://api.telegram.org/bot1614986733:AAGrnwiZt_VplJb711VboHpbr0g8fZtPzsc";
        $telegram_json = file_get_contents("php://input");
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatId = $update["message"]["chat"]["id"];
        $currentMessage = $update["message"]["text"];
        $chatStatus = get_one_row_by_id('chat_status_tbl','chat_id',$chatId);
        
        
        function defaultMessage(){
            $messageReply = "Welcome to OneFiveSix Credit.\n\n";
            $messageReply .= "What will you like to do?\n";
            $messageReply .= "Please reply with any of the options below\n";
            $messageReply .= "1. Register\n";
            $messageReply .= "2. Apply for a loan\n";
            $messageReply .= "3. View existing loans\n";
            $messageReply .= "4. Manual repayment\n";
            $messageReply .= "5. Contact us\n";
            $messageReply .= "6. FAQs\n";
            return urlencode($messageReply);
        }
        
        function updateChatStage($chatId,$status,$jso){
            global $dbc;
             $check_exist = check_record_by_one_param('chat_status_tbl','chat_id',$chatId);
             
             
             
             if($check_exist == false){
                  ///means the array is new
                        $arr = array();
                        $jsoo = json_encode($arr);
                        $sql_ins = "INSERT INTO `chat_status_tbl` SET `variable_json`='$jsoo', `chat_id`= '$chatId',`status`='$status',`date_added`=now()";
                        $query_ins = mysqli_query($dbc,$sql_ins);
             }else{
             
                    //means leave it, dont touch it
                 if($jso == ""){
                        
                        $sql_upll = "UPDATE `chat_status_tbl` SET `status`= '$status' WHERE `chat_id`='$chatId'";
                        $query_upll = mysqli_query($dbc,$sql_upll);
                     
                 }
                 
                 else if( empty($jso) ){
                        $jsone = json_encode($jso);
                        $sql_upll = "UPDATE `chat_status_tbl` SET `status`= '$status',`variable_json`='$jsone' WHERE `chat_id`='$chatId'";
                        $query_upll = mysqli_query($dbc,$sql_upll);
                 }
                 
                 else{
                     //means you edited the array
                        $jsone = json_encode($jso);
                        $sql_upll = "UPDATE `chat_status_tbl` SET `status`= '$status',`variable_json`='$jsone' WHERE `chat_id`='$chatId'";
                        $query_upll = mysqli_query($dbc,$sql_upll);
                     
                 }
            
                 
             }
        }
        

        function getAge($dob){

                $dob = date("Y-m-d",strtotime($dob));

                $dobObject = new DateTime($dob);
                $nowObject = new DateTime();

                $diff = $dobObject->diff($nowObject);

                return $diff->y;

        }

        
        ////get credit policy etc
        function displayLoanAmounts($user_phone){
            global $dbc;
            $min_amount_to_loan = 5000;
            $max_amount_to_loan = 50000;

            $check_exist = check_record_by_one_param('user','mobile_phone_number',$user_phone);
            $check_exist2 = check_record_by_one_param('existing_users','phone_1',$user_phone);
            $check_exist3 = check_record_by_one_param('existing_users','phone_2',$user_phone);
            // $check_exist4 = check_record_by_one_param('loans_tbl','client_phone',$user_phone);

             $get_loan_exist = "SELECT id FROM `loans_tbl` WHERE `client_phone`='$user_phone' AND `loan_status`=1";
             $query_running_loan = mysqli_query($dbc, $get_loan_exist);
             $num_running_loan = mysqli_num_rows($query_running_loan);
           

            if( $check_exist2 == false && $check_exist3 == false ){
                  ///means the array is new
                    return json_encode([
                            "status"=>105,
                            "msg"=>"Sorry, this record does not exist. Contact your Employer."
                    ]);
             }

            else if($check_exist == false){

                 return json_encode([
                            "status"=>107,
                            "msg"=>"Sorry, this record has not been onboarded."
                    ]);
            }

            else if($num_running_loan >= 1){

                  return json_encode([
                            "status"=>109,
                            "msg"=>"Sorry, you are currently on a loan."
                    ]);

            }
            else{
                //bear in mind that repayment happens as one-time in this case
                $count_loans = "SELECT id FROM `repayments` WHERE `client_phone`='$user_phone' AND `rep_status`=1";
                $qry_loans = mysqli_query($dbc,$count_loans);
                $count_loans = mysqli_num_rows($qry_loans);   

                ///get actual details of the client
                //$get_user_record = get_one_row_by_id('existing_users','mobile_phone_number',$user_phone);
                $user_record_sql = "SELECT * FROM `existing_users` WHERE (`phone_1`='$user_phone' OR `phone_2`='$user_phone')";
                $user_record_qry = mysqli_query($dbc,$user_record_sql);
                $get_user_record = mysqli_fetch_array($user_record_qry);   

                 $dob = $get_user_record['dob'];
                 $confirmation_status = $get_user_record['confirmation_status'];
                 $date_of_emp = $get_user_record['date_of_emp'];
                 $n_m_s = $get_user_record['n_m_s'];
                
                 // var_dump($n_m_s);

                $curdate = date('Y-m-d');
                $date_of_emp_in_days = (   strtotime($curdate) - strtotime( date('Y-m-d',strtotime($date_of_emp)) )  )  / (60 * 60 * 24);

                 // $age =  floor((time() - strtotime($dob)) / 31556926);
                 $age  = getAge($dob);

                ///extra conditions
                if($age < 21){

                         return json_encode([
                            "status"=>211,
                            "msg"=>"Sorry, you are too young to access a loan."
                    ]);

                }
                else if($age > 58){
                         return json_encode([
                            "status"=>581,
                            "msg"=>"Sorry, you are too old to access a loan."
                    ]);
                }

                else if($date_of_emp_in_days < 180){

                        return json_encode([
                        "status"=>180,
                        "msg"=>"Sorry, you are not up to 6 months in the organisation."
                        ]);


                }

                ///option default, has never taken 
                else if($count_loans < 1){
                    $actual_loan_amount = 5000;   

                      //////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount >= $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                   
                      return json_encode([
                    "status"=>111,
                    "msg"=>"Success 0.",
                    "loans_amount1"=>$option1,
                    "loans_amount2"=>$option2,
                    "loans_amount3"=>$actual_loan_amount
                    ]);
                    ///final result ends here     
                }

                //option 1
                else if( $count_loans == 1 ){
                    $actual_loan_amount = 0.1 * $n_m_s;   

                      //////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount >= $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                  
                     return json_encode([
                    "status"=>111,
                    "msg"=>"Success 1.",
                    "loans_amount1"=>$option1,
                    "loans_amount2"=>$option2,
                    "loans_amount3"=>$actual_loan_amount
                    ]);
                    ///final result ends here     
                }

                //option 2
                else if( $count_loans == 2 ){
                    $actual_loan_amount = 0.15 * $n_m_s;   

                      //////final result
                    // if($actual_loan_amount <= $min_amount_to_loan){
                    //    $actual_loan_amount = $min_amount_to_loan;
                    // }else if($actual_loan_amount >= $max_amount_to_loan){
                    //    $actual_loan_amount = $max_amount_to_loan;
                    // }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                   
                      return json_encode([
                    "status"=>111,
                    "msg"=>"Success 2.",
                    "loans_amount1"=>$option1,
                    "loans_amount2"=>$option2,
                    "loans_amount3"=>$actual_loan_amount
                    ]);
                    ///final result ends here     
                }

                //option 3
                else if( $count_loans == 3 ){
                    $actual_loan_amount = 0.35 * $n_m_s;      

                      //////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount > $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                     
                      return json_encode([
                    "status"=>111,
                    "msg"=>"Success 3.",
                    "loans_amount1"=>$option1,
                    "loans_amount2"=>$option2,
                    "loans_amount3"=>$actual_loan_amount
                    ]);
                    ///final result ends here  

                }

                 //option 4
                else if( $count_loans == 4 ){
                    $actual_loan_amount = 0.50 * $n_m_s;   

                      //////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount > $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                      
                       return json_encode([
                    "status"=>111,
                    "msg"=>"Success 4.",
                    "loans_amount1"=>$option1,
                    "loans_amount2"=>$option2,
                    "loans_amount3"=>$actual_loan_amount
                    ]);
                    ///final result ends here      

                }

                //option 5
                else if( $count_loans >= 5 ){
                    $actual_loan_amount = 50000;

                      //////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount > $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                  

                    return json_encode([
                    "status"=>111,
                    "msg"=>"Success 5.",
                    "loans_amount1"=>$option1,
                    "loans_amount2"=>$option2,
                    "loans_amount3"=>$actual_loan_amount
                    ]);
                    ///final result ends here

                }
                
            }
        }



        ////get credit policy etc
        function displayLoanAmounts2($user_phone,$loan_option){
            global $dbc;
            $min_amount_to_loan = 5000;
            $max_amount_to_loan = 50000;

            $check_exist = check_record_by_one_param('user','mobile_phone_number',$user_phone);
            $check_exist2 = check_record_by_one_param('existing_users','phone_1',$user_phone);
            $check_exist3 = check_record_by_one_param('existing_users','phone_2',$user_phone);
            // $check_exist4 = check_record_by_one_param('loans_tbl','client_phone',$user_phone);

             $get_loan_exist = "SELECT id FROM `loans_tbl` WHERE `client_phone`='$user_phone' AND `loan_status`=1";
             $query_running_loan = mysqli_query($dbc, $get_loan_exist);
             $num_running_loan = mysqli_num_rows($query_running_loan);
           

            if( $check_exist2 == false && $check_exist3 == false ){
                  ///means the array is new
                    return json_encode([
                            "status"=>105,
                            "msg"=>"Sorry, this record does not exist. Contact your Employer."
                    ]);
             }

            else if($check_exist == false){

                 return json_encode([
                            "status"=>107,
                            "msg"=>"Sorry, this record has not been onboarded."
                    ]);
            }

            else if($num_running_loan >= 1){

                  return json_encode([
                            "status"=>109,
                            "msg"=>"Sorry, you are currently on a loan."
                    ]);

            }
            else{
                //bear in mind that repayment happens as one-time in this case
                $count_loans = "SELECT id FROM `repayments` WHERE `client_phone`='$user_phone' AND `rep_status`=1";
                $qry_loans = mysqli_query($dbc,$count_loans);
                $count_loans = mysqli_num_rows($qry_loans);   

                ///get actual details of the client
                //$get_user_record = get_one_row_by_id('existing_users','mobile_phone_number',$user_phone);
                $repayment_sql = "SELECT * FROM `existing_users` WHERE (`phone_1`='$user_phone' OR `phone_2`='$user_phone')";
                $repayment_qry = mysqli_query($dbc,$repayment_sql);
                $get_user_record = mysqli_fetch_array($repayment_qry);   

                 $dob = $get_user_record['dob'];
                 $confirmation_status = $get_user_record['confirmation_status'];
                 $date_of_emp = $get_user_record['date_of_emp'];
                 $n_m_s = $get_user_record['n_m_s'];
                
                 // var_dump($n_m_s);

                $curdate = date('Y-m-d');
                $date_of_emp_in_days = (   strtotime($curdate) - strtotime( date('Y-m-d',strtotime($date_of_emp)) )  )  / (60 * 60 * 24);

                 // $age =  floor((time() - strtotime($dob)) / 31556926);
                 $age  = getAge($dob);

                ///extra conditions
                if($age < 21){

                         return json_encode([
                            "status"=>211,
                            "msg"=>"Sorry, you are too young to access a loan."
                    ]);

                }
                else if($age > 58){
                         return json_encode([
                            "status"=>581,
                            "msg"=>"Sorry, you are too old to access a loan."
                    ]);
                }

                else if($date_of_emp_in_days < 180){

                        return json_encode([
                        "status"=>180,
                        "msg"=>"Sorry, you are not up to 6 months in the organisation."
                        ]);


                }

                ///option default, has never taken 
                else if($count_loans < 1){
                    $actual_loan_amount = 5000;   

                      //////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount >= $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;

                    

                    if($loan_option == '1'){
                        $lloan_amount = $option1;
                      
                    }else if($loan_option == '2'){
                        $lloan_amount = $option2;
                      
                    }else if($loan_option == '3'){
                        $lloan_amount = $actual_loan_amount;
                       
                    }else{

                        return json_encode([
                        "status"=>113,
                        "msg"=>"Wrong option selected. choose either 1, 2 or 3.",
                        "loans_amount"=>$lloan_amount,
                        "loan_plus_interest"=>$loan_plus_interest
                        ]);

                    }


                    $loan_plus_interest = $lloan_amount + ( 0.2 * $lloan_amount );
                   
                    return json_encode([
                    "status"=>111,
                    "msg"=>"Success 0.",
                    "loans_amount"=>$lloan_amount,
                    "loan_plus_interest"=>$loan_plus_interest
                    ]);
                    ///final result ends here     
                }

                //option 1
                else if( $count_loans == 1 ){
                    $actual_loan_amount = 0.1 * $n_m_s;   

                      //////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount >= $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                  
                    
                    if($loan_option == '1'){
                        $lloan_amount = $option1;
                      
                    }else if($loan_option == '2'){
                        $lloan_amount = $option2;
                      
                    }else if($loan_option == '3'){
                        $lloan_amount = $actual_loan_amount;
                       
                    }else{

                        return json_encode([
                        "status"=>103,
                        "msg"=>"Wrong option selected. choose either 1, 2 or 3.",
                        "loans_amount"=>$lloan_amount,
                        "loan_plus_interest"=>$loan_plus_interest
                        ]);

                    }


                    $loan_plus_interest = $lloan_amount + ( 0.2 * $lloan_amount );
                   
                    return json_encode([
                    "status"=>111,
                    "msg"=>"Success 0.",
                    "loans_amount"=>$lloan_amount,
                    "loan_plus_interest"=>$loan_plus_interest
                    ]);
                    ///final result ends here   

                }

                //option 2
                else if( $count_loans == 2 ){
                    $actual_loan_amount = 0.15 * $n_m_s;   

                      ////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount >= $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                   
                     
                    if($loan_option == '1'){
                        $lloan_amount = $option1;
                      
                    }else if($loan_option == '2'){
                        $lloan_amount = $option2;
                      
                    }else if($loan_option == '3'){
                        $lloan_amount = $actual_loan_amount;
                       
                    }else{

                        return json_encode([
                        "status"=>123,
                        "msg"=>"Wrong option selected. choose either 1, 2 or 3.",
                        "loans_amount"=>$lloan_amount,
                        "loan_plus_interest"=>$loan_plus_interest
                        ]);

                    }


                    $loan_plus_interest = $lloan_amount + ( 0.2 * $lloan_amount );
                   
                    return json_encode([
                    "status"=>111,
                    "msg"=>"Success 2.",
                    "loans_amount"=>$lloan_amount,
                    "loan_plus_interest"=>$loan_plus_interest
                    ]);
                    ///final result ends here   


                }

                //option 3
                else if( $count_loans == 3 ){
                    $actual_loan_amount = 0.35 * $n_m_s;      

                      //////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount > $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                     
                   
                    if($loan_option == '1'){
                        $lloan_amount = $option1;
                      
                    }else if($loan_option == '2'){
                        $lloan_amount = $option2;
                      
                    }else if($loan_option == '3'){
                        $lloan_amount = $actual_loan_amount;
                       
                    }else{

                        return json_encode([
                        "status"=>133,
                        "msg"=>"Wrong option selected. choose either 1, 2 or 3.",
                        "loans_amount"=>$lloan_amount,
                        "loan_plus_interest"=>$loan_plus_interest
                        ]);

                    }


                    $loan_plus_interest = $lloan_amount + ( 0.2 * $lloan_amount );
                   
                    return json_encode([
                    "status"=>111,
                    "msg"=>"Success 3.",
                    "loans_amount"=>$lloan_amount,
                    "loan_plus_interest"=>$loan_plus_interest
                    ]);
                    ///final result ends here   



                }

                 //option 4
                else if( $count_loans == 4 ){
                    $actual_loan_amount = 0.50 * $n_m_s;   

                      //////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount > $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                      
                    
                    if($loan_option == '1'){
                        $lloan_amount = $option1;
                      
                    }else if($loan_option == '2'){
                        $lloan_amount = $option2;
                      
                    }else if($loan_option == '3'){
                        $lloan_amount = $actual_loan_amount;
                       
                    }else{

                        return json_encode([
                        "status"=>103,
                        "msg"=>"Wrong option selected. choose either 1, 2 or 3.",
                        "loans_amount"=>$lloan_amount,
                        "loan_plus_interest"=>$loan_plus_interest
                        ]);

                    }


                    $loan_plus_interest = $lloan_amount + ( 0.2 * $lloan_amount );
                   
                    return json_encode([
                    "status"=>111,
                    "msg"=>"Success 4.",
                    "loans_amount"=>$lloan_amount,
                    "loan_plus_interest"=>$loan_plus_interest
                    ]);
                    ///final result ends here        

                }

                //option 5
                else if( $count_loans >= 5 ){
                    $actual_loan_amount = 50000;

                      //////final result
                    if($actual_loan_amount <= $min_amount_to_loan){
                       $actual_loan_amount = $min_amount_to_loan;
                    }else if($actual_loan_amount > $max_amount_to_loan){
                       $actual_loan_amount = $max_amount_to_loan;
                    }

                    $option1 = 0.25 * $actual_loan_amount;
                    $option2 = 0.50 * $actual_loan_amount;
                  

                   
                    if($loan_option == '1'){
                        $lloan_amount = $option1;
                      
                    }else if($loan_option == '2'){
                        $lloan_amount = $option2;
                      
                    }else if($loan_option == '3'){
                        $lloan_amount = $actual_loan_amount;
                       
                    }else{

                        return json_encode([
                        "status"=>103,
                        "msg"=>"Wrong option selected. choose either 1, 2 or 3.",
                        "loans_amount"=>$lloan_amount,
                        "loan_plus_interest"=>$loan_plus_interest
                        ]);

                    }


                    $loan_plus_interest = $lloan_amount + ( 0.2 * $lloan_amount );
                   
                    return json_encode([
                    "status"=>111,
                    "msg"=>"Success 0.",
                    "loans_amount"=>$lloan_amount,
                    "loan_plus_interest"=>$loan_plus_interest
                    ]);
                    ///final result ends here   

                }
                
            }
        }



        // echo displayLoanAmounts('08168509044');
        
       //////////logic starts here:::check this logic later
       if(  $chatStatus['status'] === null   || strtolower($currentMessage) == 'hello' ){
            updateChatStage($chatId,'started',[]);
            $messageReply = defaultMessage();
            file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageReply);
            updateChatStage($chatId,'started',[]);
        }

       else if($chatStatus['status'] === "started"  && $currentMessage == '1'){
            $messageReply = "Thank you. \n";
            $messageReply .= "Please enter your mobile no provided to employer.\n";
            $messageRep = urlencode($messageReply);
            file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
            updateChatStage($chatId,'get_phone',"");
        }
        


       else if($chatStatus['status'] === "get_phone" && strtolower($currentMessage) != 'hello'){
            $start_reg_with_phone = start_reg_with_phone($currentMessage);
            $dec = json_decode($start_reg_with_phone,true);
            
            if(  $dec['status'] == 111  ){
                 $messageReply = "Thank you. \n";
                 $messageReply .= "Enter your BVN.\n";
                 $messageRep = urlencode($messageReply);                
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                
                //get_variable
                $variable_arr = json_decode($chatStatus['variable_json'],true);
                $add_arr = array(
                "phone"=>$currentMessage
                );
                array_push($variable_arr,$add_arr);
                
                //get variable end
                 updateChatStage($chatId,'get_bvn',$variable_arr);
                 
            }else{
                 $messageRep = $dec['msg'];
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'get_phone',"");
            }
                    
        }
        
        
        
        
     else if($chatStatus['status'] === "get_bvn" && strtolower($currentMessage) != 'hello'){
            $new_bvn_validate = new_bvn_validate( $currentMessage , json_decode($chatStatus['variable_json'],true)[0]['phone']  );
            $dec = json_decode($new_bvn_validate,true);
            if(  $dec['status'] == 111  ){
                 $messageReply = "Thank you. \n";
                 $messageReply .= "Enter your email address.\n";
                 $messageRep = urlencode($messageReply);                
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 
                //get_variable
                $variable_arr = json_decode($chatStatus['variable_json'],true);
                $add_arr = array(
                "bvn"=>$currentMessage
                );
                array_push($variable_arr,$add_arr);
              
                //get variable end
                updateChatStage($chatId,'get_email',$variable_arr);
          
            }else{
                 $messageRep = $dec['msg'];
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'get_bvn',"");
            }
        }
       
     
       
      else if($chatStatus['status'] === "get_email" && strtolower($currentMessage) != 'hello'){
            $validate_email =  validate_email($currentMessage);
            $dec = json_decode($validate_email,true);
            if(  $dec['status'] == 111  ){
                 $messageReply = "Thank you. \n";
                 $messageReply .= "Please enter your 11 digit salary account no.\n";
                 $messageRep = urlencode($messageReply);                
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                
                //get_variable
                $variable_arr = json_decode($chatStatus['variable_json'],true);
                $add_arr = array(
                "email"=>$currentMessage
                );
                array_push($variable_arr,$add_arr);
              
                //get variable end     
                updateChatStage($chatId,'get_account_no',$variable_arr);
            
                
                
            }else{
                 $messageRep = $dec['msg'];
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'get_email',"");
            }
         }
         
         
     else if($chatStatus['status'] === "get_account_no" && strtolower($currentMessage) != 'hello'){
            $new_accountno_validate =  new_accountno_validate($currentMessage,json_decode($chatStatus['variable_json'],true)[0]['phone'],json_decode($chatStatus['variable_json'],true)[1]['bvn'] );
            $dec = json_decode($new_accountno_validate,true);
            if(  $dec['status'] == 111  ){
                
                $user_det = user_reg_details($currentMessage,json_decode($chatStatus['variable_json'],true)[0]['phone'],json_decode($chatStatus['variable_json'],true)[1]['bvn'],json_decode($chatStatus['variable_json'],true)[2]['email']);
                $user_dec = json_decode($user_det,true);
                $fullname = $user_dec['fullname'];
                $phone = $user_dec['phone'];
                $dob = $user_dec['dob'];
                $bankname = $user_dec['bankname'];
                $acctno = $user_dec['acctno'];
                $email = $user_dec['email'];
                $bvn = $user_dec['bvn'];
                
                $messageReply = "Thank you. \n";
                $messageReply .= "Please confirm your details below.\n";
                $messageReply .= "Full name:    ".$fullname."\n";
                $messageReply .= "BVN:      ".$bvn." \n";
                $messageReply .= "Phone no: ".$phone."\n";
                $messageReply .= "DOB:      ".$dob."\n";
                $messageReply .= "Email:        ".$email."\n";
                $messageReply .= "Bank name:    ".$bankname."\n";
                $messageReply .= "Bank a/c no:  ".$acctno."\n\n";
                $messageReply .= "Enter 1 to confirm details\n";
                $messageReply .= "Enter 2 to return to main menu\n";
                // $messageReply .= "Enter 're' for incorrect details\n";
                $messageReply .= "Kindly Note: If any of the above information is incorrect, send a mail to help@156credit.com\n";
                
                $messageRep = urlencode($messageReply);
                file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                
                //get_variable
                $variable_arr = json_decode($chatStatus['variable_json'],true);
                $add_arr = array(
                "account_no"=>$currentMessage
                );
                array_push($variable_arr,$add_arr);
               
                //get variable end
                
                updateChatStage($chatId,'confirm_user_details',$variable_arr);
                 
                 
            }else{
                 $messageRep = $dec['msg'];
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'get_account_no',"");
            }
         }
         
         
         ///send otp here
     else if($chatStatus['status'] === "confirm_user_details"  && $currentMessage == '1'){
                
                $send_otp =  send_otp(json_decode($chatStatus['variable_json'],true)[0]['phone'],json_decode($chatStatus['variable_json'],true)[2]['email']);
                $dec = json_decode($send_otp,true);
                if(  $dec['status'] == 111  ){
                    $messageReply = "Enter OTP sent to your phone number and email address.\n";
                    $messageRep = urlencode($messageReply);                
                    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                    updateChatStage($chatId,'get_otp',"");
                }else{
                    ///most likely will not run at all
                    $messageRep = $dec['msg'];
                    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                    updateChatStage($chatId,'confirm_user_details',"");
                }
        
        }
        
      
      ///enter otp
    else if($chatStatus['status'] === "get_otp"  && strtolower($currentMessage) !== 'hello'){
                $verify_otp =  verify_otp($currentMessage,json_decode($chatStatus['variable_json'],true)[0]['phone']);
                $dec = json_decode($verify_otp,true);
                if(  $dec['status'] == 111  ){
                    
                    $user_registration_version2 = user_registration_version2(json_decode($chatStatus['variable_json'],true)[0]['phone'], json_decode($chatStatus['variable_json'],true)[2]['email'] );
                    $dec_reg = json_decode($user_registration_version2,true);
                    if($dec_reg['status'] == 111){
                        
                        $messageReply = "Congratulations. Registration complete.\n";
                        $messageReply .= "Enter 'hello' to return to main menu.\n";
                        $messageRep = urlencode($messageReply);                
                        file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                        updateChatStage($chatId,'started',[]);
                    
                        
                    }else{
                    
                        $messageRep = $dec_reg['msg'];
                        file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                        updateChatStage($chatId,'get_otp',"");
                    
                    }
                    
               
                }else{
                    ///when wront otp is entered
                    $messageRep = $dec['msg'];
                    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                    updateChatStage($chatId,'get_otp',"");
                }
        
        }
        

    
    
        ///starting afresh
     else if($chatStatus['status'] === "confirm_user_details"  &&  $currentMessage == '2'){
                updateChatStage($chatId,'started');
                $messageReply = defaultMessage();
                file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageReply);
                updateChatStage($chatId,'started',"");
        }
        
        if($chatStatus['status'] === "confirm_user_details"  && $currentMessage == '3'){
                 $messageReply = "Unfortunately, we are unable to complete registration. Please contact your employer. \n";
                 $messageReply .= "Enter 2 to return to main menu.\n";
                 $messageRep = urlencode($messageReply);                
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'confirm_user_details',"");
        }
        
        
        
        
        
      //  }
      
      
      
      ///view existing loans
     else if($chatStatus['status'] === "started" && $currentMessage == '3' ){
            $messageReply = "Thank you.\n";
            $messageReply .= "Please enter your registered phone no\n";
            $messageRep = urlencode($messageReply);
            file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);   
            updateChatStage($chatId,'get_phone_4_loan_status',"");
        }
      
    else if($chatStatus['status'] === "get_phone_4_loan_status"  && strtolower($currentMessage) != 'hello'){
             $view_running_loan =  view_running_loan($currentMessage);
             $dec = json_decode($view_running_loan,true);
             if($dec['status'] == 111){
                $fullname = $dec['first_name'].' '.$dec['last_name'];
                $loan_amountf = $dec['loan_amountf'];
                $expected_repaymentf = $dec['expected_repaymentf'];
                $tenure_days = $dec['tenure_days'];
                $date_applied = $dec['date_applied'];
                $date_approved = $dec['date_approved'];
                $interest_rate = $dec['interest_rate'];
                
               
                $messageReply = "Your loan details are below:\n";
                $messageReply .= "Fullname: ".$fullname." \n";
                $messageReply .= "Loan Amount: N".$loan_amountf." \n";
                $messageReply .= "Expected Repayment: N".$expected_repaymentf." \n";
                $messageReply .= "Tenure: ".$tenure_days." days \n";
                $messageReply .= "Interest Rate: ".$interest_rate."%  \n";
                $messageReply .= "Date Applied: ".date('F-d-Y',strtotime($date_applied))."\n";
                $messageReply .= "Date Approved: ".date('F-d-Y',strtotime($date_approved))." \n";
                $messageRep = urlencode($messageReply);
                file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);   
                updateChatStage($chatId,'started',[]);
                 
             }else{
                 $messageRep = $dec['msg'];
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'get_phone_4_loan_status',"");
                 
             }
         } 

         //contact us
         else if(   $chatStatus['status'] === "started"  &&  $currentMessage == '5'){
            $messageReply = "Please contact customer service at \n";
            $messageReply .= "+234 123456\n";
            $messageRep = urlencode($messageReply);
            file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);   
            updateChatStage($chatId,'started',[]);
        }



        //FAQs
        else if(   $chatStatus['status'] === "started"  &&  $currentMessage == '6'){
            $messageReply = "Please check out our FAQs. Details are on our website\n";
            $messageReply .= "https://156credit.com\n";
            $messageRep = urlencode($messageReply);
            file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);  
            updateChatStage($chatId,'started',[]);
        }


         ////////LOANS LOGIC


         //////last resort
         else if( ( $chatStatus['status'] === "started" ||  $chatStatus === null)
                 && $currentMessage != '1'
                 && $currentMessage != '2'
                 && $currentMessage != '3'
                 && $currentMessage != '4'
                 && $currentMessage != '5'
                 && $currentMessage != '6'
                 && strtolower($currentMessage) != 'hello' ){
            updateChatStage($chatId,'started',[]);
            $messageReply = "Please enter a valid option";
            file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageReply);
            updateChatStage($chatId,'started',[]);
         } 
         
         //loan application process
        else if($chatStatus['status'] === "started" && $currentMessage == '2' ){
        $messageReply = "Thank you.\n";
        $messageReply .= "Please enter your registered phone no\n";
        $messageRep = urlencode($messageReply);
        file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);   
        updateChatStage($chatId,'get_phone_loan',"");
        }
         
        //loan thing
        else if($chatStatus['status'] === "get_phone_loan" && strtolower($currentMessage) != 'hello'){
            $displayLoanAmounts = displayLoanAmounts($currentMessage);
            $dec = json_decode($displayLoanAmounts,true);
            
            if(  $dec['status'] == 111  ){
                 $loan_amount1 = $dec['loans_amount1'];
                 $loan_amount2 = $dec['loans_amount2'];
                 $loan_amount3 = $dec['loans_amount3'];
                 $messageReply = "How much do you need today?.\n";
                 $messageReply .= "1. N".number_format($loan_amount1)."\n";
                 $messageReply .= "2. N".number_format($loan_amount2)."\n";
                 $messageReply .= "3. N".number_format($loan_amount3)."\n";
                 $messageRep = urlencode($messageReply);                
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                
                //get_variable
                $variable_arr = json_decode($chatStatus['variable_json'],true);
                $add_arr = array(
                "phone"=>$currentMessage
                );
                array_push($variable_arr,$add_arr);
                
                //get variable end
                 updateChatStage($chatId,'get_loan_confirmation_dets',$variable_arr);
                 
            }else{
                 $messageRep = $dec['msg'];
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'get_phone_loan',"");
            }
                    
        }
        
         
        else if($chatStatus['status'] === "get_loan_confirmation_dets" && strtolower($currentMessage) != 'hello'){
            $phone =  json_decode($chatStatus['variable_json'],true)[0]['phone'];
            $displayLoanAmounts = displayLoanAmounts2($phone,$currentMessage);
            $dec = json_decode($displayLoanAmounts,true);
            
            if(  $dec['status'] == 111  ){


                 $loans_amount = $dec['loans_amount'];
                 $loan_plus_interest = $dec['loan_plus_interest'];
           
                 $messageReply = "Thank you. You are applying for a loan of N".number_format($loans_amount)." and will repay N".number_format($loan_plus_interest)." at your next salary date. \nDo you accept? Type 1 for Yes and 2 for No.\n";
                 $messageReply .= "1. Yes \n";
                 $messageReply .= "2. No \n";
                 $messageRep = urlencode($messageReply);                
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                
                //get_variable
                $variable_arr = json_decode($chatStatus['variable_json'],true);
                $add_arr = array(
                "loan_amount"=>$loans_amount
                );
                array_push($variable_arr,$add_arr);
                
                //get variable end
                 updateChatStage($chatId,'get_loan_terms_n_conditions',$variable_arr);
                 
            }else{
                 $messageRep = $dec['msg'];
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'get_loan_confirmation_dets',"");
            }
                    
        }


          else if($chatStatus['status'] === "get_loan_terms_n_conditions" && strtolower($currentMessage) != 'hello'){
           
            if(  $currentMessage == '1'  ){
               
                
           
                 $messageReply = "By clicking (1) 'yes', you have accepted our terms and conditions below.\n";
                 $messageReply .= "https://156credit.com/loan_terms_conditions.\n";
                 $messageReply .= "1. Yes \n";
                 $messageReply .= "2. No \n";
                 $messageRep = urlencode($messageReply);                
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                
                //get_variable
                
                
                //get variable end
                 updateChatStage($chatId,'get_confirm_loan_terms_n_conditions',"");
                 
            }
            else if( $currentMessage == '2'){

                     $messageRep = "Thank you, come back again";
                    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                    updateChatStage($chatId,'get_loan_terms_n_conditions',"");
                
            }

            else{
                 $messageRep = "Please choose a valid option. 1 for Yes and 2 for No";
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'get_loan_terms_n_conditions',"");
            }
                    
        }



     else if($chatStatus['status'] === "get_confirm_loan_terms_n_conditions" && strtolower($currentMessage) != 'hello'){

            $phone =  json_decode($chatStatus['variable_json'],true)[0]['phone'];
            $loan_amount =  json_decode($chatStatus['variable_json'],true)[1]['loan_amount'];
            $get_loan_info =  get_one_row_by_id('user','mobile_phone_number',$phone);
            $acctno =    $get_loan_info['acctno'];
            $bankname =  $get_loan_info['bankname'];
           
            if(  $currentMessage == '1'  ){
           
                 $messageReply = "  N".number_format($loan_amount)." will be disbursed to your ".$bankname." account: ".$acctno.". \n";
                 $messageReply .= "1. Yes \n";
                 $messageReply .= "2. No \n";
                 $messageRep = urlencode($messageReply);                
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 
                //get variable end
                 updateChatStage($chatId,'get_otp_for_loan',"");
                 
            }
            else if( $currentMessage == '2'){

                     $messageRep = "Thank you, come back again";
                    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                    updateChatStage($chatId,'get_confirm_loan_terms_n_conditions',"");
                
            }

            else{
                 $messageRep = "Please choose a valid option. 1 for Yes and 2 for No";
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'get_confirm_loan_terms_n_conditions',"");
            }
                    
        }



    else if($chatStatus['status'] === "get_otp_for_loan" && strtolower($currentMessage) != 'hello'){

            $phone =  json_decode($chatStatus['variable_json'],true)[0]['phone'];
            $send_otpv2 = send_otpv2($phone);
            $dec = json_decode($send_otpv2,true);
            
           
            if(  $dec['status'] == 111  ){
                
                if($currentMessage == '1'){

                    $get_user_info =  get_one_row_by_id('user','mobile_phone_number',$phone);
                    $email =  $get_user_info['email_address'];

                    $messageReply = "Enter OTP sent to your phone no:".$phone." and email address: ".$email."\n";
                    $messageRep = urlencode($messageReply);                
                    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);

                    //get variable end
                    updateChatStage($chatId,'enter_otp_for_loan',"");

                }else if($currentMessage == '2'){


                    $messageRep = "Thank you, come back again";
                    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                    updateChatStage($chatId,'get_otp_for_loan',"");

                }else{

                     $messageRep = "Please choose a valid option. 1 for Yes and 2 for Nooption";
                    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                    updateChatStage($chatId,'get_otp_for_loan',"");
                }
                 
            }else{
                 $messageRep = "Thank you, come back again";
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'get_otp_for_loan',"");
            }
                    
        }



    else if($chatStatus['status'] === "enter_otp_for_loan" && strtolower($currentMessage) != 'hello'){

            $phone =  json_decode($chatStatus['variable_json'],true)[0]['phone'];
            $get_user_info =  get_one_row_by_id('user','mobile_phone_number',$phone);
            $email =  $get_user_info['email_address'];
          
            $verify_otp =  verify_otp($currentMessage,$phone);
            $dec = json_decode($verify_otp,true);
           
            if(  $dec['status'] == 111  ){
                 $messageReply = "Disbursment happens with the right otp entered here\n";
                 $messageRep = urlencode($messageReply);                
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 
                //get variable end
                 // updateChatStage($chatId,'started',[]);
                 updateChatStage($chatId,'enter_otp_for_loan',"");
                 
            }else{
                 $messageRep =   $dec['msg'];
                 file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);
                 updateChatStage($chatId,'enter_otp_for_loan',"");
            }
                    
        }



        /////this will most likely not run now
         else{

         }



        

        
      
     

       
       
       
       
       
///start a loan application
// else if($chatStatus['status'] === "started" && $currentMessage == '2' ){
//     $messageReply = "Thank you.\n";
//     $messageReply .= "Please enter your registered phone no\n";
//     $messageRep = urlencode($messageReply);
//     file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageRep);   
//     updateChatStage($chatId,'get_phone_loan',"");
// }

//      else if($currentMessage == '3'){
//             $messageReply = "Great...check your existing loans.";
//             file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageReply);   
//         }

//         else if($currentMessage == '4'){
//             $messageReply = "Great...make a manual repayment";
//             file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$messageReply);   
//         }

//      $sql = "INSERT INTO `telegram_webhook_tbl` SET `chat_json`='$telegram_json'";
//      $query = mysqli_query($dbc, $sql);
        //////////logic ends here


?>