<?php

include("../includes/connectdb.php");


try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    $var1= 'Not Connected '.$ex->getMesssectionID();
    
}

$animalID  = "";
$kind = "";
$diet = "";
$employeeID = "";
$sectionID = "";
$lastName = "";
$type_of_animals = "";

function getPosts()
{
    $posts = array();
    $posts[0] = trim($_POST['animalID']);
    $posts[1] = trim($_POST['kind']);
    $posts[2] = trim($_POST['diet']);
    $posts[5] = trim($_POST['lastName']);
    $posts[6] = trim($_POST['type_of_animals']);
    return $posts;
}
$var1= '';

// Search
if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The animal Id To Search';
    }  else {
        
        $searchStmt = $con->prepare('SELECT a.*, e.lastName, s.type_of_animals FROM animal a,employee e,section s WHERE a.animalID = :animalID AND e.employeeID = a.employeeID AND s.sectionID = a.sectionID;');
        $searchStmt->execute(array(
                    ':animalID'=> htmlspecialchars($data[0])
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $var1= 'No animal For This Id';
            } else {

                $animalID = $user[0];
                $kind = $user[1];
                $diet = $user[2];
                $lastName = $user[5];                
                $type_of_animals = $user[6];
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
        <form action="animal.php" method="post">
            <label for="user_login">Id<br><input type="number" name="animalID" min="1" placeholder="Id" value="<?php echo $animalID;?>"></label><br>
            <label for="user_login">Вид<br><input type="text" name="kind" placeholder="Kind" value="<?php echo $kind;?>"></label><br>
            <label for="user_login">Дієта<br><input type="text" name="diet" placeholder="Diet" value="<?php echo $diet;?>"></label><br>
            <label for="user_login">Доглядаючий<br><input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName;?>"></label><br>
            <label for="user_login">Тип тварини<br><input type="text" name="type_of_animals" placeholder="Type of animals" value="<?php echo $type_of_animals;?>"></label><br>
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