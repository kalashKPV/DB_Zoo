<?php

include("../includes/connectdb.php");


try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    $var1= 'Not Connected '.$ex->getMesssname();
    
}


$customID   = "";
$souvenirID = "";
$visitorID = "";
$sname = "";
$lastName = "";

function getPosts()
{
    $posts = array();
    $posts[0] = trim($_POST['customID']);
    $posts[3] = trim($_POST['sname']);
    $posts[4] = trim($_POST['lastName']);
    return $posts;
}
$var1= '';

// Search
if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The custom Id To Search';
    }  else {
        
        $searchStmt = $con->prepare('SELECT c.*, v.lastName, s.sname FROM custom c,visitor v,souvenir s WHERE c.customID = :customID AND v.visitorID = c.visitorID AND c.souvenirID = s.souvenirID;');
        $searchStmt->execute(array(
                    ':customID'=> htmlspecialchars($data[0])
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $var1= 'No custom For This Id';
            } else {

                $customID = $user[0];
                $sname = $user[3];
                $lastName = $user[4];
            }
        }
        
    }
}
?>
<?php

session_start();

if(!isset($_SESSION["session_username"])):
header("location:login.php");
else:
?>
<?php include("../includes/header.php"); ?>
<div class="container mlogin">
    <div id="login">
        <form action="custom.php" method="post">
            <label for="user_login">Id<br><input type="number" name="customID" min="1" placeholder="Id" value="<?php echo $customID;?>"></label><br>
            <label for="user_login">Покупець<br><input type="text" name="sname" placeholder="Souvenir Name" value="<?php echo $sname;?>"></label><br>
            <label for="user_login">Продавець<br><input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName;?>"></label><br>
            <div>
                <!-- Input For Find Values With The given ID -->
                <input type="submit" class="button"  name="search" value="Find">
            </div>            
            <?php 
            echo "<p id = message> $var1 </p>"; 
            ?>           
            <p><a href="main.php" class="button">Повернення в головне меню</a></p>     
        </form>
    </div>
</div>
<?php include("../includes/footer.php"); ?>    

<?php endif; ?>   