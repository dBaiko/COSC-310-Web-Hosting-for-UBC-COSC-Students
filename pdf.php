<?php 

class BlobDemo {

    const DB_HOST = 'localhost';
    const DB_NAME = 'cswebhosting';
    const DB_USER = 'cswebhosting';
    const DB_PASSWORD = 'a9zEkajA';

    /**
     * PDO instance
     * @var PDO 
     */
    private $pdo = null;

    /**
     * Open the database connection
     */
    public function __construct() {
        // open database connection
        $conStr = sprintf("mysql:host=%s;dbname=%s;charset=utf8", self::DB_HOST, self::DB_NAME);

        try {
            $this->pdo = new PDO($conStr, self::DB_USER, self::DB_PASSWORD);
            //for prior PHP 5.3.6
            //$conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * insert blob into the files table
     * @param string $filePath
     * @param string $mime mimetype
     * @return bool
     */
    public function insertBlob($filePath, $mime) {
        $blob = fopen($filePath, 'rb');

        $sql = "INSERT INTO Test(fileName,file) VALUES(:mime,:data)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':mime', $mime);
        $stmt->bindParam(':data', $blob, PDO::PARAM_LOB);

        return $stmt->execute();
    }

    /**
     * select data from the the files
     * @param int $id
     * @return array contains mime type and BLOB data
     */
    public function selectBlob($id) {

        $sql = "SELECT fileName,
                        file
                   FROM Test;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $stmt->bindColumn(1, $mime);
        $stmt->bindColumn(2, $data, PDO::PARAM_LOB);

        $stmt->fetch(PDO::FETCH_BOUND);

        return array("fileName" => $mime,
            "file" => $data);
    }


    /**
     * close the database connection
     */
    public function __destruct() {
        // close the database connection
        $this->pdo = null;
    }

}
$blobObj = new BlobDemo();
if(isset($_POST['submit']))
{

    $blobObj->insertBlob($_FILES['uploaded_file']['tmp_name'],"application/pdf");
}
?>
<!DOCTYPE html>
<head>
    <title>MySQL file upload example</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="uploaded_file"><br>
        <input type="submit" name="submit" value="Upload file">
    </form>
    <p>
      <?php 
      // to display the pdf from database
       $a = $blobObj->selectBlob(3);
            # header("Content-Type:" . $a['fileName']);
            # echo $a['file'];
      ?>
     <object data="data:application/pdf;base64,<?php echo base64_encode($a['file']) ?>" type="application/pdf" style="height:200px;width:60%"></object>
    </p>
</body>
</html>