<?php
include 'dbconnect.php';
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

    public function fetchGPAAndComments($student_id) {
        $student_id = $this->conn->real_escape_string($student_id);
        $query = "SELECT GPA, comments FROM result WHERE student_id = '$student_id'";
        $result = $this->conn->query($query);
        if (!$result) {
            die("SQL Error: " . $this->conn->error);
        }
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function fetchEnrollmentDetails($student_id) {
        $student_id = $this->conn->real_escape_string($student_id);
        $query = "SELECT subject_code, enrollment_date, prelim_grade, midterm_grade, final_grade, average, remarks FROM enrollments WHERE student_id = '$student_id'";
        $result = $this->conn->query($query);
        if (!$result) {
            die("SQL Error: " . $this->conn->error);
        }
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function authenticateUser($student_id) {
        $query = "SELECT student_id FROM student WHERE student_id = '$student_id'";
        $result = $this->conn->query($query);
        if (!$result) {
            die("SQL Error: " . $this->conn->error);
        }
        return $result->num_rows === 1;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];

    $host = "localhost";
    $database = "ses_db";
    $user = "root";
    $password_db = "";

    $dbConnection = new DatabaseConnection($host, $user, $password_db, $database);

    if ($dbConnection->authenticateUser($student_id)) {
        $_SESSION['student_id'] = $student_id;
        header('Location: studentview.php');
        exit();
    } else {
        $_SESSION['error_message'] = 'Invalid student ID';
        header('Location: student_login.php');
        exit();
    }
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
            <h2>Student</h2> <br>
            <h1>Student Evaluator System</h1>
            <div class="user-input">
                <input id="student_id" name="student_id" placeholder="Enter your Student-ID" type="text"/>
                <div style="width: 100%; text-align: center;">
                    <input id="submit" type="submit" value="View Grades"/>
                </div>
            </div>
            <?php
            if (isset($_SESSION['error_message'])) {
                echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
                unset($_SESSION['error_message']);
            }
            ?>
        </div>
    </form>
</main>
</body>
</html>
