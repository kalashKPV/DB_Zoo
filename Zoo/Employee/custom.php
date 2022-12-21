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
                $lastName = $user[3];
                $sname = $user[4];
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
        
        $updateStmt = $con->prepare('UPDATE `custom` SET `souvenirID` = :souvenirID, `visitorID` = :visitorID WHERE customID = :customID');
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
            <label for="user_login">Id<br><select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="customID">
                <option name="customID" value="<?php echo $customID;?>">
                    <?php echo $customID;?>
                </option>
                <?php
                include("../includes/connections.php");
                $all = mysqli_query($con,"SELECT * FROM `custom`");
                ?>
                <?php
                while ($custom = mysqli_fetch_array($all)):;
                    ?>

                    <option name="ticketID" value="<?php echo $custom["customID"];?>">
                        <?php echo $custom["customID"];?>
                    </option>
                <?php endwhile;?>
            </select></label><br>
            <label for="user_login">Сувенір<br><select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="souvenirID">
                <option name="souvenirID" value="<?php echo $souvenirID;?>">
                    <?php echo $sname;?>
                </option>
                <?php
                include("../includes/connections.php");
                $all = mysqli_query($con,"SELECT * FROM `souvenir`");
                ?>
                <?php
                while ($souvenir = mysqli_fetch_array($all)):;
                    ?>

                    <option name="souvenirID" value="<?php echo $souvenir["souvenirID"];?>">
                        <?php echo $souvenir["sname"];?>
                        <?php $souvenirID = $souvenir["souvenirID"];?>
                    </option>
                <?php endwhile;?>
            </select></label><br>
            <label for="user_login">Відвідувач<br><select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="visitorID">
                <option name="visitorID" value="<?php echo $visitorID;?>">
                    <?php echo $lastName;?>
                </option>
                <?php
                include("../includes/connections.php");
                $all = mysqli_query($con,"SELECT * FROM `visitor`");
                ?>
                <?php
                while ($visitor = mysqli_fetch_array($all)):;
                    ?>

                    <option name="visitorID" value="<?php echo $visitor["visitorID"];?>">
                        <?php echo $visitor["lastName"];?>
                        <?php $visitorID = $visitor["visitorID"];?>
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