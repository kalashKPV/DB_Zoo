<?php

include("../includes/connectdb.php");


try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    $var1= 'Not Connected '.$ex->getMessnumber();
    
}


$sectionID   = "";
$type_of_animals = "";
$number_of_species = "";
$number = "";

function getPosts()
{
    $posts = array();
    $posts[0] = trim($_POST['sectionID']);
    $posts[1] = trim($_POST['type_of_animals']);
    $posts[2] = trim($_POST['number_of_species']);
    $posts[3] = trim($_POST['number']);
    return $posts;
}

// Search
$var1= '';

if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The section Id To Search';
    }  else {
        
        $searchStmt = $con->prepare('SELECT * FROM section WHERE sectionID = :sectionID');
        $searchStmt->execute(array(
                    ':sectionID'=> htmlspecialchars($data[0])
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $var1= 'No section For This Id';
            } else {

                $sectionID = $user[0];
                $type_of_animals = $user[1];
                $number_of_species = $user[2];
                $number = $user[3];
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
        <form action="section.php" method="post">
            <label for="user_login">Id<br><input type="number" name="sectionID" min="1" placeholder="Id" value="<?php echo $sectionID;?>"></label><br>
            <label for="user_login">Тип тварини<br><input type="text" name="type_of_animals" placeholder="Type of animals" value="<?php echo $type_of_animals;?>"></label><br>
            <label for="user_login">Кількість видів<br><input type="number" name="number_of_species"  min="0" placeholder="Number of species" value="<?php echo $number_of_species;?>"></label><br>
            <label for="user_login">Кількість тварин<br><input type="number" name="number"  min="0" placeholder="Number" value="<?php echo $number;?>"></label><br>
            <div>
                <!-- Input For Find Values With The given ID -->
                <input type="submit" class="button" name="search" value="Find">
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