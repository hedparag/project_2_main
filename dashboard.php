<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <body class="d-flex flex-column min-vh-100" style="background-image: url('https://img.freepik.com/free-vector/blue-pink-halftone-background_53876-99004.jpg'); background-size: cover; background-position: center;">

        <?php include "./templates/header.php";
        if (!isset($_SESSION["user_type_id"]) || $_SESSION["user_type_id"] == 0) {
            header("location: login.php");
            exit();
        }

        // Fetch Employees Data
        $query = "SELECT 
        e.employee_id, e.employee_name, e.employee_email, e.employee_phone, 
        e.salary, e.status, e.profile_image, e.dob, e.employee_details, e.employee_skils,
        d.department_name, p.position_name
    FROM employees e
    JOIN departments d ON e.department_id = d.department_id
    JOIN positions p ON e.position_id = p.position_id";

        $result = pg_query($conn, $query);
        ?>

        <!-- Main Content -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <a href="add_employee.php"><button id="addEmployeeBtn" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add Employee</button></a>
                    <div class="">
                        <button id="bulkApproveBtn" class="btn btn-success"><i class="fa-solid fa-check"></i> Approve Selected</button>
                        <button id="bulkRejectBtn" class="btn btn-danger"><i class="fa-solid fa-xmark"></i> Reject Selected</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Position</th>
                                <th>Department</th>
                                <th>Skills</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Approve/Reject</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = pg_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><input type="checkbox" class="userCheckbox" value="<?= $row['employee_id']; ?>"></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $row['profile_image'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($row['employee_name']); ?>"
                                                class="rounded-circle me-2" width="64" height="64">
                                            <?= htmlspecialchars($row['employee_name']); ?>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($row['employee_email']); ?></td>
                                    <td><?= htmlspecialchars($row['employee_phone']); ?></td>
                                    <td><span class="badge bg-primary"><?= htmlspecialchars($row['position_name']); ?></span></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['department_name']); ?></span></td>
                                    <td>
                                        <?php
                                        $skillsArray = explode(',', $row['employee_skils']);
                                        foreach ($skillsArray as $skill) {
                                            $skill = trim($skill);
                                            if (!empty($skill)) {
                                                echo "<span class='badge bg-info me-1'>" . htmlspecialchars($skill) . "</span>";
                                            }
                                        }
                                        ?>
                                    </td>

                                    <td><?= htmlspecialchars($row['employee_details']); ?></td>
                                    <td>
                                        <span class="badge <?= $row['status'] == 't' ? 'bg-success' : 'bg-danger'; ?>">
                                            <?= $row['status'] == 't' ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="profile.php?id=<?= $row['employee_id']; ?>" class="btn btn-sm btn-outline-info bg-white">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm <?= $row['status'] == 't' ? 'btn-danger' : 'btn-success'; ?> toggle-status-btn"
                                            data-id="<?= $row['employee_id']; ?>" data-status="<?= $row['status']; ?>">
                                            <?= $row['status'] == 't' ? 'Reject' : 'Approve'; ?>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="./js/dashboard.js"></script>

        <?php include "./templates/footer.php"; ?>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>