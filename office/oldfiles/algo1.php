<?php
  
  ///get multiples of 5
  ///soln1
  function multiplesOfFive($arr){
     for($i = 0; $i < count($arr); $i++ ){
     		echo $arr[$i] % 5 == 0 ? $arr[$i]."<br>" : false ;
     }
  }
   

?>