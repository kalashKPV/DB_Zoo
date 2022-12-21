<?php

session_start();

if(!isset($_SESSION["session_username"])):
header("location:login.php");
else:
?>
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
    $posts[1] = trim($_POST['time']);
    $posts[3] = trim($_POST['sectionID']);
    return $posts;
}

$username = $_SESSION['session_username'];
$var1= '';
$Stmt = $con->prepare("SELECT v.visitorID FROM visitor v WHERE visitorID IN(SELECT v.visitorID FROM usertbl u WHERE u.username = '$username' AND v.lastName LIKE u.lastName AND v.firstName LIKE u.firstName);");
$Stmt->execute();
$visitorID = $Stmt->fetch();

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
// Insert
if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1])  || empty($data[3]))
    {
        $var1= 'Enter The Ticket To Insert';
    }  else if(!validateDate($data[1])===TRUE)
    {
        $var1= 'Enter corect Time';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO `ticket`(`time`, `visitorID`, `sectionID`) VALUES (:time,:visitorID,:sectionID)');
        $insertStmt->execute(array(
            ':time'=> htmlspecialchars($data[1]),
            ':visitorID'=> htmlspecialchars($visitorID[0]),
            ':sectionID'  => htmlspecialchars($data[3]),
        ));
        
        if($insertStmt)
        {
            $var1= 'Ticket Inserted';
        }
        
    }
}

?>

<?php include("../includes/header.php"); ?>
<div class="container mlogin">
    <div id="login">
        <form action="ticket1.php" method="post">
            <label for="user_login">Час<br><select style="
            background: #fbfbfb;
            font-size: 24px;
            line-height: 1;
            width: 100%;
            padding: 3px;
            margin: 0 6px 5px 0;
            outline: none;
            border: 1px solid #d9d9d9;" name="time" value="<?php echo $time;?>">
            <option name="time" value="<?php echo $time;?>">
                <?php 
                $t = date("Y-m-d");
                $time = "$t 11:30:00";
                ?>
                <?php echo date("Y-m-d") ;?> 11:30:00
            </option>
            <option name="time" value="<?php echo $time;?>">
                <?php 
                $t = date("Y-m-d");
                $time = "$t 12:10:00";
                ?>                  
                <?php echo date("Y-m-d") ;?> 12:10:00
            </option>
            <option name="time" value="<?php echo $time;?>">
                <?php 
                $t = date("Y-m-d");
                $time = "$t 13:30:00";
                ?>
                <?php echo date("Y-m-d") ;?> 13:30:00
            </option>
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
                <input type="submit" class="button" name="insert" value="Замовити">
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