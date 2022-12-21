<?php

include("../includes/connectdb.php");


try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    $var1= 'Not Connected '.$ex->getMesssectionID();
    
}


$ticketID   = "";
$time = "";
$visitorID = "";
$sectionID = "";
$lastName = "";
$type_of_animals = "";

function getPosts()
{
    $posts = array();
    $posts[0] = trim($_POST['ticketID']);
    $posts[1] = trim($_POST['time']);
    $posts[2] = trim($_POST['visitorID']);
    $posts[3] = trim($_POST['sectionID']);
    return $posts;
}
$var1= '';
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
// Search
if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The Ticket Id To Search';
    }  else {
        
        $searchStmt = $con->prepare('SELECT t.*, v.lastName, s.type_of_animals FROM ticket t,visitor v,section s WHERE t.ticketID = :ticketID AND v.visitorID = t.visitorID AND s.sectionID = t.sectionID;');
        $searchStmt->execute(array(
            ':ticketID'=> htmlspecialchars($data[0])
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $var1= 'No Ticket For This Id';
            } else {

                $ticketID = $user[0];
                $time = $user[1];
                $visitorID = $user[2];
                $sectionID = $user[3];
                $lastName = $user[4];
                $type_of_animals = $user[5];
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
        $var1= 'Enter The Ticket To Insert';
    }  else if(!validateDate($data[1])===TRUE)
    {
        $var1= 'Enter corect Time';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO `ticket`(`time`, `visitorID`, `sectionID`) VALUES (:time,:visitorID,:sectionID)');
        $insertStmt->execute(array(
            ':time'=> htmlspecialchars($data[1]),
            ':visitorID'=> htmlspecialchars($data[2]),
            ':sectionID'  => htmlspecialchars($data[3]),
        ));
        
        if($insertStmt)
        {
            $var1= 'Ticket Inserted';
        }
        
    }
}

// Update
if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        $var1= 'Enter The Ticket To Update';
    }  else if(!validateDate($data[1])===TRUE)
    {
        $var1= 'Enter corect Time';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE `ticket` SET `time` = :time, visitorID = :visitorID, sectionID = :sectionID WHERE ticketID = :ticketID');
        $updateStmt->execute(array(
            ':ticketID'=> htmlspecialchars($data[0]),
            ':time'=> htmlspecialchars($data[1]),
            ':visitorID'=> htmlspecialchars($data[2]),
            ':sectionID'=> htmlspecialchars($data[3])
        ));
        
        if($updateStmt)
        {
            $var1= 'Ticket Updated';
        }
        
    }
}

// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The Ticket ID To Delete';
    }  else {

        $deleteStmt = $con->prepare('DELETE FROM `ticket` WHERE ticketID = :ticketID');
        $deleteStmt->execute(array(
            ':ticketID'=> htmlspecialchars($data[0])
        ));
        
        if($deleteStmt)
        {
            $var1= 'Ticket Deleted';
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
        <form action="ticket.php" method="post">
            <label for="user_login">Id<br><select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="ticketID">
                <option name="ticketID" value="<?php echo $ticketID;?>">
                    <?php echo $ticketID;?>
                </option>
                <?php
                include("../includes/connections.php");
                $all = mysqli_query($con,"SELECT * FROM `ticket`");
                ?>
                <?php
                while ($ticket = mysqli_fetch_array($all)):;
                    ?>

                    <option name="ticketID" value="<?php echo $ticket["ticketID"];?>">
                        <?php echo $ticket["ticketID"];?>
                    </option>
                <?php endwhile;?>
            </select></label><br>
            <label for="user_login">Час<br><input type="text" name="time"  value="<?php echo $time;?>"></label><br>
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
            <p><a href="main.php" class="button">Повернення в головне меню</a></p>
        </form>
    </div>
</div>  
<?php include("../includes/footer.php"); ?> 

<?php endif; ?>     