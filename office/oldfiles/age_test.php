<?php 

// function getAge($date) {
//     return intval(date('Y', time() - strtotime($date))) - 1970;
// }
function getAge($dob){

        $dob = date("Y-m-d",strtotime($dob));

        $dobObject = new DateTime($dob);
        $nowObject = new DateTime();

        $diff = $dobObject->diff($nowObject);

        return $diff->y;

}

// echo getAge('2005-10-22').'<br>';
// echo getAge('14-10-1973').'<br>';
// echo getAge('09-04-20').'<br>';
// echo getAge('1/1/2018');


$curdate = date('Y-m-d');
$date_of_emp_in_days = (   strtotime($curdate) - strtotime( date('Y-m-d',strtotime('01-03-2021')) )  )  / (60 * 60 * 24);
echo $date_of_emp_in_days;

?>