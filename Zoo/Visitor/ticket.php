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

?>
<?php

session_start();

if(!isset($_SESSION["session_username"])):
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
                $username = $_SESSION['session_username'];
                $all = mysqli_query($con,"SELECT * FROM ticket t WHERE (SELECT visitorID FROM visitor v, usertbl u WHERE t.visitorID = v.visitorID AND u.username = '$username' AND v.lastName LIKE u.lastName AND v.firstName LIKE u.firstName);");
                ?>
                <?php
                while ($ticket = mysqli_fetch_array($all)):;
                    ?>

                    <option name="ticketID" value="<?php echo $ticket["ticketID"];?>">
                        <?php echo $ticket["ticketID"];?>
                    </option>
                <?php endwhile;?>
            </select></label><br>
            <label for="user_login">Час<br><input type="text" name="time" value="<?php echo $time;?>"></label><br>
            <label for="user_login">Відвідувач<br><input type="text" name="lastName" value="<?php echo $lastName;?>"></label><br>
            <label for="user_login">Секція<br><input type="text" name="type_of_animals" value="<?php echo $type_of_animals;?>"></label><br>
            <div>
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