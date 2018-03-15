<?php


class newUser {
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $conn = null;
    private  $db = null;
    
    
    public function __construct() {
        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
        if(!$this->conn){
            die('Could not connect: ' .mysqli_error());
        }
        else{
            $this->db = mysqli_select_db($this->conn, $this->db_name);
            if(!$this->db){
                die('Could not connect: ' .mysqli_error());
            }
        }
    }
    
    public function createNewUser($userName,$firstName,$lastName,$email,$password, $passConf,$studentNum,$stuSchool,$major,$profSchool,$faculty){
        if($userName != null && $userName != "" && $firstName != null && $firstName != "" && $lastName != null && $lastName != "" && $password != null && $password != "" && $passConf != null && $passConf != "" &&  $email != null  && $email != ""){
            if($password == $passConf){
                if(strpos($email, "@") != false && strpos($email, ".") != false){
                    $confirm = false;
                    $userName = chop($userName);
                    $firstName = chop($firstName);
                    $lastName = chop($lastName);
                    $password = chop($password);
                    $email = chop($email);
                    
                    $salt = date("U");
                    
                    $toHash = $password . $salt;
                    
                    $dbPass = hash('sha256', $toHash);
                    
                    $stm = "INSERT INTO User (userName, firstName, lastName, email, password, salt) VALUES (?,?,?,?,?,?)";
                    if($sql = $this->conn->prepare($stm)){
                        $sql->bind_param("ssssss", $userName,$firstName,$lastName,$email,$dbPass,$salt);
                        if($sql->execute()){
                            $confirm = true;
                        }
                        else{
                            return false;
                        }
                        if($confirm){
                            if($studentNum != null && $studentNum != "" && $stuSchool != null && $stuSchool != "" && $major != null && $major != ""){
                                $studentNum = chop($studentNum);
                                $stuSchool = chop($stuSchool);
                                $major = chop($major);
                                
                                $stm = "INSERT INTO Student (userName, studentNum, school, major) VALUES (?,?,?,?)";
                                if($sql = $this->conn->prepare($stm)){
                                    $sql->bind_param("ssss", $userName, $studentNum, $stuSchool, $major);
                                    if($sql->execute()){
                                        return true;
                                    }
                                    else{
                                        return false;
                                    }
                                }else {
                                    return false;
                                }
                            }
                            else if($profSchool != null && $profSchool != "" && $faculty != null && $faculty != ""){
                                $profSchool = chop($profSchool);
                                $faculty = chop($faculty);
                                
                                $stm = "INSERT INTO Professor (userName, faculty, school) VALUES (?,?,?)";
                                if($sql = $this->conn->prepare($stm)){
                                    $sql->bind_param("sss", $userName, $faculty, $profSchool);
                                    if($sql->execute()){
                                        return true;
                                    }
                                    else{
                                        return false;
                                    }
                                } else {
                                    return false;
                                }
                            }
                            else{
                                return true;
                            }
                            
                        }
                        
                    } else {
                        return false;
                    }
                    
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
        return false;
    }
}


//set session variable, method above doesn't do it
/*
function consoleLog($toLog) {
    ?>
    <script type="text/javascript">
		console.log("<?php echo $toLog?>");
	</script>
    <?php
}*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $newUser = new newUser();
    
    
    $userName = $_POST["username"];
    //echo $userName . "<br>";
    $firstName = $_POST["firstName"];
    //echo $firstName . "<br>";
    $lastName = $_POST["lastName"];
    //echo $lastName . "<br>";
    $password = $_POST["pass"];
    //echo $password . "<br>";
    $passConf = $_POST["passConf"];
    //echo $passConf . "<br>";
    $email = $_POST["email"];
   // echo $email . "<br>";
    $studentNum = $_POST["studentNum"];
    //echo $studentNum . "<br>";
    $stuSchool = $_POST["stuSchool"];
    //echo $stuSchool . "<br>";
    $major = $_POST["major"];
    //echo $major . "<br>";
    $profSchool = $_POST["profSchool"];
    //echo $profSchool . "<br>";
    $faculty = $_POST["faculty"];
    //echo $faculty . "<br>";
    if($newUser->createNewUser($userName, $firstName, $lastName, $email, $password, $passConf, $studentNum, $stuSchool, $major, $profSchool, $faculty)){
        $_SESSION['user'] = $userName;
        ?>
        <meta http-equiv="refresh" content="0; URL='../confirmNewUser.php'"/>
        <?php
    }
    else{
        ?>
        <meta http-equiv="refresh" content="0; URL='../Register.php'"/>
        <?php
    }

}
else{
    ?>
       <meta http-equiv="refresh" content="0; URL='../Register.php'"/>
        <?php
    }
?>
