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
</head>
<style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        td{
            font-weight:400;
            font-size:14px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center; 
            font-weight:700;
            font-size:18px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td button {
            padding: 5px 10px;
            background-color:#0081fa;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            font-size: 14px;
            margin-right: 5px;
        }
        td button:hover{
            background-color:#003b73;
            transition: ease-in-out 0.3s;
        }
        
        td #delete {
            background-color: #CF1111 ;
        }
        td #delete:hover{
            background-color:rgb(124, 0, 0);
            transition: ease-in-out 0.3s;
        }

        th, td, td button {
            text-align: center; 
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
        .save-button {
            background-color: #0081fa;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .save-button:hover {
            background-color: #0058b6;
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
        <h2><i class="fa-solid fa-book-open" style="color: #0081fa;"></i> Subjects</h2>
        
        <table>
            <tr>
                <th>Subject Code</th>
                <th>Subject Description</th>
                <th>Action</th>
            </tr>

            <button type="button"  id="addNewSubjectBtn" class="button">
            <span class="button__text">Add Subject</span>
            <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
            </button>


                <div id="addNewSubjectModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="closeAddModal">&times;</span>
                        <h3>Add New Subject</h3>
                        <form id="addNewSubjectForm">
                            <label for="newSubjectCode">Subject Code:</label>
                            <input type="text" id="newSubjectCode" name="subject_code" required>
                            <label for="newSubjectDescription">Subject Description:</label>
                            <input type="text" id="newSubjectDescription" name="subject_description" required>
                            <button type="button" id="saveNewSubject" class="save-button">Save</button>
                        </form>
                    </div>
                </div>


            <?php

            $host = "localhost";
            $database = "ses_db";
            $user = "root";
            $password_db = "";

            $conn = new mysqli($host, $user, $password_db, $database);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT subject_code, subject_description FROM subjects";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["subject_code"] . "</td>
                            <td>" . $row["subject_description"] . "</td>
                            <td>
                            <button onclick='editSubject(\"" . $row["subject_code"] . "\", \"" . $row["subject_description"] . "\")'>Edit</button>
                            <button id='delete' onclick='deleteSubject(\"" . $row["subject_code"] . "\")'>Delete</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No subjects found</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </section>
    <div id="editSubjectModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h3>Edit Subject</h3>
            <form id="editSubjectForm">
                <label for="editSubjectCode">Subject Code:</label>
                <input type="text" id="editSubjectCode" name="subject_code" readonly>
                <label for="editSubjectDescription">Subject Description:</label>
                <input type="text" id="editSubjectDescription" name="subject_description">
                <button type="button" id="saveEdit">Save</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nav = document.querySelector('nav');
            const toggle_btn = document.getElementById('toggle-btn');
            const content = document.querySelector('section');

            toggle_btn.onclick = function () {
                nav.classList.toggle('hide');
                content.classList.toggle('expand');
            };

            const editSubjectModal = document.getElementById('editSubjectModal');
            const closeModalButton = document.getElementById('closeModal');
            const editSubjectForm = document.getElementById('editSubjectForm');

            function editSubject(subjectCode, subjectDescription) {
                editSubjectModal.style.display = 'block';
                document.getElementById('editSubjectCode').value = subjectCode;
                document.getElementById('editSubjectDescription').value = subjectDescription;
            }

            closeModalButton.onclick = function() {
                editSubjectModal.style.display = 'none';
            }

            document.getElementById('saveEdit').addEventListener('click', function() {
                const subjectCode = document.getElementById('editSubjectCode').value;
                const newSubjectDescription = document.getElementById('editSubjectDescription').value;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_subject.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert('Update successful');
                            editSubjectModal.style.display = 'none';

                            location.reload();
                        } else {
                            alert('Update failed');
                        }
                    }
                };

                const data = `subject_code=${subjectCode}&new_subject_description=${newSubjectDescription}`;
                xhr.send(data);
            });
        });

        function deleteSubject(subjectCode) {
            if (confirm('Are you sure you want to delete this subject?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_subject.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert('Delete successful');
                            location.reload();
                        } else {
                            alert('Delete failed');
                        }
                    }
                };

                const data = `subject_code=${subjectCode}`;
                xhr.send(data);
            }
        }

            const addNewSubjectModal = document.getElementById('addNewSubjectModal');
            const closeAddModalButton = document.getElementById('closeAddModal');
            const saveNewSubjectButton = document.getElementById('saveNewSubject');

            document.getElementById('addNewSubjectBtn').addEventListener('click', function() {
        addNewSubjectModal.style.display = 'block';
    });

    closeAddModalButton.onclick = function() {
        addNewSubjectModal.style.display = 'none';
    }

    saveNewSubjectButton.addEventListener('click', function() {
        const newSubjectCode = document.getElementById('newSubjectCode').value;
        const newSubjectDescription = document.getElementById('newSubjectDescription').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_subject.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('New subject added successfully');
                    addNewSubjectModal.style.display = 'none';
                    location.reload(); 
                } else {
                    alert('Failed to add a new subject');
                }
            }
        };

        const data = `subject_code=${newSubjectCode}&subject_description=${newSubjectDescription}`;
        xhr.send(data);
    });
    </script>
    
</body>

<script>
    const nav = document.querySelector('nav');
    const toggle_btn = document.getElementById('toggle-btn');
    const content = document.querySelector('section');

    toggle_btn.onclick = function () {
        nav.classList.toggle('hide');
        content.classList.toggle('expand');
    };

    const editSubjectModal = document.getElementById('editSubjectModal');
    const closeModalButton = document.getElementById('closeModal');
    const editSubjectForm = document.getElementById('editSubjectForm');

    function editSubject(subjectCode, subjectDescription) {
        editSubjectModal.style.display = 'block';
        document.getElementById('editSubjectCode').value = subjectCode;
        document.getElementById('editSubjectDescription').value = subjectDescription;
    }

    closeModalButton.onclick = function() {
        editSubjectModal.style.display = 'none';
    }

    document.getElementById('saveEdit').addEventListener('click', function() {
        editSubjectModal.style.display = 'none';
    });
</script>

</html>
