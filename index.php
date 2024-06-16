<?php
include("php/dbconnect.php");
include("php/checklogin.php");

try {
    $pdo = $conn; // define the $pdo variable
    $sql = "SELECT * FROM student";
    $result = $pdo->query($sql);
    if ($result) {
        $count = $result->num_rows;
        $fees = array();
    

        while ($row = $result->fetch_assoc()) { // use fetch_assoc() for mysqli
            $fees[] = $row["fees"];
        }
        unset($result);
    } else {
        echo "Number of Rows: " . $count;
    }
} catch (PDOException $e) {
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
unset($pdo);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PLSP Finance Management System</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- CHART STYLES -->
    <link href="css/chart.css" rel="stylesheet" />
</head>
<body>

<?php
include("php/header.php");
?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">DASHBOARD</h1>
                <h1 class="page-subhead-line">Welcome to <strong>PLSP Finance Management System</strong></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="main-box mb-pink">
                    <a href="student.php">
                        <i class="fa fa-user fa-5x"></i>
                        <h5>Student</h5>
                    </a>
                    <span class="info-box-number" style="color: white">
                    <?php 
                        $student = $conn->query("SELECT count(id) as total FROM student WHERE delete_status = 1")->fetch_assoc()['total'];
                        echo number_format($student);
                    ?>
                    </span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="main-box bg-primary mb-blue">
                    <a href="Course.php">
                        <i class="fa fa-th-list fa-5x"></i>
                        <h5>Courses</h5>
                    </a>
                    <span class="info-box-number" style="color: white">
                    <?php 
                        $course = $conn->query("SELECT count(id) as total FROM course WHERE delete_status = 1")->fetch_assoc()['total'];
                        echo number_format($course);
                    ?>
                    </span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="main-box mb-dull">
                    <a href="fees.php">
                        <i class="fa fa-inr fa-5x"></i>
                        <h5>Take Fees</h5>
                    </a>
                    <span class="info-box-number" style="color: white">
                    <?php 
                        $fee = $conn->query("SELECT sum(id) as total FROM fees_transaction WHERE status = 0")->fetch_assoc()['total'];
                        echo number_format($fee);
                    ?>
                    </span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="main-box bg-primary mb-blue">
                    <a href="add_item.php">
                        <i class="fa fa-th-list fa-5x"></i>
                        <h5>Item</h5>
                    </a>
                    <span class="info-box-number" style="color: white">
                    <?php 
                        $item = $conn->query("SELECT count(id) as total FROM item WHERE delete_status = 1")->fetch_assoc()['total'];
                        echo number_format($item);
                    ?>
                    </span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="main-box mb-red">
                    <a href="report.php">
                        <i class="fa fa-file-text fa-5x"></i>
                        <h5>Report</h5>
                    </a>
                    <span class="info-box-number" style="color: white">
                    <?php 
                        $id = $conn->query("SELECT sum(id) as total FROM Course WHERE delete_status = 0")->fetch_assoc()['total'];
                        echo number_format($id);
                    ?>
                    </span>
                </div>
            </div>

            <!-- CHART SECTION -->
            <div>
                <canvas id="myChart"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>

                // SetUp Block
                const fees = <?php echo json_encode($fees); ?>;

                const data = { 
                 labels: ['June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [{
                        label: 'Earnings Overview',
                        data: fees,
                        borderColor: 'black',
                     backgroundColor: '#9BD0F5',
                        borderWidth: 1
                    }]
                };

                // Config Block
                const config = { 
                    type: 'bar',
                    data,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                // Render Block
                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
            </script>
        </div>
    </div>
</div>

<div id="footer-sec">
PLSP Finance Management System | © BSIT 2A | Group 6 2024
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/jquery-1.10.2.js"></script>	
<script src="js/bootstrap.js"></script>
</body>
</html>
