<?php
session_start();

class DatabaseConnection {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function closeConnection() {
        $this->conn->close();
    }

    
    public function authenticateUser($username, $password, $role) {
        $username = $this->conn->real_escape_string($username);
        $password = $this->conn->real_escape_string($password);
        
        if ($role == "admin") {
            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        } elseif ($role == "teacher") {
            $query = "SELECT * FROM teachers WHERE Username = '$username' AND Password = '$password'";
        } else {
            return false;  // Invalid role
        }
        
        $result = $this->conn->query($query);
    return $result->num_rows === 1;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $host = "localhost";
    $database = "ses_db";
    $user = "root";
    $password_db = "";

    $db = new DatabaseConnection($host, $user, $password_db, $database);

    if ($db->authenticateUser($username, $password, $_POST["role"])) {
        // Authentication successful, set a session variable and redirect to "homedashboard.html"
        $_SESSION['username'] = $username;
        
        if ($_POST["role"] == "teacher") {
            $_SESSION["role"] = "teacher";
            header("Location: teacherdashboard.php");
        } else {
            $_SESSION["role"] = "admin";
            header("Location: homedashboard.php");
        }
    
        exit();
    } else {
        $error = "Invalid username or password";
    }

    $db->closeConnection();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aupics/logo.png">
    <link rel="stylesheet" href="login.css">
    <title>Log-in Student Evaluation</title>
</head>
<style>
    marquee{
        display: inline-block;
        width: 200px;
        height: 300px;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        border-radius: 10px;
    }

    .modal-content input {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
    }

    .modal-content button {
        background-color: rgb(1, 46, 95);
        color: white;
        border: none;
        padding: 10px;
        margin-top: 10px;
    }
    #closeModalBtn {
        cursor: pointer;
    }
</style>
<body>
<main>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="card">
            <img class="logo" src="./aupics/logo.png">
            <h2>Admin</h2> <br>
            <h1>Student Evaluator System</h1>
            <div class="user-input">
                
<select name="role">
    <option value="admin">Admin</option>
    <option value="teacher">Teacher</option>
</select>
<input id="username" name="username" placeholder="Username" type="text"/>
                <input id="password" name="password" placeholder="Password" type="password"/>
                <div style="width: 100%; text-align: center;">
                    <input name="submit" id="submit" type="submit" value="Log-in"/>
                </div>
            </div>
            <input id="studentID" name="studentID" placeholder="Enter ID Number" style="display: none;" type="text"/>
        </div>
    </form>

    <?php //DARK LORD EASTER EGG username - keyword = SUMMON DARK LORD
        if(isset($_POST['submit']) && $_POST['role'] == "teacher") {
        if($username == "SUMMON DARK LORD"){
    ?>
        <marquee behavior="" direction="down" style="display: inline-block; scrollamount: 20;">
            <a href="https://www.facebook.com/mikel.legaspi.9" target="_blank">
                <img src="dark-lord.jpg" alt="Dark Lord" style="width: 200px;">
            </a>
        </marquee>
    <?php }}?>

    <?php //MAAM AIRA EASTER EGG username-keyword = SUMMON MAAM AIRA
        if(isset($_POST['submit']) && $_POST['role'] == "teacher") {
        if($username == "SUMMON MAAM AIRA"){
    ?>
        <marquee behavior="" direction="down" style="display: inline-block; scrollamount: 20;">
            <a href="https://www.facebook.com/aira.lucero.165" target="_blank">
                <img src="aira.png" alt="Aira" style="width: 200px;">
            </a>
        </marquee>
    <?php }}?>
    
</main>
</body>
</html>