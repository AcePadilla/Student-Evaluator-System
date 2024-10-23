
<?php
include('dbconnect.php');

function addTeacher($conn, $firstName, $lastName, $subject, $username, $password) {
    
    $sql = "INSERT INTO teachers (FirstName, LastName, subject_code, Username, Password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $firstName, $lastName, $subject, $username, $password);
    $stmt->execute();
}

function deleteTeacher($conn, $teacherId) {
    $sql = "DELETE FROM teachers WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $teacherId);
    $stmt->execute();
}

function getTeachers($conn) {
    $sql = "SELECT * FROM teachers";
    $result = $conn->query($sql);
    return $result;
}

function editTeacher($conn, $teacherId, $firstName, $lastName, $subject_code, $username, $password) {
    
    $sql = "UPDATE teachers SET FirstName=?, LastName=?, subject_code=?, Username=?, Password=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $firstName, $lastName, $subject_code, $username, $password, $teacherId);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        addTeacher($conn, $_POST["firstName"], $_POST["lastName"], $_POST["subject"], $_POST["username"], $_POST["password"]);
    } elseif (isset($_POST["edit"])) {
        editTeacher($conn, $_POST["teacherId"], $_POST["firstName"], $_POST["lastName"], $_POST["subject"], $_POST["username"], $_POST["password"]);
    } elseif (isset($_POST["delete"])) {
        deleteTeacher($conn, $_POST["teacherId"]);
    }
}


$teachers = getTeachers($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aupics/logo.png">
    <link rel="stylesheet" href="subject.css">
    <title>Student Evaluator System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>

<script>
function editTeacherData(button) {
    // Get the row of the clicked button
    let row = button.closest('tr');
    
    // Fetch data from the row
    let firstName = row.querySelector('td:nth-child(1)').innerText;
    let lastName = row.querySelector('td:nth-child(2)').innerText;
    let subjectCode = row.querySelector('td:nth-child(3)').innerText;
    let username = row.querySelector('td:nth-child(4)').innerText;
    
    // Populate the form fields with the fetched data
    document.querySelector('input[name="firstName"]').value = firstName;
    document.querySelector('input[name="lastName"]').value = lastName;
    document.querySelector('select[name="subject"]').value = subjectCode;
    document.querySelector('input[name="username"]').value = username;
    
    // We don't fetch the password since it's masked. The user will need to re-enter it if they wish to change.
    // Populate the hidden input field with the teacher's ID
    document.querySelector('input[name="teacherId"]').value = button.closest('td').querySelector('input[name="teacherId"]').value;
    
    // Show the "Save Changes" button and hide the "Add Teacher" button
    document.getElementById('saveChangesBtn').style.display = 'block';
    button.closest('section').querySelector('button[name="add"]').style.display = 'none';

}
</script>
</head>
<style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        section h1{
            margin:10px auto;
            text-align:center;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center; 
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td button {
            padding: 5px 10px;
            background-color: #2628DE;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            font-size: 14px;
            margin-right: 5px;
        }

        td #delete {
            background-color: #CF1111 ;
        }

        th, td, td button {
            text-align: center; 
        }
        th{
            background-color: #0081fa;
            color:white;
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
            background-color: #ffffff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #ccc;
            width: 60%;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .close {
            float: right;
            cursor: pointer;
            font-size: 20px;
            color: #999;
        }

        .close:hover {
            color: #333;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button#saveEdit {
            background-color: #0081fa;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        button#saveEdit:hover {
            background-color: #0058b6;
        }

        #addNewSubjectBtn {
        background-color: #0081fa;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        }

        #addNewSubjectBtn:hover {
            background-color: #0058b6;
        }
        .save-button {
            background-color: #0081fa;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s; /* Add a transition for hover effect */
        }

        .save-button:hover {
            background-color: #0058b6;
        }
        section {
            padding: 20px; /* Add some padding to the section */
            margin: 20px; /* Add margin around the section */
        }

        /* Style for the "Add Teacher" form */
        form {
            padding: 20px; /* Add some padding */
            border-radius: 10px; /* Rounded corners for the form */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for the form */
        }

        /* Style for the table */
        table {
            border-radius: 10px; /* Rounded corners for the table */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for the table */

        }
        section {
            max-width: 100%; /* Set a maximum width for the section */
            margin: 20px auto; /* Center the section horizontally and add some space */
            padding: 20px; /* Add some padding to the section */
            background-color: #f7f7f7; /* Set a background color */
            border-radius: 10px; /* Add rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            
        }

        /* Additional style for the form inside the section */
        section form {
            background-color: #fff; /* White background for the form */
            padding: 20px; /* Add some padding */
            border-radius: 10px; /* Rounded corners for the form */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for the form */
        }

        /* Additional styles for the table inside the section */
        section table {
            background-color: #fff; /* White background for the table */
            border-radius: 10px; /* Rounded corners for the table */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for the table */
    
        }
        #editbutton{
            background-color: #0081fa;
            padding:5px 18px;
        }
        #editbutton:hover {
            background-color: #00356e;
            transition: ease-in-out 0.3s;
        }
        #deletebutton{
            background-color: rgb(255, 18, 18);
        }
        #deletebutton:hover {
        background-color: rgb(135, 0, 0);
        transition: ease-in-out 0.3s;
        }
        .button {
        position: relative;
        width: 150px;
        height: 40px;
        cursor: pointer;
        display: flex;
        align-items: center;
        border: 1px solid #0081fa;
        background-color: #0081fa;
        }

        .button, .button__icon, .button__text {
        transition: all 0.3s;
        }

        .button .button__text {
        transform: translateX(30px);
        color: #fff;
        font-weight: 600;
        }

        .button .button__icon {
        position: absolute;
        transform: translateX(109px);
        height: 100%;
        width: 39px;
        background-color: #0081fa;
        display: flex;
        align-items: center;
        justify-content: center;
        }

        .button .svg {
        width: 30px;
        stroke: white;
        }

        .button:hover {
        background: #0081fa;
        }

        .button:hover .button__text {
        color: transparent;
        }

        .button:hover .button__icon {
        width: 148px;
        transform: translateX(0);
        }

        .button:active .button__icon {
        background-color: #0081fa;
        }

        .button:active {
        border: 1px solid #0081fa;
        }

       

        input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        font-size: 16px;
        outline: none; /* Remove input field outline */
    }
    .inputbox {
    position: relative;
    width: 100%;
    margin-bottom:15px;
    }

    .inputbox input {
    position: relative;
    width: 100%;
    padding: 20px 10px 10px;
    background: transparent;
    outline: none;
    box-shadow: none;
    border: none;
    color: white;
    font-size: 1em;
    letter-spacing: 0.05em;
    transition: 0.5s;
    z-index: 10;
    }

    .inputbox span {
    position: absolute;
    left: 0;
    padding: 20px 10px 10px;
    font-size: 1em;
    color: #8f8f8f;
    letter-spacing: 00.05em;
    transition: 0.5s;
    pointer-events: none;
    }

    .inputbox input:valid ~span,
    .inputbox input:focus ~span {
    color: black;
    transform: translateX(-10px) translateY(-34px);
    font-size: 0,75em;
    }

    .inputbox i {
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 2px;
    background: #0081fa;
    border-radius: 4px;
    transition: 0.5s;
    pointer-events: none;
    z-index: 9;
    }

    .inputbox input:valid ~i,
    .inputbox input:focus ~i {
    height: 44px;
    background: #0081fa;
    }
    
    .subs{
        margin:30px auto;
    }
