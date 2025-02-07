<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <?php include "./templates/header.php";
    include "./include/config.php";

    if (!isset($_SESSION["user_type_id"])) {
        header("location: login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullname = $_POST['fullname'];
        $email = trim($_POST['email']);
        $position = $_POST['position'];

        $query = "UPDATE users SET fullname = $1, username = $2 WHERE username = $3";
        $result = pg_query_params($conn, $query, [$fullname, $email, $_SESSION["employee_email"]]);

        if ($result !== false) {  // Check if the query executed successfully
            $affected_rows = pg_affected_rows($conn); // Get affected rows

            if ($affected_rows > 0) {
                echo "<script>alert('✅ User details updated successfully!')</script>";
            } else {
                echo "<script>alert('⚠️ No changes made. User not found or same data provided')</script>";
            }
        } else {
            echo "<script>alert('❌ Update failed')</script>";
        }
    }

    ?>

    <!-- Main Content -->
    <div class="container flex-grow-1 py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Profile Information -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">My Profile</h2>
                        <form>
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="fullname" name="fullname"
                                        value='<?php echo $_SESSION["employee_name"] ?>'' required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?php echo $_SESSION["employee_email"] ?>" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="position" class="form-label">Position</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-briefcase"></i>
                                    </span>
                                    <input type="text" class="form-control" id="position" name="position"
                                        value=<?php echo $_SESSION["position_name"] ?> required>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Change Password</h2>
                        <form>
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-eye toggle-password" onclick="togglePassword(' password')"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="rpassword" class="form-label">Repeat Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="rpassword" name="rpassword" placeholder="Repeat password" required>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-1"></i>Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === "password" ? "text" : "password";
        }
    </script>
    <?php include "./templates/footer.php"; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>