<?php
class listContent
{
    
    private $db_host = "localhost";
    private $db_user = "cswebhosting";
    private $db_pass = "a9zEkajA";
    private $db = "cswebhosting";
    public $conn = null;
    
    
    public function __construct()
    {
        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
        if (! $this->conn) {
            die('Could not connect: ' . mysqli_error());
        } else {
            $this->db = mysqli_select_db($this->conn, $this->db_user);
            if (! $this->db) {
                die('Could not connect: ' . mysqli_error());
            }
        }
    }
    
    public function __destruct()
    {
        $this->conn->close();
        $this->conn = null;
    }
    
    
    public function displayContent($title, $userName, $date, $desc, $logo, $id,$author)
    {
        echo "<a href=\"viewProject.php?projectId=$id\" style=\"\"><table class=\"project\" id=\"website\">" . "<caption>" . $title . "</caption>" . "<thead>" . "<tr>" . "<th> By: " . $author . "</th>" . "<th class=\"textright\">" . $date . "</th>" . "</tr>" . "</thead>" . "<tbody>" . "<tr>" . "<td colspan=\"2\"><img src=\"data:image/png;base64,".base64_encode($logo)."\"name=\"web\"class=\"images\" alt=\"logo here\" />" . "<p>" . substr($desc, 0, 1500) . "..." . "</p></td>" . "</tr>" . "</tbody>" . "<tfoot>
    <tr>
    <td colspan=\"2\">
    <p id=\"copyright\">Copyright &copy; " . $title . "</p>
    </td>
    </tr>
    </tfoot>
    </table></a>";
    }
    
    public function query_all()
    {
        if ($this->conn->connect_error) {
            die("Connection failed:" . $this->conn->connect_error);
        }
        
        $sql = "SELECT p.projectId, p.projectTitle, pub.userName, p.date, p.projDesc, p.logoImage, p.author FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId GROUP BY pub.projectId ORDER BY p.date DESC";
        
        
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }
    
    public function sortedQuery_time($time)
    {
        if ($this->conn->connect_error) {
            die("Connection failed:" . $this->conn->connect_error);
        }
        if ($time == "Newest") {
            
            $sql = "SELECT p.projectId, p.projectTitle, pub.userName, p.date, p.projDesc, p.logoImage, p.author FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId GROUP BY pub.projectId ORDER BY p.date DESC";
            
            
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        if ($time == "Oldest") {
            
            $sql = "SELECT p.projectId, p.projectTitle, pub.userName, p.date, p.projDesc, p.logoImage, p.author FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId GROUP BY pub.projectId ORDER BY p.date ASC";
            
            
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
    }
    
    public function sortedQuery_types($type)
    {
        if ($this->conn->connect_error) {
            die("Connection failed:" . $this->conn->connect_error);
        }
        
        $sql = $sql = "SELECT p.projectId, p.projectTitle, pub.userName, p.date, p.projDesc, p.logoImage, p.author FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId AND p.projType = \"$type\" GROUP BY pub.projectId ORDER BY p.date DESC";
        
        
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }
    
    public function sortedQuery_search($search)
    {
        if ($this->conn->connect_error) {
            die("Connection failed:" . $this->conn->connect_error);
        }
        
        $sql = $sql = "SELECT * FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId AND p.projectTitle LIKE \"%$search%\" GROUP BY pub.projectId ORDER BY p.date DESC";
        
        
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }
}