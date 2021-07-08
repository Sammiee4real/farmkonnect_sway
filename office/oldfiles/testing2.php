<?php
	require_once('config/database_functions.php');

// ["5498a3149a713aec6b989e7ca0fc28a7","12c0da50f19fffa0420028df0353b693","069f43195c1f92954fc98c3efbbe6919 "]
// ["5498a3149a713aec6b989e7ca0fc28a7","069f43195c1f92954fc98c3efbbe6919"]
// ["5498a3149a713aec6b989e7ca0fc28a7","069f43195c1f92954fc98c3efbbe6919"]
// ["36fac67e02e21e4cbf209c46a81aa552"]
// ["36fac67e02e21e4cbf209c46a81aa552","12c0da50f19fffa0420028df0353b693"]
// ["36fac67e02e21e4cbf209c46a81aa552","12c0da50f19fffa0420028df0353b693"]
// ["36fac67e02e21e4cbf209c46a81aa552","12c0da50f19fffa0420028df0353b693"]
// ["36fac67e02e21e4cbf209c46a81aa552","12c0da50f19fffa0420028df0353b693"]
// ["36fac67e02e21e4cbf209c46a81aa552","12c0da50f19fffa0420028df0353b693"]
// ["36fac67e02e21e4cbf209c46a81aa552","12c0da50f19fffa0420028df0353b693"]
// ["36fac67e02e21e4cbf209c46a81aa552","12c0da50f19fffa0420028df0353b693"]
// ["36fac67e02e21e4cbf209c46a81aa552","12c0da50f19fffa0420028df0353b693","5498a3149a713aec6b989e7ca0fc28a7 ","5498a3149a713aec6b989e7ca0fc28a7 "]
// ["12c0da50f19fffa0420028df0353b693"]
    $arr = json_decode(get_members_belonging_to_a_unit('069f43195c1f92954fc98c3efbbe6919'),true);
    if($arr['status'] != 111){
    		echo $arr['msg'];
    }else{
			foreach ($arr['msg'] as $key => $value) {
			echo $value['fname'].'<br>';
			}	 

    }


?>