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



// Insert
if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        $var1= 'Enter The section To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO `section`(`type_of_animals`, `number_of_species`, `number`) VALUES (:type_of_animals,:number_of_species,:number)');
        $insertStmt->execute(array(
                    ':type_of_animals'=> htmlspecialchars($data[1]),
                    ':number_of_species'=> htmlspecialchars($data[2]),
                    ':number'  => htmlspecialchars($data[3]),
        ));
        
        if($insertStmt)
        {
                $var1= 'section Inserted';
        }
        
    }
}

// Update
if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        $var1= 'Enter The section To Update';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE `section` SET type_of_animals = :type_of_animals, number_of_species = :number_of_species, number = :number WHERE sectionID = :sectionID');
        $updateStmt->execute(array(
                    ':sectionID'=> htmlspecialchars($data[0]),
                    ':type_of_animals'=> htmlspecialchars($data[1]),
                    ':number_of_species'=> htmlspecialchars($data[2]),
                    ':number'  => htmlspecialchars($data[3]),
        ));
        
        if($updateStmt)
        {
                $var1= 'section Updated';
        }
        
    }
}

// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The section ID To Delete';
    }  else {

        $deleteStmt = $con->prepare('DELETE FROM `section` WHERE sectionID = :sectionID');
        $deleteStmt->execute(array(
            ':sectionID'=> htmlspecialchars($data[0])
        ));
        
        if($deleteStmt)
        {
            $var1= 'section Deleted';
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
        <form action="section.php" method="post">
            <label for="user_login">Id<br><select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="sectionID">
                <option name="sectionID" value="<?php echo $sectionID;?>">
                    <?php echo $sectionID;?>
                </option>
                <?php
                include("../includes/connections.php");
                $all = mysqli_query($con,"SELECT * FROM `section`");
                ?>
                <?php
                while ($section = mysqli_fetch_array($all)):;
                    ?>

                    <option name="sectionID" value="<?php echo $section["sectionID"];?>">
                        <?php echo $section["sectionID"];?>
                    </option>
                <?php endwhile;?>
            </select></label><br>
            <label for="user_login">Тип тварини<br><input type="text" name="type_of_animals" value="<?php echo $type_of_animals;?>"></label><br>
            <label for="user_login">Кількість видів<br><input type="number" name="number_of_species"  min="0" value="<?php echo $number_of_species;?>"></label><br>
            <label for="user_login">Кількість тварин<br><input type="number" name="number"  min="0" value="<?php echo $number;?>"></label><br>
            <div>
                <!-- Input For Add Values To Database-->
                <input type="submit" class="button" name="insert" value="Add">
                
                <!-- Input For Edit Values -->
                <input type="submit" class="button" name="update" value="Update">
                
                <!-- Input For Clear Values -->
                <input type="submit" class="button" name="delete" value="Delete">
                
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