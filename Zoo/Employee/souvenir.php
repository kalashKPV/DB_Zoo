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
            <label for="user_login">Id<br><select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="souvenirID">
                <option name="souvenirID" value="<?php echo $souvenirID;?>">
                    <?php echo $souvenirID;?>
                </option>
                <?php
                include("../includes/connections.php");
                $all = mysqli_query($con,"SELECT * FROM `souvenir`");
                ?>
                <?php
                while ($souvenir = mysqli_fetch_array($all)):;
                    ?>

                    <option name="ticketID" value="<?php echo $souvenir["souvenirID"];?>">
                        <?php echo $souvenir["souvenirID"];?>
                    </option>
                <?php endwhile;?>
            </select></label><br>
            <label for="user_login">Сувенір<br><input type="text" name="sname" value="<?php echo $sname;?>"></label><br>
            <label for="user_login">Ціна<br><input type="text" name="price" value="<?php echo $price;?>"></label><br>
            <label for="user_login">Продавець<br><select style="
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
                $all = mysqli_query($con,"SELECT * FROM `employee` WHERE post = 'Продавець' ");
                ?>
                <?php
                while ($employee = mysqli_fetch_array($all)):;
                    ?>

                    <option name="employeeID" value="<?php echo $employee["employeeID"];?>">
                        <?php echo $employee["lastName"];?>
                        <?php $employeeID = $employee["employeeID"];?>
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
            <p><a href="main.php" class="button">Повернення в головне меню</a></p>     
        </form>
    </div>
</div>
<?php include("../includes/footer.php"); ?>       

<?php endif; ?>     