<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './templates/meta-info.php'; ?>
    <title>Login | EMS</title>
</head>

<body class="d-flex flex-column min-vh-100" style="background-image: url('https://img.freepik.com/free-vector/blue-pink-halftone-background_53876-99004.jpg'); background-size: cover; background-position: center; font-family:poppins;">
    <?php include "./templates/header.php";
    include "./include/config.php";

    if (isset($_SESSION["user_type_id"])) {
        header("location: index.php");
        exit();
    }
    // one-time token added for csrf
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
    }

    $email = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
            // Invalid CSRF token - return 403 Forbidden
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            exit('Invalid CSRF token');
        }

        // Process the form after CSRF validation
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE username = $1";
        $result = pg_query_params($conn, $query, [$email]);

        if ($result && pg_num_rows($result) > 0) {
            $user = pg_fetch_assoc($result);

            if (password_verify($password, $user["password"])) {
                $equery = "SELECT * FROM employees WHERE employee_email = $1";
                $eresult = pg_query_params($conn, $equery, [$email]);

                if ($eresult && pg_num_rows($eresult) > 0) {
                    $employee = pg_fetch_assoc($eresult);
                    $_SESSION["employee_name"] = $employee["employee_name"];
                    $_SESSION["employee_id"] = $employee["employee_id"];
                    $_SESSION["user_type_id"] = $employee["user_type_id"];
                    $_SESSION["employee_email"] = $employee["employee_email"];
                    $_SESSION["profile_image"] = $employee["profile_image"];

                    $dquery = "SELECT department_name FROM departments WHERE department_id = $1";
                    $dresult = pg_query_params($conn, $dquery, [$employee["department_id"]]);

                    if ($dresult && pg_num_rows($dresult) > 0) {
                        $department = pg_fetch_assoc($dresult);
                        $_SESSION["department_name"] = $department["department_name"];
                    }

                    $pquery = "SELECT position_name FROM positions WHERE position_id = $1";
                    $presult = pg_query_params($conn, $pquery, [$employee["position_id"]]);

                    if ($presult && pg_num_rows($presult) > 0) {
                        $position = pg_fetch_assoc($presult);
                        $_SESSION["position_name"] = $position["position_name"];
                    }

                    header("Location: index.php");
                    exit();
                } else {
                    $login_error = '❌ Employee details not found!';
                }
            } else {
                $login_error = '❌ Incorrect password!';
            }
        } else {
            $login_error = '❌ User not found!';
        }
    }
    ?>

    <!-- Main Content -->
    <div class=" container flex-grow-1 d-flex align-items-center py-5">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="text-center mb-4">Welcome Back</h1>
                        <form method="POST">
                            <div class="mb-4">
                                <label for="email" class="form-label">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <!-- created a hidden input field for csrf -->
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">

                                    <?php
                                    if (!$email) {  ?>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    <?php } else { ?>
                                        <input type="email" class="form-control" id="email" name="email" required value="<?php echo $email; ?>"> <?php } ?>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <?php
                            if (isset($login_error)) { ?>
                                <span style="display: block;"><?php echo $login_error; ?></span><br>
                            <?php } else { ?>
                                <span style="display: none;"><?php echo $login_error; ?></span><br>
                            <?php } ?>
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                Sign In
                            </button>
                            <p class="text-center mb-0">
                                Don't have an account? <a href="register.php" class="text-decoration-none">Register
                                    here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "./templates/footer.php"; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>