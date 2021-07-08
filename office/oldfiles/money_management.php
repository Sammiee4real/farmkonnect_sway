<?php 
		if(isset($_POST['cmd_comput'])){
			$amount = $_POST['amount'];
			$tithe = 0.1 * $amount;
			$off = 0.05 * $amount;
			$transport = 0.09 * $amount;
			$misc = 0.18 * $amount;
			$givings = 0.15 * $amount;
			$feeding = 0.18 * $amount;
			$savings = 0.28 * $amount;

			$msg = "<h3>YOUR INCOME BREAKDOWN for &#8358;".number_format($amount)."</h3>";
			$msg .= "Total Income: &#8358;".number_format($amount).'<br>';
			$msg .= "Tithe: &#8358;".number_format($tithe).'<br>';
			$msg .= "Offerings: &#8358;".number_format($off).'<br>';
			$msg .= "Transportation: &#8358;".number_format($transport).'<br>';
			$msg .= "General Upkeep and Miscellanous: &#8358;".number_format($misc).'<br>';
			$msg .= "Giving to People: &#8358;".number_format($givings).'<br>';
			$msg .= "Feeding: &#8358;".number_format($feeding).'<br>';
			$msg .= "Savings: &#8358;".number_format($savings).'<br>';
		}
		
?>
<!DOCTYPE html>
<html>
<head>
	<title>Money Management</title>
</head>
<body>
<div class="alert alert-success">
	<h3>Parameters</h3>
	  Tithe: 10% <br>
	  Offerings: 5% <br>
	  Transportation: 9% <br>
	  General Upkeep and Miscellanous: 18% <br>
	  Giving to People: 15% <br>
	  Feeding: 18% <br>
	  Savings: 28% <br><hr>
	  <form method="post" action="">
	  <label>Enter Amount</label>
	  <input type="number" id="amount" name="amount">&nbsp;&nbsp;
	  <input type="submit" id="cmd_comput" name="cmd_comput"><hr>
	  </form>
	  <?php if(!empty($msg)){?>
	  	<!-- style="padding: 20px; background: black; color: white; height: 50px; width: 25%" -->
	  <div id="result" ><?php echo $msg; ?></div>
	  <?php } ?>

</div>



</body>
</html>