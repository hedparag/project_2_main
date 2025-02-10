<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './templates/meta-info.php'; ?>
    <title>Home | EMS</title>
</head>

<body class="d-flex flex-column min-vh-100" style="background-image: url('https://img.freepik.com/free-vector/blue-pink-halftone-background_53876-99004.jpg'); background-size: cover; background-position: center; font-family:poppins;;">
    <?php
    include "./templates/header.php";
    if (!isset($_SESSION["user_type_id"])) {
        header("location: login.php");
        exit();
    }

    $query = 'SELECT COUNT(*) AS total_employees FROM employees;';
    $result = pg_query($conn, $query);
    $total_employee = pg_fetch_assoc($result);

    $dquery = 'SELECT COUNT(*) AS total_departments FROM departments;';
    $dresult = pg_query($conn, $dquery);
    $total_departments = pg_fetch_assoc($dresult);
    ?>

    <!-- Main Content -->
    <div class="container flex-grow-1 py-5">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 bg-primary text-white shadow-sm">
                    <div class="card-body p-5">
                        <div class="d-flex align-items-center">
                            <img src="<?= $_SESSION['profile_image'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION["employee_name"]); ?>" class="rounded-circle me-2" width="128" height="128">
                            <div>
                                <h1 class="display-6 mb-1">Welcome back, <?php echo $_SESSION["employee_name"]; ?>!</h1>
                                <p class="lead mb-0"> <?php echo $_SESSION["department_name"] . " • " . $_SESSION["position_name"]; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="card-title mb-1">Total Employees</h6>
                                <h3 class="mb-0"><?php echo $total_employee['total_employees']; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-building fa-2x text-success"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="card-title mb-1">Departments</h6>
                                <h3 class="mb-0"><?php echo $total_departments['total_departments']; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-project-diagram fa-2x text-info"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="card-title mb-1">Projects</h6>
                                <h3 class="mb-0">25</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-tasks fa-2x text-warning"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="card-title mb-1">Tasks</h6>
                                <h3 class="mb-0">75</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Quick Actions</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="profile.php" class="btn btn-light border w-100 p-4 text-start">
                                    <i class="fas fa-user-edit fa-2x mb-3 text-primary"></i>
                                    <h6 class="mb-1">Update Profile</h6>
                                    <small class="text-muted">Edit your personal information</small>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-light border w-100 p-4 text-start">
                                    <i class="fas fa-calendar-alt fa-2x mb-3 text-success"></i>
                                    <h6 class="mb-1">View Schedule</h6>
                                    <small class="text-muted">Check your work schedule</small>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-light border w-100 p-4 text-start">
                                    <i class="fas fa-file-alt fa-2x mb-3 text-info"></i>
                                    <h6 class="mb-1">Request Leave</h6>
                                    <small class="text-muted">Apply for time off</small>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-light border w-100 p-4 text-start">
                                    <i class="fas fa-comments fa-2x mb-3 text-warning"></i>
                                    <h6 class="mb-1">Messages</h6>
                                    <small class="text-muted">View your inbox</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Recent Activity</h5>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <span class="bg-success bg-opacity-10 text-success p-2 rounded">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Project milestone completed</h6>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <span class="bg-primary bg-opacity-10 text-primary p-2 rounded">
                                            <i class="fas fa-file"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">New document shared</h6>
                                        <small class="text-muted">5 hours ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <span class="bg-warning bg-opacity-10 text-warning p-2 rounded">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Team meeting scheduled</h6>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-4 border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start text-center mb-3 mb-lg-0">
                    <span class="text-muted">
                        <i class="fas fa-users-cog me-2"></i>EMS &copy; 2024
                    </span>
                </div>
                <div class="col-lg-4 text-center mb-3 mb-lg-0">
                    <a href="#!" class="text-decoration-none text-muted me-3">Privacy Policy</a>
                    <a href="#!" class="text-decoration-none text-muted">Terms of Use</a>
                </div>
                <div class="col-lg-4 text-lg-end text-center">
                    <a href="#!" class="text-decoration-none text-muted me-3">
                        <i class="fab fa-linkedin fa-lg"></i>
                    </a>
                    <a href="#!" class="text-decoration-none text-muted me-3">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                    <a href="#!" class="text-decoration-none text-muted">
                        <i class="fab fa-facebook-f fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>