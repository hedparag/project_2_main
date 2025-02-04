<pre>
<?php

if ($_POST) {
    print_r($_POST);
    # code...
}
?>
</pre>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<?php
include "./include/config.php"; // Ensure this includes the $conn variable for pg_connect

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs 
    $fullname = pg_escape_string($conn, $_POST["fullname"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phone = pg_escape_string($conn, $_POST["phone"]);
    $dob = pg_escape_string($conn, $_POST["dob"]);
    $salary = pg_escape_string($conn, $_POST["salary"]);
    $emp_details = pg_escape_string($conn, $_POST["emp_details"]);
    $skills = pg_escape_string($conn, $_POST["skills"]);
    $position = pg_escape_string($conn, $_POST["position"]);
    $department = pg_escape_string($conn, $_POST["department"]);

    // Validate email format
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     echo "Invalid email format.";
    //     exit;
    // }

    // // Validate password match
    // if ($_POST["password"] !== $_POST["rpassword"]) {
    //     echo "Passwords do not match.";
    //     exit;
    // }

    // // Hash the password securely
    // $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    // // Handle file upload
    // $targetFile = null; // Default if no file uploaded
    // if (isset($_FILES["profile_img"]) && $_FILES["profile_img"]["error"] == 0) {
    //     $profileImgName = basename($_FILES["profile_img"]["name"]);
    //     $targetDir = "uploads/";
    //     $targetFile = $targetDir . $profileImgName;

    //     // Check file type
    //     $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    //     if (!in_array($fileType, ["jpg", "jpeg", "png"])) {
    //         echo "Only JPG, JPEG, and PNG files are allowed.";
    //         exit;
    //     }

    //     // Move uploaded file to target directory
    //     if (!move_uploaded_file($_FILES["profile_img"]["tmp_name"], $targetFile)) {
    //         echo "Error uploading profile image.";
    //         exit;
    //     }
    // }

    // // Begin database transaction
    // pg_query($conn, "BEGIN");

    // try {
    //     // Validate department existence
    //     $departmentQuery = "SELECT department_id FROM departments WHERE department_name = $1";
    //     $departmentResult = pg_query_params($conn, $departmentQuery, [$department]);
    //     if (pg_num_rows($departmentResult) === 0) {
    //         throw new Exception("Error: Department not found.");
    //     }
    //     $departmentRow = pg_fetch_assoc($departmentResult);
    //     $departmentId = $departmentRow['department_id'];

    //     // Validate position existence
    //     $positionQuery = "SELECT position_id FROM positions WHERE position_name = $1";
    //     $positionResult = pg_query_params($conn, $positionQuery, [$position]);
    //     if (pg_num_rows($positionResult) === 0) {
    //         throw new Exception("Error: Position not found.");
    //     }
    //     $positionRow = pg_fetch_assoc($positionResult);
    //     $positionId = $positionRow['position_id'];

    //     // Insert into employees table
    //     // $employeeQuery = "
    //     //     INSERT INTO employees (user_type_id, employee_email, employee_phone, dob, salary, profile_image, employee_details, employee_skils, position_id, department_id, status)
    //     //     VALUES (
    //     //         2, 
    //     //         $1, 
    //     //         $2, 
    //     //         $3, 
    //     //         $4, 
    //     //         $5, 
    //     //         $6, 
    //     //         $7, 
    //     //         $8, 
    //     //         $9, 
    //     //         TRUE
    //     //     ) RETURNING employee_id";

    //     // $employeeResult = pg_query_params($conn, $employeeQuery, [
    //     //     $email,
    //     //     $phone,
    //     //     $dob,
    //     //     $salary,
    //     //     $targetFile,
    //     //     $emp_details,
    //     //     $skills,
    //     //     $positionId,
    //     //     $departmentId
    //     // ]);

    //     // if (!$employeeResult) {
    //     //     throw new Exception("Error inserting into employees table: " . pg_last_error($conn));
    //     // }

    //     // $employeeId = pg_fetch_result($employeeResult, 0, "employee_id");

    //     // // Insert into users table
    //     // $userQuery = "
    //     //     INSERT INTO users (fullname, password, full_name, user_type_id, employee_id, status)
    //     //     VALUES (

    //     //     )";

    //     // $userResult = pg_query_params($conn, $userQuery, [
    //     //     $email,
    //     //     $password,
    //     //     $fullname,
    //     //     $employeeId
    //     // ]);

    //     // if (!$userResult) {
    //     //     throw new Exception("Error inserting into users table: " . pg_last_error($conn));
    //     // }

    //     // Commit transaction
    //     pg_query($conn, "COMMIT");

    //     echo "Registration successful! Your account is active.";
    // } catch (Exception $e) {
    //     // Rollback transaction in case of error
    //     pg_query($conn, "ROLLBACK");
    //     echo $e->getMessage();
    // }
}
?>





<body>

    <?php
    include "templates/header.php"
    ?>
    <div class="container">
        <h1>Register</h1>
        <div class="register-container animated fadeIn">
            <form class="register-form" action="register.php" method="POST">
                <div class="form-group">
                    <label for="fullname">Full Name :</label>
                    <input type="text" placeholder="Full Name" id="fullname" name="fullname">
                </div>
                <div class="form-group">
                    <label for="email">E-Mail :</label>
                    <input type="email" placeholder="E-Mail" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="phone">Mobile Number :</label>
                    <input type="phone" placeholder="Mobile Number" id="phone" name="phone">
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" name="dob" id="dob">
                </div>
                <div class="form-group">
                    <label for="salary">Salary :</label>
                    <input type="text" placeholder="Salary per annum" id="salary" name="salary">
                </div>
                <div class="form-group">
                    <label for="profile_img">Profile Picture</label>
                    <input type="file" name="profile_img" id="profile_img">
                </div>
                <div class="form-group">
                    <label for="password">Password :</label>
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="rpassword">Repeat Password :</label>
                    <input type="password" name="rpassword" id="rpassword" placeholder="Repeat Password">
                </div>
                <div class="form-group">
                    <label for="emp_details">Employee Details :</label>
                    <textarea id="emp_details" name="emp_details" placeholder="Write about you in short"></textarea>
                </div>
                <div class="form-group">
                    <label for="skills">Skills :</label>
                    <textarea id="skills" name="skills" placeholder="Skills separated by comma"></textarea>
                </div>

                <div class="form-group">
                    <label for="position">Position :</label><br>
                    <select class="dropdown" id="position" name="position" name="">
                        <option disabled selected>Select Position</option>
                        <option value="Director">Director</option>
                        <option value="Manager">Manager</option>
                        <option value="Team Leader">Team Leader</option>
                        <option value="Senior Specialist">Senior Specialist</option>
                        <option value="Specialist">Specialist</option>
                        <option value="Associate">Associate</option>
                        <option value="Analyst">Analyst</option>
                        <option value="Coordinator">Coordinator</option>
                        <option value="Intern">Intern</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="department">Department :</label><br>
                    <select class="dropdown" id="department" name="department" name="">
                        <option value="">-- Select Department --</option>
                        <?php
                        $query1 = "SELECT * FROM departments WHERE status = 't'";

                        $result = pg_query($conn, $query1);

                        while ($data = pg_fetch_assoc($result)) {
                        ?>
                            <option value="<?= $data['department_id'] ?>"><?= $data['department_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group" style="flex: 1 1 100%;">
                    <button type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>
    <?php
    include "templates/footer.php"
    ?>

</body>

</html>