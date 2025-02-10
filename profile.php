<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './templates/meta-info.php'; ?>
    <title>Profile | EMS</title>
</head>

<body class="d-flex flex-column min-vh-100" style="background-image: url('https://img.freepik.com/free-vector/blue-pink-halftone-background_53876-99004.jpg'); background-size: cover; background-position: center; font-family: poppins;">

    <?php
    include './templates/header.php';

    if (!isset($_SESSION["user_type_id"])) {
        header("location: login.php");
        exit();
    }

    $employee_id = $_SESSION['employee_id'];
    // Pre-define $current_password from POST (using the same key as in your password form)
    $current_password = $_POST['current-password'] ?? '';

    $query = "SELECT * FROM employees WHERE employee_id=$1";
    $result = pg_query_params($conn, $query, [$employee_id]);

    if (!$result || pg_num_rows($result) == 0) {
        die("Employee not found.");
    }

    $employee = pg_fetch_assoc($result);

    // Determine which form is being submitted based on the presence of current-password
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !$current_password) {
        // ----------- PROFILE UPDATE -----------
        $fullname      = isset($_POST['fullname']) ? pg_escape_string($_POST['fullname']) : "";
        $email         = isset($_POST['email']) ? pg_escape_string($_POST['email']) : "";
        $phone         = isset($_POST['phone']) ? pg_escape_string($_POST['phone']) : "";
        $dob           = isset($_POST['dob']) ? pg_escape_string($_POST['dob']) : "";
        $salary        = isset($_POST['salary']) ? (float)$_POST['salary'] : 0.0;
        $position_id   = isset($_POST['position']) ? (int)$_POST['position'] : 0;
        $department_id = isset($_POST['department']) ? (int)$_POST['department'] : 0;
        $emp_details   = isset($_POST['emp_details']) ? pg_escape_string($_POST['emp_details']) : "";
        $skills        = isset($_POST['skills']) ? pg_escape_string($_POST['skills']) : "";

        $profile_image = null;
        if (!empty($_FILES["profile_img"]["name"])) {
            $target_dir  = "uploads/";
            $target_file = $target_dir . basename($_FILES["profile_img"]["name"]);
            if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file)) {
                $profile_image = pg_escape_string($target_file);
            } else {
                $error = "Failed to upload profile image.";
            }
        }

        if (empty($error)) {
            // Build the employee update query
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

            $update_employee = pg_query($conn, $update_query);

            if ($update_employee) {
                // Update the user info (excluding password change)
                $update_user_query = "
                UPDATE users SET 
                    full_name = '$fullname',
                    username = '$email'
                WHERE employee_id = $employee_id";
                $update_user = pg_query($conn, $update_user_query);

                if ($update_user) {
                    echo "<script>alert('Update successful!'); window.location.href='profile.php';</script>";
                    exit;
                } else {
                    $error = "User update failed.";
                }
            } else {
                $error = "Employee update failed.";
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && $current_password) {
        // ----------- PASSWORD UPDATE -----------
        $new_password     = $_POST['new-password'] ?? "";
        $confirm_password = $_POST['confirm-password'] ?? "";

        $uquery  = 'SELECT password FROM users WHERE employee_id=$1;';
        $uresult = pg_query_params($conn, $uquery, [$employee_id]);

        if ($uresult && pg_num_rows($uresult) > 0) {
            $row = pg_fetch_assoc($uresult);
            $hashed_password = $row['password'];

            if (password_verify($current_password, $hashed_password)) {
                if ($new_password === $confirm_password) {
                    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                    $update_query  = 'UPDATE users SET password=$1 WHERE employee_id=$2;';
                    $update_result = pg_query_params($conn, $update_query, [$new_hashed_password, $employee_id]);

                    if ($update_result) {
                        echo "<script>alert('Password updated successfully'); window.location.href='profile.php';</script>";
                    } else {
                        echo "<script>alert('Error updating password');</script>";
                    }
                } else {
                    echo "<script>alert('New password and confirm password do not match');</script>";
                }
            } else {
                echo "<script>alert('Current password is incorrect');</script>";
            }
        } else {
            echo "<script>alert('User not found');</script>";
        }
    }
    ?>

    <!-- Main Content -->
    <div class="container flex-grow-1 py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Profile Header -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="position-relative">
                                    <img src="<?= $_SESSION['profile_image'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION["employee_name"]); ?>" class="rounded-circle me-2" width="128" height="128">
                                    <label for="profile_img" class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm" style="cursor: pointer;">
                                        <i class="fas fa-camera text-primary"></i>
                                        <input type="file" id="profile_img" class="d-none">
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <h2 class="mb-1"><?php echo $employee['employee_name'] ?></h2>
                                <p class="text-muted mb-2"><?php echo "Senior Developer"; ?></p>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-primary">
                                        <?php
                                        $query1 = "SELECT * FROM positions WHERE position_id=$1;";
                                        $presult = pg_query_params($conn, $query1, [$employee['position_id']]);
                                        $pdata = pg_fetch_assoc($presult);
                                        echo $pdata["position_name"];
                                        ?>

                                    </span>
                                    <?php if ($employee['status']) { ?>
                                        <span class="badge bg-success">Active</span><?php } else { ?>
                                        <span class="badge bg-danger">Inactive</span><?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <span class="bg-primary bg-opacity-10 p-2 rounded-circle">
                                    <i class="fas fa-user-circle text-primary"></i>
                                </span>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title mb-0">Personal Information</h5>
                                <small class="text-muted">Update your personal details</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $employee['employee_name'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $employee['employee_email'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $employee['employee_phone'] ?>" required>
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
                                </div>
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
                                        <label for="salary" class="form-label">Salary</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fa-solid fa-indian-rupee-sign"></i>
                                            </span>
                                            <input type="text" class="form-control" id="salary" name="salary" value="<?php echo $employee['salary'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="emp_details" class="form-label">About Me</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-info-circle"></i>
                                            </span>
                                            <textarea class="form-control" id="emp_details" name="emp_details" rows="3"><?php echo $employee['employee_details'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="skills" class="form-label">Skills</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-tools"></i>
                                            </span>
                                            <textarea class="form-control" id="skills" name="skills" rows="3"><?php echo $employee['employee_skils'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-light" onclick="location.href='dashboard.html'">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <span class="bg-warning bg-opacity-10 p-2 rounded-circle">
                                    <i class="fas fa-lock text-warning"></i>
                                </span>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title mb-0">Security Settings</h5>
                                <small class="text-muted">Manage your password</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="current-password" class="form-label">Current Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" name="current-password" id="current-password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="new-password" class="form-label">New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <input type="password" class="form-control" name="new-password" id="new-password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="confirm-password" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-check-double"></i>
                                            </span>
                                            <input type="password" name="confirm-password" class="form-control" id="confirm-password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key me-1"></i>Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include './templates/footer.php';
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>