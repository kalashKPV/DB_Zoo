<?php

session_start();

if(!isset($_SESSION["session_username"])):
header("location:login.php");
else:
?>

<?php include("../includes/header.php"); ?>
<div class="container mlogin">
	<div id="login">
		<h1>База данних "Зоопарк"</h1>
		<form action="" id="main" method="post"> 
			<p><a href="ticket.php" class="button1">Квитки</a></p>  
			<p><a href="section.php" class="button1">Секції</a></p> 
			<p><a href="animal.php" class="button1">Тварини</a></p>
			<p><a href="souvenir.php" class="button1">Сувеніри</a></p>
		</form>
		<p><a href="../logout.php">Вийти</a> із системи</p>
	</div>
</div>	
<?php include("../includes/footer.php"); ?>	

<?php endif; ?>		