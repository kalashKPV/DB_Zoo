<?php
$message = "";
include("includes/connections.php");
if(isset($_POST["register"])){

    if(!empty($_POST['lastName']) && !empty($_POST['firstName']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {
      $lastName= htmlspecialchars($_POST['lastName']);
      $firstName= htmlspecialchars($_POST['firstName']);
      $email=htmlspecialchars($_POST['email']);
      $username=htmlspecialchars($_POST['username']);
      $password=htmlspecialchars($_POST['password']);
      $is_admin=$_POST['is_admin'];
      $query=mysqli_query($con, "SELECT * FROM usertbl WHERE username='".$username."'");
      $numrows=mysqli_num_rows($query);
      if($numrows==0)
      {
        $sql="INSERT INTO usertbl
        (lastName, firstName, email, username,password,is_admin)
        VALUES('$lastName','$firstName','$email', '$username', '$password', '$is_admin')";
        $result=mysqli_query($con, $sql);
        if($result){
            $message = "Account Successfully Created";
        } else {
           $message = "Failed to insert data information!";
       }
   } else {
    $message = "That username already exists! Please try another one!";
}
} else {
    $message = "All fields are required!";
}
}
?>
<?php include("includes/header.php"); ?>
<div class="container mlogin">
    <div id="login">
       <h1>Реєстрація</h1>
       <form action="register.php" id="registerform" method="post"name="registerform">
           <p><label for="user_login">Призвіще<br>
               <input class="input" id="lastName" name="lastName"size="32"  type="text" value=""></label></p>
               <p><label for="user_login">Ім'я<br>
               <input class="input" id="firstName" name="firstName"size="32"  type="text" value=""></label></p>
               <p><label for="user_pass">E-mail<br>
                <input class="input" id="email" name="email" size="32"type="email" value=""></label></p>
                <p><label for="user_pass">Ім'я користувача<br>
                    <input class="input" id="username" name="username"size="20" type="text" value=""></label></p>
                    <p><label for="user_pass">Пароль<br>
                        <input class="input" id="password" name="password"size="32"   type="password" value=""></label></p>
                        <p><input class="checkbox" type="checkbox" id="checkbox" name="is_admin" value="is_admin"><label for="user_pass">Запросити права адміністратора</label></p>
                        <input id="is_admin" name="is_admin" type="hidden" value="0">
                        <?php 
                        echo "<p id = message> $message </p>"; 
                        ?>
                        <p class="submit"><input class="button" id="register" name= "register" type="submit" value="Зареєструватись"></p>
                        <p class="regtext">Вже зареєстровані? <a href= "login.php">Введіть ім'я користувача</a>!</p>
                    </form>                    
                </div>
                <script src="js/script.js"></script>
            </div>        
            <?php include("includes/footer.php"); ?>	
