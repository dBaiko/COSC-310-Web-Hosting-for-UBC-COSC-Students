<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $userName = $_POST["username"];
    echo $userName . "<br>";
    $firstName = $_POST["firstName"];
    echo $firstName . "<br>";
    $lastName = $_POST["lastName"];
    echo $lastName . "<br>";
    $password = $_POST["pass"];
    echo $password . "<br>";
    $passConf = $_POST["passConf"];
    echo $passConf . "<br>";
    $email = $_POST["email"];
    echo $email . "<br>";
    $studentNum = $_POST["studentNum"];
    echo $studentNum . "<br>";
    $stuSchool = $_POST["stuSchool"];
    echo $stuSchool . "<br>";
    $major = $_POST["major"];
    echo $major . "<br>";
    $profSchool = $_POST["profSchool"];
    echo $profSchool . "<br>";
    $faculty = $_POST["faculty"];
    echo $faculty . "<br>";
    
   
    if($userName != null && $userName != "" && $firstName != null && $firstName != "" && $lastName != null && $lastName != "" && $password != null && $password != "" && $passConf != null && $passConf != "" &&  $email != null  && $email != ""){                                              
        if($password == $passConf){
            $valid = true;
            echo "<br>";
            if(strpos($email, "@") == false && strpos($email, ".") == false){
                $valid = false;
            }
            if($valid){
                $servername = "localhost";
                $username = "cswebhosting";
                $db_pass = "a9zEkajA";
                $db = "cswebhosting";
                
                $conn =  mysqli_connect($servername, $username, $db_pass, $db);
                
                $confirm = false;
                
                //incert into user table
                $userName = chop($userName);
                $firstName = chop($firstName);
                $lastName = chop($lastName);
                $password = chop($password);
                $email = chop($email);
                
                
                $salt = date("U");
                
                $toHash = $password . $salt;
                
                $dbPass = hash('sha256', $toHash);
                
                $stm = "INSERT INTO User (userName, firstName, lastName, email, password, salt) VALUES (?,?,?,?,?,?)";
                if($sql = $conn->prepare($stm)){
                    $sql->bind_param("ssssss", $userName,$firstName,$lastName,$email,$dbPass,$salt);
                    $sql->execute();
                    $_SESSION["user"] = $userName;
                    $confirm = true;
                } else {
                    $error = $conn->errno . ' ' . $conn->error;
                    echo $error;
                }
                
                if($studentNum != null && $studentNum != "" && $stuSchool != null && $stuSchool != "" && $major != null && $major != ""){
                    //incert into student table
                    $studentNum = chop($studentNum);
                    $stuSchool = chop($stuSchool);
                    $major = chop($major);
                    
                    $stm = "INSERT INTO Student (userName, studentNum, school, major) VALUES (?,?,?,?)";
                    if($sql = $conn->prepare($stm)){
                        $sql->bind_param("ssss", $userName, $studentNum, $stuSchool, $major);
                        $sql->execute();
                    }
                    
                }
                
                
                
            }
            else{
                ?>
            	<meta http-equiv="refresh" content="0; URL='../Register.html'"/>
            	<?php
            }
        }
        else{
            ?>
            <meta http-equiv="refresh" content="0; URL='../Register.html'"/>
            <?php
        }
    }
    else{
        ?>
        <meta http-equiv="refresh" content="0; URL='../Register.html'"/>
        <?php
    }
    

}
?>
