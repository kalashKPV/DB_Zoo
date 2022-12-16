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
    $posts[1] = trim($_POST['souvenirID']);
    $posts[2] = trim($_POST['visitorID']);
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
                $souvenirID = $user[1];
                $visitorID = $user[2];
                $sname = $user[3];
                $lastName = $user[4];
            }
        }
        
    }
}



// Insert
if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]))
    {
        $var1= 'Enter The custom To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO `custom`(`souvenirID`, `visitorID`) VALUES (:souvenirID,:visitorID)');
        $insertStmt->execute(array(
                    ':souvenirID'=> htmlspecialchars($data[1]),
                    ':visitorID'=> htmlspecialchars($data[2]),
        ));
        
        if($insertStmt)
        {
                $var1= 'custom Inserted';
        }
        
    }
}

// Update
if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[0]) || empty($data[1]) || empty($data[2]))
    {
        $var1= 'Enter The custom To Update';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE `custom` SET `souvenirID` = :souvenirID, visitorID = :visitorID WHERE customID = :customID');
        $updateStmt->execute(array(
                    ':customID'=> htmlspecialchars($data[0]),
                    ':souvenirID'=> htmlspecialchars($data[1]),
                    ':visitorID'=> htmlspecialchars($data[2]),
        ));
        
        if($updateStmt)
        {
                $var1= 'custom Updated';
        }
        
    }
}

// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The custom ID To Delete';
    }  else {

        $deleteStmt = $con->prepare('DELETE FROM `custom` WHERE customID = :customID');
        $deleteStmt->execute(array(
            ':customID'=> htmlspecialchars($data[0])
        ));
        
        if($deleteStmt)
        {
            $var1= 'custom Deleted';
        }
        
    }
}

// Reload
if(isset($_POST['reload']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The custom Id To Reload';
    }  else {
        
        $reloadStmt = $con->prepare('SELECT v.lastName, s.sname FROM custom c,visitor v,souvenir s WHERE v.visitorID = :visitorID AND s.souvenirID = :souvenirID;');
        $reloadStmt->execute(array(
                    ':visitorID'=> htmlspecialchars($data[1]),
                    ':souvenirID'=> htmlspecialchars($data[2])
        ));
        
        if($reloadStmt)
        {
            $user = $reloadStmt->fetch();
            if(empty($user))
            {
                $var1= 'No custom For This Id';
            } else {

                $customID = $data[0];
                $souvenirID = $data[1];
                $visitorID = $data[2];
                $sname = $user[0];
                $lastName = $user[1];
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
        <form action="custom.php" method="post">
            <label for="user_login">Id<br><input type="number" name="customID" min="1" placeholder="Id" value="<?php echo $customID;?>"></label><br>
            <label for="user_login">Id сувеніра<br><input type="number" name="souvenirID" min="1" placeholder="Souvenir" value="<?php echo $souvenirID;?>"></label><br>
            <label for="user_login">Сувенір<br><input type="text" name="sname" placeholder="Souvenir Name" value="<?php echo $sname;?>"></label><br>
            <label for="user_login">Id покупця<br><input type="number" name="visitorID" min="1" placeholder="Visitor" value="<?php echo $visitorID;?>"></label><br>
            <label for="user_login">Прізвище покупця<br><input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName;?>"></label><br>
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
            <p><a href="main.php" class="button">Повернення в головне меню</a></p>     
        </form>
    </div>
</div>
<?php include("../includes/footer.php"); ?>    

<?php endif; ?>   