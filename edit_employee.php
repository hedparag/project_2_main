<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './templates/meta-info.php'; ?>
    <title>Edit Employee | EMS</title>
</head>

<body class="d-flex flex-column min-vh-100" style="background-image: url('https://img.freepik.com/free-vector/blue-pink-halftone-background_53876-99004.jpg'); background-size: cover; background-position: center; font-family:poppins;"> <!-- Navbar -->
    <?php include "./templates/header.php";
    if (!isset($_SESSION["user_type_id"]) || $_SESSION["user_type_id"] == 0) {
        header("location: login.php");
        exit();
    }

    // Get employee ID from URL parameter
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Invalid Employee ID");
    }

    $employee_id = (int)$_GET['id'];

    // Fetch employee data
    $query = "SELECT * FROM employees WHERE employee_id=$1";
    $result = pg_query_params($conn, $query, [$employee_id]);

    if (!$result || pg_num_rows($result) == 0) {
        die("Employee not found.");
    }

    $employee = pg_fetch_assoc($result);

    $error = "";

    // Handle form submission
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
        $password = $_POST['new_password'];
        $hashed_password = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : null;

        // Profile Image Upload
        $profile_image = null;
        if (!empty($_FILES["profile_img"]["name"])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["profile_img"]["name"]);
            if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file)) {
                $profile_image = pg_escape_string($target_file);
            } else {
                $error = "Failed to upload profile image.";
            }
        }

        if (empty($error)) {
            if (!$password) {
                $update_query = "
                UPDATE employees SET 
                    department_id = $department_id,
                    position_id = $position_id,
                    employee_name = '$fullname',
                    employee_email = '$email',
                    employee_phone = '$phone',
                    salary = $salary,
                    employee_details = '$emp_details',
                    employee_skils = '$skills',
                    dob = '$dob'
                    " . (!empty($profile_image) ? ", profile_image = '$profile_image'" : "") . "
                WHERE employee_id = $employee_id";
            } else {
                $update_query = "
                UPDATE employees SET 
                    department_id = $department_id,
                    position_id = $position_id,
                    employee_name = '$fullname',
                    employee_email = '$email',
                    employee_phone = '$phone',
                    salary = $salary,
                    status='t',
                    employee_details = '$emp_details',
                    employee_skils = '$skills',
                    dob = '$dob'
                    " . (!empty($profile_image) ? ", profile_image = '$profile_image'" : "") . "
                WHERE employee_id = $employee_id";
            }

            $update_employee = pg_query($conn, $update_query);

            if ($update_employee) {
                // Update user credentials if needed
                if (!empty($password)) {
                    $update_user_query = "
                UPDATE users SET 
                    full_name = '$fullname',
                    username = '$email',
                    password = '$hashed_password'
                WHERE employee_id = $employee_id";
                } else {
                    $update_user_query = "
                UPDATE users SET 
                    full_name = '$fullname',
                    username = '$email'
                WHERE employee_id = $employee_id";
                }

                $update_user = pg_query($conn, $update_user_query);

                if ($update_user) {
                    echo "<script>alert('Update successful!'); window.location.href='dashboard.php';</script>";
                    exit;
                } else {
                    $error = "User update failed.";
                }
            } else {
                $error = "Employee update failed.";
            }
        }
    }

    ?>

    <!-- Main Content -->
    <div class="container flex-grow-1 py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                    <i class="fas fa-user-edit fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h2 class="card-title mb-0">Edit Employee</h2>
                                <p class="text-muted mb-0">Update employee information</p>
                            </div>
                        </div>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row g-4">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" value="<?php echo $employee['employee_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-Mail</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" value="<?php echo $employee['employee_email']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Mobile Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Mobile Number" value="<?php echo $employee['employee_phone']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $employee['dob']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="salary" class="form-label">Salary</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fa-solid fa-indian-rupee-sign"></i>
                                            </span>
                                            <input type="text" class="form-control" id="salary" name="salary" placeholder="Salary per annum" value="<?php echo $employee['salary']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label d-block">Current Profile Picture</label>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $employee['profile_image'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($employee['employee_name']); ?>"
                                                class="rounded-circle me-2" width="64" height="64">
                                            <div class="flex-grow-1">
                                                <label for="profile_img" class="form-label mb-0 text-primary" style="cursor: pointer;">
                                                    <i class="fas fa-camera me-1"></i>Change Photo
                                                </label>
                                                <input type="file" class="form-control d-none" id="profile_img" name="profile_img">
                                                <small class="text-muted d-block">Maximum file size: 2MB</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Position</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-briefcase"></i>
                                            </span>
                                            <select class="form-select" id="position" name="position">
                                                <?php
                                                $query1 = "SELECT * FROM positions WHERE status = 't'";
                                                $presult = pg_query($conn, $query1);

                                                while ($pdata = pg_fetch_assoc($presult)) {
                                                    $selected = ($pdata['position_id'] == $employee['position_id']) ? "selected" : "";
                                                    echo "<option value='{$pdata['position_id']}' $selected>{$pdata['position_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="department" class="form-label">Department</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-building"></i>
                                            </span>
                                            <select class="form-select" id="department" name="department">
                                                <?php
                                                $query1 = "SELECT * FROM departments WHERE status = 't'";
                                                $dresult = pg_query($conn, $query1);

                                                while ($ddata = pg_fetch_assoc($dresult)) {
                                                    $selected = ($ddata['department_id'] == $employee['department_id']) ? "selected" : "";
                                                    echo "<option value='{$ddata['department_id']}' $selected>{$ddata['department_name']}</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="emp_details" class="form-label">Employee Details</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-info-circle"></i>
                                            </span>
                                            <textarea class="form-control" id="emp_details" name="emp_details" rows="3" placeholder="Write about employee in short"><?php echo $employee['employee_details']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="skills" class="form-label">Skills</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-tools"></i>
                                            </span>
                                            <textarea class="form-control" id="skills" name="skills" rows="3" placeholder="Skills separated by comma"><?php echo $employee['employee_skils']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password (leave blank to keep current)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="col-12">
                                    <hr class="my-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-light" onclick="location.href='dashboard.html'">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include "./templates/footer.php"; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>