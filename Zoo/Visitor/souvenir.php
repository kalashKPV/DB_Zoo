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
    $posts[2] = trim($_POST['price']);
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
                $lastName = $user[4];
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
        <form action="souvenir.php" method="post">
            <label for="user_login">Сувенір<br><select style="
            background: #fbfbfb;
            font-size: 24px;
            line-height: 1;
            width: 100%;
            padding: 3px;
            margin: 0 6px 5px 0;
            outline: none;
            border: 1px solid #d9d9d9;" name="souvenirID">
            <option name="souvenirID" value="<?php echo $souvenir["souvenirID"];?>">
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
            <label for="user_login">Ціна<br><input type="text" name="price" value="<?php echo $price;?>"></label><br>
            <label for="user_login">Продавець<br><input type="text" name="lastName" value="<?php echo $lastName;?>"></label><br>
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