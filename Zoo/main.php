<?php

session_start();

if(!isset($_SESSION["session_username"])):
header("location:login.php");
else:
?>

<?php include("includes/header.php"); ?>
<div class="container mlogin">
	<div id="login">
		<h1>База данних "Зоопарк"</h1>
		<form action="" id="main" method="post"> 
			<p><a href="visitor.php" class="button1">Відвідувачі</a></p>
			<p><a href="employee.php" class="button1">Працівники</a></p>
			<p><a href="section.php" class="button1">Секції</a></p> 
			<p><a href="animal.php" class="button1">Тварини</a></p> 
			<p><a href="ticket.php" class="button1">Квитки</a></p> 
			<p><a href="souvenir.php" class="button1">Сувеніри</a></p> 
			<p><a href="custom.php" class="button1">Замовлення</a></p> 
		</form>
		<p><a href="logout.php">Вийти</a> із системи</p>
	</div>
</div>	
<?php include("includes/footer.php"); ?>	

<?php endif; ?>		