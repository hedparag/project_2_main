<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System - Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#">
                <i class="fas fa-users-cog me-2"></i>EMS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.html">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.html">
                            <i class="fas fa-user me-1"></i>Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
                                    <img src="https://ui-avatars.com/api/?name=John+Doe&size=128" class="rounded-circle" width="120" height="120">
                                    <label for="profile_img" class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm" style="cursor: pointer;">
                                        <i class="fas fa-camera text-primary"></i>
                                        <input type="file" id="profile_img" class="d-none">
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <h2 class="mb-1">John Doe</h2>
                                <p class="text-muted mb-2">Senior Developer</p>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-primary">Full-time</span>
                                    <span class="badge bg-success">Active</span>
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
                                            <input type="text" class="form-control" id="fullname" value="John Doe" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control" id="email" value="john@example.com" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="tel" class="form-control" id="phone" value="+1234567890" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                            <input type="date" class="form-control" id="dob" required>
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
                                            <input type="text" class="form-control" id="salary" value="75000" required>
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
                                            <textarea class="form-control" id="emp_details" rows="3">Experienced developer with a passion for creating efficient solutions.</textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="skills" class="form-label">Skills</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-tools"></i>
                                            </span>
                                            <textarea class="form-control" id="skills" rows="3">JavaScript, Python, React, Node.js, SQL, Git</textarea>
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