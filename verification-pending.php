<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification - Employee Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <?php include "./templates/header.php";

    ?>

    <!-- Main Content -->
    <div class="container flex-grow-1 d-flex align-items-center justify-content-center py-5">
        <div class="text-center">
            <div class="card border-0 shadow-lg" style="max-width: 500px;">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4">
                            <i class="fas fa-user-clock fa-4x text-primary"></i>
                        </div>
                    </div>

                    <h2 class="mb-3">Verification Pending</h2>
                    <p class="text-muted mb-4">
                        Your account is currently under review. Our team is verifying your information to ensure everything is in order. You'll be able to access your account once the verification is complete.
                    </p>

                    <div class="mb-4">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 75%"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <div class="text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 mb-2">
                                <i class="fas fa-check text-success"></i>
                            </div>
                            <small class="text-muted d-block">Submitted</small>
                        </div>
                        <div class="text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 mb-2">
                                <i class="fas fa-check text-success"></i>
                            </div>
                            <small class="text-muted d-block">Received</small>
                        </div>
                        <div class="text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 mb-2">
                                <i class="fas fa-spinner fa-spin text-primary"></i>
                            </div>
                            <small class="text-muted d-block">Reviewing</small>
                        </div>
                        <div class="text-center">
                            <div class="bg-light rounded-circle p-2 mb-2">
                                <i class="fas fa-check text-muted"></i>
                            </div>
                            <small class="text-muted d-block">Approved</small>
                        </div>
                    </div>

                    <div class="alert alert-light border mb-4">
                        <i class="fas fa-clock text-primary me-2"></i>
                        Estimated verification time: <strong>24-48 hours</strong>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="index.php" class="btn btn-primary">
                            <i class="fas fa-redo-alt me-2"></i>Check Status Again
                        </a>
                        <a href="mailto:sahfamily91@gmail.com" class="btn btn-outline-secondary">
                            <i class="fas fa-envelope me-2"></i>Contact Support
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-muted">
                <small>
                    Need immediate assistance? Call us at
                    <a href="tel:+1234567890" class="text-decoration-none">+91 7003363675</a>
                </small>
            </div>
        </div>
    </div>

    <?php include "./templates/footer.php"; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>