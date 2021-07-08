<?php  

  //       include('phpass/PasswordHash.php');
		// $hasher = new PasswordHash(8, false);
  //       // echo password_hash('devo');
  //       $password = 'devo';
  //       $hash = $hasher->HashPassword($password);
		// echo $hash;

// See the password_hash() example to see where this came from.
$hash = '$P$BEOrBFR/CvzSqmxfwoOcgZoTYu5Ucb0';

if (password_verify('Dev', $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}	


?>