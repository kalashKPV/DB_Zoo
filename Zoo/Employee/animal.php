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
            <label for="user_login">Id<br><select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="animalID">
                <option name="animalID" value="<?php echo $animalID;?>">
                    <?php echo $animalID;?>
                </option>
                <?php
                include("../includes/connections.php");
                $all = mysqli_query($con,"SELECT * FROM `animal`");
                ?>
                <?php
                while ($animal = mysqli_fetch_array($all)):;
                    ?>

                    <option name="animalID" value="<?php echo $animal["animalID"];?>">
                        <?php echo $animal["animalID"];?>
                    </option>
                <?php endwhile;?>
            </select></label><br>
            <label for="user_login">Вид<br><input type="text" name="kind" value="<?php echo $kind;?>"></label><br>
            <label for="user_login">Дієта<br><input type="text" name="diet" value="<?php echo $diet;?>"></label><br>
                <label for="user_login">Доглядаючий<br><select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="employeeID">
                <option name="employeeID" value="<?php echo $employeeID;?>">
                    <?php echo $lastName;?>
                </option>
                <?php
                include("../includes/connections.php");
                $all = mysqli_query($con,"SELECT * FROM `employee` WHERE post = 'Доглядаючий' ");
                ?>
                <?php
                while ($employee = mysqli_fetch_array($all)):;
                    ?>

                    <option name="employeeID" value="<?php echo $employee["employeeID"];?>">
                        <?php echo $employee["lastName"];?>
                        <?php $employeeID = $employee["employeeID"];?>
                    </option>
                <?php endwhile;?>
            </select></label><br>
                <label for="user_login">Секція<br><select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="sectionID">
                <option name="sectionID" value="<?php echo $sectionID;?>">
                    <?php echo $type_of_animals;?>
                </option>
                <?php
                include("../includes/connections.php");
                $all = mysqli_query($con,"SELECT * FROM `section`");
                ?>
                <?php
                while ($section = mysqli_fetch_array($all)):;
                    ?>

                    <option name="sectionID" value="<?php echo $section["sectionID"];?>">
                        <?php echo $section["type_of_animals"];?>
                        <?php $sectionID = $section["sectionID"];?>
                    </option>
                <?php endwhile;?>
            </select></label><br><br>
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