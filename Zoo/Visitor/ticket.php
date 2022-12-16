<?php

$dsn = 'mysql:host=localhost;dbname=zoo';
$username = 'root';
$password = '';


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
    $posts[4] = trim($_POST['lastName']);
    $posts[5] = trim($_POST['type_of_animals']);
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
            <label for="user_login">Id<br><input type="number" name="ticketID" min="1" placeholder="Id" value="<?php echo $ticketID;?>"></label><br>
            <label for="user_login">Час<br><input type="text" name="time" placeholder="Time" value="<?php echo $time;?>"></label><br>
            <label for="user_login">Відвідувач<br><input type="text" name="lastName" placeholder="Visitor Name" value="<?php echo $lastName;?>"></label><br>
            <label for="user_login">Секція<br><input type="text" name="type_of_animals" placeholder="Type of animals" value="<?php echo $type_of_animals;?>"></label><br>
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