</style>
<body>
    <nav>
        <button type="button" id="toggle-btn">
            <i class="fa fa-bars"></i>
        </button>
        <div class="admin">
            <img src="aupics/logo.png">
            <span>Admin</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="homedashboard.php"><i class="fa-solid fa-chart-line" style="color: white;"></i>Dashboard</a></li>
            <li><a href="teachers.php"><i class="fa-solid fa-glasses" style="color: white;"></i>Teachers</a></li>
            <li><a href="classes.php"><i class="fa-solid fa-chalkboard" style="color: white;"></i>Classes</a></li>
            <li><a href="subjects.php"><i class="fa-solid fa-book-open" style="color: white;"></i>Subjects</a></li>
            <li><a href="student.php"><i class="fa-solid fa-user-group" style="color: white;"></i>Students</a></li>
            <li><a href="enroll_student.php"><i class="fa-solid fa-user-plus" style="color: white;"></i>Enroll Subjects</a></li>
            <li><a href="result.php"><i class="fa-solid fa-square-poll-vertical" style="color: white;"></i>Results</a></li>
            <li> <a href="login.php"><i class="fa-solid fa-right-from-bracket" style="color: white;"></i>Log-out</a></li>
        </ul>
    </nav>
<section>
    <h2><i class="fa-solid fa-book-open" style="color: #0081fa;"></i>Teachers</h2>
    <h1>Manage Teachers</h1>
   
                        
    <form action="" method="POST"><input type="hidden" name="teacherId" value="">
        <div class="inputbox">
            <input type="text" name="firstName" required>
            <span>First Name</span>
            <i></i>
        </div>

        <div class="inputbox">
            <input  type="text" name="lastName" required>
            <span>Last Name</span>
            <i></i>
        </div>
    <div class=subs>
        <label for="subject">Subject:</label>       
        <select name="subject" required>
            <?php
            $subject_result = $conn->query("SELECT subject_code FROM subjects");  # Placeholder table name
            while($row = $subject_result->fetch_assoc()) {
                echo '<option value="' . $row["subject_code"] . '">' . $row["subject_code"] . '</option>';
            }
            ?>
        </select>
    </div>

        <div class="inputbox">
            <input type="text" name="username" required>
            <span>Username</span>
            <i></i>
        </div>

        <div class="inputbox">
            <input type="text" name="password" required>
            <span>Password</span>
            <i></i>
        </div>

        <button type="submit" class="button" name="add">
        <span class="button__text">Add Teacher</span>
        <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
</button>   <button type="submit" name="edit" id="saveChangesBtn" style="display: none;">Save Changes</button>

        
       
    </form>
    
    
       
     <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Subject Code</th>
                <th>Username</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($teacher = $teachers->fetch_assoc()): ?>
                <tr>
                    <td><?= $teacher["FirstName"] ?></td>
                    <td><?= $teacher["LastName"] ?></td>
                    <td><?= $teacher["subject_code"] ?></td>
                    <td><?= $teacher["Username"] ?></td>
                    <td>••••••••</td>
                    <td>
                        <button onclick="editTeacherData(this)" id="editbutton">Edit</button>
                        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                            <input type="hidden" name="teacherId" value="<?= $teacher["id"] ?>">
                            <button type="submit" id="deletebutton" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </section>
    
</body>
<script>
    const nav = document.querySelector('nav');
    const toggle_btn = document.getElementById('toggle-btn');
    const content = document.querySelector('section');

    toggle_btn.onclick = function() {
    nav.classList.toggle('hide');
    content.classList.toggle('expand');
    };
</script>
</html>
