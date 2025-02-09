<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './templates/meta-info.php'; ?>
    <title>Profile | EMS</title>
</head>

<body class="d-flex flex-column min-vh-100" style="background-image: url('https://img.freepik.com/free-vector/blue-pink-halftone-background_53876-99004.jpg'); background-size: cover; background-position: center;">
    <!-- Navbar -->
    <?php
    include './templates/header.php';

    if (!isset($_SESSION["user_type_id"])) {
        header("location: login.php");
        exit();
    }
    $employee_id = $_SESSION['employee_id'];

    $query = "SELECT * FROM employees WHERE employee_id=$1";
    $result = pg_query_params($conn, $query, [$employee_id]);

    if (!$result || pg_num_rows($result) == 0) {
        die("Employee not found.");
    }

    $employee = pg_fetch_assoc($result);
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
                                    <span class="badge bg-primary">Full-time</span>
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
                        <form>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control" id="fullname" value="<?php echo $employee['employee_name'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control" id="email" value="<?php echo $employee['employee_email'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="tel" class="form-control" id="phone" value="<?php echo $employee['employee_phone'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                            <input type="date" class="form-control" id="dob" value="<?php echo $employee['dob'] ?>">
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
                                            <select class="form-select" id="position" required>
                                                <option value="Senior Developer" selected>Senior Developer</option>
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
                                    </div>
                                    <div class="mb-3">
                                        <label for="department" class="form-label">Department</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-building"></i>
                                            </span>
                                            <select class="form-select" id="department" required>
                                                <option value="IT" selected>Information Technology</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="salary" class="form-label">Salary</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                            <input type="text" class="form-control" id="salary" value="<?php echo $employee['salary'] ?>" required>
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
                                            <textarea class="form-control" id="emp_details" rows="3"><?php echo $employee['employee_details'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="skills" class="form-label">Skills</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-tools"></i>
                                            </span>
                                            <textarea class="form-control" id="skills" rows="3"><?php echo $employee['employee_skils'] ?></textarea>
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
                        <form>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="current-password" class="form-label">Current Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" id="current-password" required>
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
                                            <input type="password" class="form-control" id="new-password" required>
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
                                            <input type="password" class="form-control" id="confirm-password" required>
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