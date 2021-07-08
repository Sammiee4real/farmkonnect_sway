<?php session_start();
     include('database_functions.php');
     if(!isset($_SESSION['adminid'])){
        header('location: index');
      }
     $uid = $_SESSION['adminid'];
     $user_details = get_one_row_from_one_table_by_id('admin_users','unique_id',$uid,'date_created');
     $first_name = $user_details['fname'];
     $last_name = $user_details['lname'];
     $fullname = $first_name.' '.$last_name;
     $email = $user_details['email'];
     $bank_name = $user_details['bank_name'];
     $account_name = $user_details['account_name'];
     $account_no = $user_details['account_no'];
     $bvn = $user_details['bvn'];
     $img_url = $user_details['img_url'];

     //////////pagination script starts
		if (isset($_GET['pageno'])) {
		$pageno = $_GET['pageno'];
		} else {
		$pageno = 1;
		}
		$no_per_page = 10;
		$offset = ($pageno-1) * $no_per_page; 
		/////////pagination script ends
?>