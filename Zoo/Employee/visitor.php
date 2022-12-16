<?php

include("../includes/connectdb.php");


try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    $var1= 'Not Connected '.$ex->getMessage();
    
}


$visitorID   = "";
$lastName = "";
$firstName = "";
$age = "";

function getPosts()
{
    $posts = array();
    $posts[0] = trim($_POST['visitorID']);
    $posts[1] = trim($_POST['lastName']);
    $posts[2] = trim($_POST['firstName']);
    $posts[3] = trim($_POST['age']);
    return $posts;
}

// Search
$var1= '';

if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The Visitor Id To Search';
    }  else {
        
        $searchStmt = $con->prepare('SELECT * FROM visitor WHERE visitorID = :visitorID');
        $searchStmt->execute(array(
            ':visitorID'=> htmlspecialchars($data[0])
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $var1= 'No Visitor For This Id';
            } else {

                $visitorID = $user[0];
                $lastName = $user[1];
                $firstName = $user[2];
                $age = $user[3];
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
        $var1= 'Enter The Visitor To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO `visitor`(`lastName`, `firstName`, `age`) VALUES (:lastName,:firstName,:age)');
        $insertStmt->execute(array(
            ':lastName'=> htmlspecialchars($data[1]),
            ':firstName'=> htmlspecialchars($data[2]),
            ':age'  => htmlspecialchars($data[3]),
        ));
        
        if($insertStmt)
        {
            $var1= 'Visitor Inserted';
        }
        
    }
}

// Update
if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        $var1= 'Enter The Visitor To Update';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE `visitor` SET lastName = :lastName, firstName = :firstName, age = :age WHERE visitorID = :visitorID');
        $updateStmt->execute(array(
            ':visitorID'=> htmlspecialchars($data[0]),
            ':lastName'=> htmlspecialchars($data[1]),
            ':firstName'=> htmlspecialchars($data[2]),
            ':age'  => htmlspecialchars($data[3]),
        ));
        
        if($updateStmt)
        {
            $var1= 'Visitor Updated';
        }
        
    }
}

// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The Visitor ID To Delete';
    }  else {

        $deleteStmt = $con->prepare('DELETE FROM `visitor` WHERE visitorID = :visitorID');
        $deleteStmt->execute(array(
            ':visitorID'=> htmlspecialchars($data[0])
        ));
        
        if($deleteStmt)
        {
            $var1= 'Visitor Deleted';
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

<?php include("../includes/header.php");?>
<div class="container mlogin">
    <div id="login">
        <form action="visitor.php" method="post">
            <label for="user_login">Id<br><input type="number" name="visitorID"  min="1" placeholder="Id"  value="<?php echo $visitorID;?>"></label><br>
            <label for="user_login">Призвіще<br><input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName;?>"></label><br>
            <label for="user_login">Ім'я<br><input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName;?>"></label><br>
            <label for="user_login">Вік<br><input type="number" name="age"  min="1" placeholder="Age" value="<?php echo $age;?>"></label><br><br>
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