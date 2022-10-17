<?php 
//$cash = 0.1; 
//$wallet="";
if(isset($_POST['submit'])) {
	//var_dump($_POST['wallet']);


// Authorize 
$accountNumber = 'P1081858280'; //Your account number in the Payeer system 
$apiId = '1758884996'; // api-user id, issued when adding API 
$apiKey = 'ylTBbXQfZZJfcBcV'; //api user secret key 

require_once('cpayeer.php');
$payeer = new CPayeer($accountNumber, $apiId, $apiKey);
if ($payeer->isAuth())
{
	echo "You are successfully logged in <br>";
}
else
{
	echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
}

// Check if the account exists
if ($payeer->isAuth())
{
	if($payeer->checkUser(array(
		//'user' => 'P1081856806',
		//'user' =>'param_ACCOUNT_NUMBER',
		//this command alow us to get value from input form html and we dont need user to access the script or open and modifier we need user to stay away from the script
		//if user access the script that's probleme , can access all money from account because here the api key id account api id who has api key and api id and id account can stule all your money
   
		    //'user' =>($_POST['wallet']), //this is the command it's alow us to get value directly from input form to the arrow function we hope it work good 
   
             'user' => $_POST['wallet'],//and this option two it's work with arrow function and input html
 
	)))
	{
		echo 'payeer user account id exists successfully !';


		// If exists, make a payment here
		if ($payeer->isAuth())
		{
			$initOutput = $payeer->initOutput(array(
				'ps' => '1136053',
				//'sumIn' => 1,
				'curIn' => 'RUB',
				//'sumOut' => $cash,
				//'sumOut' => $cash,
				//'sumOut' => $_POST['cash'],
				'sumOut' => ($_POST['cash']),
				'curOut' => 'RUB',
				//'param_ACCOUNT_NUMBER' => '123'
				//'param_ACCOUNT_NUMBER' => 'wallet'
				//'user' => 'wallet',
			));

			if ($initOutput)
			{
				$historyId = $payeer->output();
				if ($historyId > 0)
				{
					echo "Payout successful";


				}
				else
				{
					echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
					echo "Payout failed balance unavailable at the moment  <br> please come back later   ";
				}
			}
			else
			{
				echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
				echo "low value check option";
			}
		}
		else
		{
			echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
			echo "No authentication";
		}

		// Finished making the payout
	}
	else
	{
		echo 'payeer id account is not found <br> please insert payeer id or wallet account...?<br>p10000000';
	}
}
else
{
	echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
}


}
//<?=$cash?//>
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>payout</title>
</head>
<body>
	<!-- Display it on the screen -->
	
    <style>
	input 
	</style>
	<form method="POST" action="">
	             <input type="text" name="cash" value=""placeholder="RUB" min="0" max="12" method="GET" required >
		payeer id<input type="text" name="wallet" value=""placeholder="p10000000" method="GET"  >
		<input type="submit" name="submit" value="Widthraw">
	</form>
	
</body>
</html>
	