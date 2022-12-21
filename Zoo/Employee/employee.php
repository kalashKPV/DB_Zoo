<?php

include("../includes/connectdb.php");


try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {

    $var1= 'Not Connected '.$ex->getMessnumber();
    
}


$employeeID  = "";
$lastName = "";
$firstName = "";
$data_birth = "";
$post = "";
$wage = "";
$experience = "";

function getPosts()
{
    $posts = array();
    $posts[0] = trim($_POST['employeeID']);
    $posts[1] = trim($_POST['lastName']);
    $posts[2] = trim($_POST['firstName']);
    $posts[3] = trim($_POST['data_birth']);
    $posts[4] = trim($_POST['post']);
    $posts[5] = trim($_POST['wage']);
    $posts[6] = trim($_POST['experience']);
    return $posts;
}

// Search
$var1= '';
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The employee Id To Search';
    }  else {

        $searchStmt = $con->prepare('SELECT * FROM employee WHERE employeeID = :employeeID');
        $searchStmt->execute(array(
            ':employeeID'=> htmlspecialchars($data[0])
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $var1= 'No employee For This Id';
            } else {

                $employeeID = $user[0];
                $lastName = $user[1];
                $firstName = $user[2];
                $data_birth = $user[3];
                $post = $user[4];
                $wage = $user[5];
                $experience = $user[6];
            }
        }
        
    }
}



// Insert
if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]) || empty($data[6]))
    {
        $var1= 'Enter The employee To Insert';
    }  else if(!validateDate($data[3], 'Y-m-d')===TRUE)
    {
        $var1= 'Enter corect data_birth';
    }  else {

        $insertStmt = $con->prepare('INSERT INTO `employee`(`lastName`, `firstName`, `data_birth`,`post`, `wage`, `experience`) VALUES (:lastName,:firstName,:data_birth,:post,:wage,:experience)');
        $insertStmt->execute(array(
            ':lastName'=> htmlspecialchars($data[1]),
            ':firstName'=> htmlspecialchars($data[2]),
            ':data_birth'  => htmlspecialchars($data[3]),
            ':post'=> htmlspecialchars($data[4]),
            ':wage'=> htmlspecialchars($data[5]),
            ':experience'  => htmlspecialchars($data[6]),
        ));
        
        if($insertStmt)
        {
            $var1= 'employee Inserted';
        }
        
    }
}

// Update
if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]) || empty($data[6]))
    {
        $var1= 'Enter The employee To Update';
    }  else if(!validateDate($data[3], 'Y-m-d')===TRUE)
    {
        $var1= 'Enter corect data_birth';
    }  else {

        $updateStmt = $con->prepare('UPDATE `employee` SET lastName = :lastName, firstName = :firstName, data_birth = :data_birth, post = :post, wage = :wage, experience = :experience WHERE employeeID = :employeeID');
        $updateStmt->execute(array(
            ':employeeID'=> htmlspecialchars($data[0]),
            ':lastName'=> htmlspecialchars($data[1]),
            ':firstName'=> htmlspecialchars($data[2]),
            ':data_birth'  => htmlspecialchars($data[3]),
            ':post'=> htmlspecialchars($data[4]),
            ':wage'=> htmlspecialchars($data[5]),
            ':experience'  => htmlspecialchars($data[6])
        ));
        
        if($updateStmt)
        {
            $var1= 'employee Updated';
        }
        
    }
}

// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $var1= 'Enter The employee ID To Delete';
    }  else {

        $deleteStmt = $con->prepare('DELETE FROM `employee` WHERE employeeID = :employeeID');
        $deleteStmt->execute(array(
            ':employeeID'=> htmlspecialchars($data[0])
        ));
        
        if($deleteStmt)
        {
            $var1= 'employee Deleted';
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
            <form action="employee.php" method="post">
                <label for="user_login">Id<br><select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="employeeID">
                <option name="employeeID" value="<?php echo $employeeID;?>">
                    <?php echo $employeeID;?>
                </option>
                <?php
                include("../includes/connections.php");
                $all = mysqli_query($con,"SELECT * FROM `employee`");
                ?>
                <?php
                while ($employee = mysqli_fetch_array($all)):;
                    ?>

                    <option name="employeeID" value="<?php echo $employee["employeeID"];?>">
                        <?php echo $employee["employeeID"];?>
                    </option>
                <?php endwhile;?>
            </select></label><br>
            <label for="user_login">Прізвище<br><input type="text" name="lastName" value="<?php echo $lastName;?>"></label><br>
            <label for="user_login">Ім'я<br><input type="text" name="firstName" value="<?php echo $firstName;?>"></label><br>
            <label for="user_login">Дата народження (YYYY-MM-DD)<br><input type="text" name="data_birth" value="<?php echo $data_birth;?>"></label><br>
            <label for="user_login">Посада<br>
                <select style="
                background: #fbfbfb;
                font-size: 24px;
                line-height: 1;
                width: 100%;
                padding: 3px;
                margin: 0 6px 5px 0;
                outline: none;
                border: 1px solid #d9d9d9;" name="post">
                <option><?php echo $post;?></option>
                <option value="Касир"><?php echo $post = "Касир";?></option>
                <option value="Продавець"><?php echo $post = "Продавець";?></option>
                <option value="Доглядаючий"><?php echo $post = "Доглядаючий";?></option>
            </select></label><br>
                <label for="user_login">Заробітня плата<br><input type="number" name="wage" min="7500" value="<?php echo $wage;?>"></label><br>
                <label for="user_login">Стаж(в роках)<br><input type="number" name="experience" min="1" value="<?php echo $experience;?>"></label><br>
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