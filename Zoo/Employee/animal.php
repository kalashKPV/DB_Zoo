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
    $posts[3] = trim($_POST['employeeID']);
    $posts[4] = trim($_POST['sectionID']);
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
                $employeeID = $user[3];
                $sectionID = $user[4];
                $lastName = $user[5];                
                $type_of_animals = $user[6];
            }
        }
        
    }
}



// Insert
if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]))
    {
        $var1= 'Enter The animal To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO `animal`(`kind`, `diet`, `employeeID`, `sectionID`) VALUES (:kind,:diet,:employeeID,:sectionID)');
        $insertStmt->execute(array(
                    ':kind'=> htmlspecialchars($data[1]),
                    ':diet'=> htmlspecialchars($data[2]),
                    ':employeeID'  => htmlspecialchars($data[3]),
                    ':sectionID'  => htmlspecialchars($data[4]),
        ));
        
        if($insertStmt)
        {
                $var1= 'animal Inserted';
        }
        
    }
}

// Update
if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]))
    {
        $var1= 'Enter The animal To Update';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE `animal` SET `kind` = :kind, diet = :diet, employeeID = :employeeID, sectionID = :sectionID WHERE animalID = :animalID');
        $updateStmt->execute(array(
                    ':animalID'=> htmlspecialchars($data[0]),
                    ':kind'=> htmlspecialchars($data[1]),
                    ':diet'=> htmlspecialchars($data[2]),
                    ':employeeID'=> htmlspecialchars($data[3]),
                    ':sectionID'=> htmlspecialchars($data[4])
        ));
        
        if($updateStmt)
        {
                $var1= 'animal Updated';
        }
        
    }
}

// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The animal ID To Delete';
    }  else {

        $deleteStmt = $con->prepare('DELETE FROM `animal` WHERE animalID = :animalID');
        $deleteStmt->execute(array(
            ':animalID'=> htmlspecialchars($data[0])
        ));
        
        if($deleteStmt)
        {
            $var1= 'animal Deleted';
        }
        
    }
}

// Reload
if(isset($_POST['reload']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The animal Id To Reload';
    }  else {
        
        $reloadStmt = $con->prepare('SELECT e.lastName, s.type_of_animals FROM animal a,employee e,section s WHERE e.employeeID = :employeeID AND s.sectionID = :sectionID;');
        $reloadStmt->execute(array(
                    ':employeeID'=> htmlspecialchars($data[3]),
                    ':sectionID'=> htmlspecialchars($data[4])
        ));
        
        if($reloadStmt)
        {
            $user = $reloadStmt->fetch();
            if(empty($user))
            {
                $var1= 'No animal For This Id';
            } else {

                $animalID = $data[0];
                $kind = $data[1];
                $diet = $data[2];
                $employeeID = $data[3];
                $sectionID = $data[4];
                $lastName = $user[0];
                $type_of_animals = $user[1];
            }
        }
        
    }
}

?>

<?php

session_start();

if(!isset($_SESSION["session_username1"])):
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
            <label for="user_login">Id працівника<br><input type="number" name="employeeID" min="1" placeholder="Employee" value="<?php echo $employeeID;?>">
            <label for="user_login">Прізвище працівника<br><input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName;?>"></label><br>
            <label for="user_login">Id секції<br><input type="number" name="sectionID" min="1" max="4"  placeholder="Section " value="<?php echo $sectionID;?>">
            <label for="user_login">Секція<br><input type="text" name="type_of_animals" placeholder="Type of animals" value="<?php echo $type_of_animals;?>">
            <input type="submit" class="button"  name="reload" value="Reload"><br><br>
            <div>
                <!-- Input For Add Values To Database-->
                <input type="submit" class="button" name="insert" value="Add">
                
                <!-- Input For Edit Values -->
                <input type="submit" class="button"  name="update" value="Update">
                
                <!-- Input For Clear Values -->
                <input type="submit" class="button"  name="delete" value="Delete">
                
                <!-- Input For Find Values With The given ID -->
                <input type="submit" class="button"  name="search" value="Find">
            </div>            
            <?php 
            echo "<p id = message> $var1 </p>"; 
            ?>           
            <p><a href="../main.php" class="button">Повернення в головне меню</a></p>     
        </form>
    </div>
</div>
<?php include("../includes/footer.php"); ?>      

<?php endif; ?>   