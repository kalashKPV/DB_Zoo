<?php

include("../includes/connectdb.php");

try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    $var1= 'Not Connected '.$ex->getMessprice();
    
}


$souvenirID   = "";
$sname = "";
$price = "";
$employeeID = "";
$lastName = "";

function getPosts()
{
    $posts = array();
    $posts[0] = trim($_POST['souvenirID']);
    $posts[1] = trim($_POST['sname']);
    $posts[2] = trim($_POST['price']);
    $posts[3] = trim($_POST['employeeID']);
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
        $var1= 'Enter The Souvenir Id To Search';
    }  else {
        
        $searchStmt = $con->prepare('SELECT s.*, e.lastName FROM souvenir s,employee e WHERE s.souvenirID = :souvenirID AND s.employeeID = e.employeeID');
        $searchStmt->execute(array(
            ':souvenirID'=> htmlspecialchars($data[0])
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $var1= 'No Souvenir For This Id';
            } else {

                $souvenirID = $user[0];
                $sname = $user[1];
                $price = $user[2];
                $employeeID = $user[3];
                $lastName = $user[4];
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
        $var1= 'Enter The Souvenir To Insert';
    }  else if(!filter_var($data[2],FILTER_VALIDATE_FLOAT)===TRUE)
    {
        $var1= 'Enter corect Price';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO `souvenir`(`sname`, `price`, `employeeID`) VALUES (:sname,:price,:employeeID)');
        $insertStmt->execute(array(
            ':sname'=> htmlspecialchars($data[1]),
            ':price'=> htmlspecialchars($data[2]),
            ':employeeID'  => htmlspecialchars($data[3]),
        ));
        
        if($insertStmt)
        {
            $var1= 'Souvenir Inserted';
        }
        
    }
}

// Update
if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        $var1= 'Enter The Souvenir To Update';
    }  else if(!filter_var($data[2],FILTER_VALIDATE_FLOAT)===TRUE)
    {
        $var1= 'Enter corect Price';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE `souvenir` SET sname = :sname, price = :price, employeeID = :employeeID WHERE souvenirID = :souvenirID');
        $updateStmt->execute(array(
            ':souvenirID'=> htmlspecialchars($data[0]),
            ':sname'=> htmlspecialchars($data[1]),
            ':price'=> htmlspecialchars($data[2]),
            ':employeeID'=> htmlspecialchars($data[3])
        ));
        
        if($updateStmt)
        {
            $var1= 'Souvenir Updated';
        }
        
    }
}

// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The User ID To Delete';
    }  else {

        $deleteStmt = $con->prepare('DELETE FROM `souvenir` WHERE souvenirID = :souvenirID');
        $deleteStmt->execute(array(
            ':souvenirID'=> htmlspecialchars($data[0])
        ));
        
        if($deleteStmt)
        {
            $var1= 'Souvenir Deleted';
        }
        
    }
}

// Reload
if(isset($_POST['reload']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The User Id To Reload';
    }  else {
        
        $reloadStmt = $con->prepare('SELECT e.lastName FROM souvenir s,employee e WHERE e.employeeID = :employeeID;');
        $reloadStmt->execute(array(
            ':employeeID'=> htmlspecialchars($data[3])
        ));
        
        if($reloadStmt)
        {
            $user = $reloadStmt->fetch();
            if(empty($user))
            {
                $var1= 'No Data For This Id';
            } else {

                $souvenirID = $data[0];
                $sname = $data[1];
                $price = $data[2];
                $employeeID = $data[3];
                $lastName = $user[0];
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
        <form action="souvenir.php" method="post">
             <label for="user_login">Id<br><input type="number" name="souvenirID" min="1" placeholder="Id" value="<?php echo $souvenirID;?>"></label><br>
            <label for="user_login">Сувенір<br><input type="text" name="sname" placeholder="Souvenir Name" value="<?php echo $sname;?>"></label><br>
            <label for="user_login">Ціна<br><input type="text" name="price" placeholder="Price" value="<?php echo $price;?>"></label><br>
            <label for="user_login">Id продавеця<br><input type="number" name="employeeID"  min="1" placeholder="Employee" value="<?php echo $employeeID;?>"></label><br>
            <label for="user_login">Продавець<br><input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName;?>"></label><br>
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