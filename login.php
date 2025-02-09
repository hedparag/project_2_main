<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100" style="background-image: url('https://img.freepik.com/free-vector/blue-pink-halftone-background_53876-99004.jpg'); background-size: cover; background-position: center; font-family:poppins;">
    <?php include "./templates/header.php";
    include "./include/config.php";

    if (isset($_SESSION["user_type_id"])) {
        header("location: index.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                    echo "<script>alert('❌ Employee details not found!')</script>";
                }
            } else {
                echo "<script>alert('❌ Incorrect password!')</script>";
            }
        } else {
            echo "<script>alert('❌ User not found!')</script>";
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
                                    <input type="email" class="form-control" id="email" name="email" required>
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