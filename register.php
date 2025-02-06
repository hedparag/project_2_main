<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <?php include "./templates/header.php"; ?>
    <?php include "./include/config.php";
    echo $navbarLogoutScr;

    $error = '';
    $fullname = $email = $phone = $dob = $salary = $position_id = $department_id = $emp_details = $skills = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullname = pg_escape_string($_POST['fullname']);
        $email = pg_escape_string($_POST['email']);
        $phone = pg_escape_string($_POST['phone']);
        $dob = pg_escape_string($_POST['dob']);
        $salary = (float)$_POST['salary'];
        $position_id = (int)$_POST['position'];
        $department_id = (int)$_POST['department'];
        $emp_details = pg_escape_string($_POST['emp_details']);
        $skills = pg_escape_string($_POST['skills']);
        $status = 'f';

        if (empty($error)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $profile_image = null;
            if (!empty($_FILES["profile_img"]["name"])) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["profile_img"]["name"]);
                move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file);
                $profile_image = pg_escape_string($target_file);
            }

            $insert_employee_query = "
            INSERT INTO employees (
            user_type_id, department_id, position_id, employee_name, employee_email, employee_phone, salary, profile_image, employee_details, employee_skils, dob, status
        ) 
        VALUES (
            0,
            $department_id,
            $position_id,
            '$fullname', 
            '$email', 
            '$phone', 
            $salary, 
            '$profile_image', 
            '$emp_details', 
            '$skills', 
            '$dob', 
            'f'
        ) RETURNING employee_id;";

            $insert_employee = pg_query($conn, $insert_employee_query);

            if ($insert_employee) {
                $employee_id = pg_fetch_result($insert_employee, 0, 'employee_id');

                $insert_user_query =
                    "INSERT INTO users (
                    employee_id, user_type_id, full_name, username, status
                ) 
                VALUES (
                    $employee_id,
                    1,
                    '$fullname', 
                    '$email', 
                    'f'
                );";


                $insert_user = pg_query($conn, $insert_user_query);

                if ($insert_user) {
                    echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
                    header("location: verification-pending.php");
                    exit;
                } else {
                    $error = "User registration failed.";
                }
            } else {
                $error = "Employee registration failed.";
            }
        }
    }

    if (!empty($error)) {
        echo "<script>alert('$error'); window.location.href='register.php';</script>";
    }

    ?>


    <div class="container flex-grow-1 py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Create Account</h2>
                        <form action="register.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-Mail</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Mobile Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your mobile number" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-calendar"></i></span>
                                            <input type="date" class="form-control" id="dob" name="dob" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="salary" class="form-label">Salary</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-dollar-sign"></i></span>
                                            <input type="number" class="form-control" id="salary" name="salary" placeholder="Enter your salary in INR" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="profile_img" class="form-label">Profile Picture</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-image"></i></span>
                                            <input type="file" class="form-control" id="profile_img" name="profile_img" accept="image/*" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Position</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-briefcase"></i></span>
                                            <select class="form-select" id="position" name="position" required>
                                                <option value="">-- Select Position --</option>
                                                <?php
                                                $query1 = "SELECT * FROM positions WHERE status = 't'";
                                                $result = pg_query($conn, $query1);
                                                while ($data = pg_fetch_assoc($result)) {
                                                    echo "<option value='{$data['position_id']}'>{$data['position_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="department" class="form-label">Department</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-building"></i></span>
                                            <select class="form-select" id="department" name="department" required>
                                                <option value="">-- Select Department --</option>
                                                <?php
                                                $query1 = "SELECT * FROM departments WHERE status = 't'";
                                                $result = pg_query($conn, $query1);
                                                while ($data = pg_fetch_assoc($result)) {
                                                    echo "<option value='{$data['department_id']}'>{$data['department_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="emp_details" class="form-label">Employee Details</label>
                                        <textarea class="form-control" id="emp_details" name="emp_details" rows="6" placeholder="Write a short bio about yourself"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="skills" class="form-label">Skills</label>
                                        <textarea class="form-control" id="skills" name="skills" rows="3" placeholder="Enter skills separated by commas"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus me-1"></i> Register</button>
                                    </div>
                                    <p class="text-center mt-3 mb-0">
                                        Already have an account? <a href="index.html" class="text-decoration-none">Login here</a>
                                    </p>
                                </div>
                            </div>
                        </form>

                        <script>
                            function togglePassword(fieldId) {
                                const field = document.getElementById(fieldId);
                                field.type = field.type === "password" ? "text" : "password";
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "./templates/footer.php"; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>