<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aupics/logo.png">
    <link rel="stylesheet" href="homedashboard.css">
    <title>Student Evaluator System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
</head>
<style>
    .input-label {
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }

    .select-box {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    .input-label {
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }

    .select-box {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    .enroll-button {
        background-color: #007BFF;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .enroll-button:hover {
        background-color: #0056b3;
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
            <li><a href="login.php"><i class="fa-solid fa-right-from-bracket" style="color: white;"></i>Log-out</a></li>
        </ul>
    </nav>
    <section>
        <h2><i class="fa-solid fa-user-plus" style="color:#0081fa;"></i>Enroll Subjects</h2>

        <?php
       $conn = mysqli_connect("localhost", "root", "", "ses_db");
       if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
       }
       
       $error_message = "";
       
       // Fetch all students
       $students_query = "SELECT * FROM student";
       $students_result = mysqli_query($conn, $students_query);
       $students = mysqli_fetch_all($students_result, MYSQLI_ASSOC);
       
       // Fetch all subjects
       $subjects_query = "SELECT * FROM subjects";
       $subjects_result = mysqli_query($conn, $subjects_query);
       $subjects = mysqli_fetch_all($subjects_result, MYSQLI_ASSOC);
       
       // Handle removal of subjects
       if (isset($_POST["action"]) && $_POST["action"] == "remove") {
           $remove_subject_query = "DELETE FROM enrollments 
                                    WHERE student_id='$_POST[student_id]' 
                                    AND subject_code='$_POST[remove_subject_code]'";
           mysqli_query($conn, $remove_subject_query);
           echo "Subject removed successfully!";
       }
       
       // Handle form submission for enrollment
       if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST["action"]) || $_POST["action"] != "remove")) {
           $student_id = $_POST["student_id"];
           if (isset($_POST["subjects"])) {
               $selected_subjects = $_POST["subjects"];
               foreach ($selected_subjects as $subject_code) {
                   // Check if student is already enrolled in the subject
                   $check_enrollment_query = "SELECT * FROM enrollments WHERE student_id='$student_id' AND subject_code='$subject_code'";
                   $check_enrollment_result = mysqli_query($conn, $check_enrollment_query);
                   if (mysqli_num_rows($check_enrollment_result) > 0) {
                       // Skip if already enrolled
                       echo "Subject Already Enrolled!";
                       continue;
                   } else {
                       $enroll_query = "INSERT INTO enrollments (student_id, subject_code) VALUES ('$student_id', '$subject_code')";
                       mysqli_query($conn, $enroll_query);
                       echo "Student enrolled successfully!";
                   }
               }
           } else {
               $error_message = "Please select at least one subject to enroll!";
           }
       }
       
       // If a student is selected, fetch the subjects they are enrolled in
       if (isset($_POST["student_id"])) {
           $enrolled_subjects_query = "SELECT subjects.subject_description, subjects.subject_code 
                                       FROM enrollments 
                                       JOIN subjects ON enrollments.subject_code = subjects.subject_code 
                                       WHERE enrollments.student_id = '$_POST[student_id]'";
           $enrolled_subjects_result = mysqli_query($conn, $enrolled_subjects_query);
           $enrolled_subjects = mysqli_fetch_all($enrolled_subjects_result, MYSQLI_ASSOC);
       }
       ?>
       
       <?php if ($error_message != "") { ?>
           <div style="color:red;"><?php echo $error_message; ?></div>
           <br>
       <?php } ?>
       
       <form method="post">
           <label>Select Student:</label>
           <select name="student_id">
               <?php foreach ($students as $student) { ?>
                   <option value="<?php echo $student['student_id']; ?>">
                       <?php echo $student['fname'] . " " . $student['lname']; ?>
                   </option>
               <?php } ?>
           </select>
       
           <br><br>
       
           <label>Select Subjects:</label>
           <br>
           <?php foreach ($subjects as $subject) { ?>
               <input type="checkbox" name="subjects[]" value="<?php echo $subject['subject_code']; ?>">
               <?php echo $subject['subject_description']; ?>
               <br>
           <?php } ?>
           
           <br>
           <input type="submit" value="Enroll">
       </form>
       
       <br><br>
       <label>Enrolled Subjects:</label>
       <ul>
           <?php if (isset($enrolled_subjects) && !empty($enrolled_subjects)) {
               foreach ($enrolled_subjects as $subject) { ?>
                   <li>
                       <?php echo $subject['subject_description']; ?>
                       <form method="post" style="display:inline;">
                           <input type="hidden" name="student_id" value="<?php echo $_POST['student_id']; ?>">
                           <input type="hidden" name="action" value="remove">
                           <input type="hidden" name="remove_subject_code" value="<?php echo $subject['subject_code']; ?>">
                           <input type="submit" value="Remove">
                       </form>
                   </li>
               <?php }
           } else {
               echo "<li>No subjects enrolled</li>";
           } ?>
       </ul>
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
    function validateCheckboxes() {
    var checkboxes = document.querySelectorAll('input[name="subjects[]"]');
    var checked = false;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked = true;
            break;
        }
    }
    if (!checked) {
        alert('Please select at least one subject.');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}

    
</script>


</html>
