<?php
include("php/dbconnect.php");
include("php/checklogin.php");

$errormsg = '';
$item_id = '';
$item_name = '';
$item_description = '';
$availability = '';

// Check if editing an item
if (isset($_GET['id'])) {
    $item_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM item WHERE id='$item_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $itemData = $result->fetch_assoc();
        $item_name = $itemData['item'];
        $item_description = $itemData['description'];
        $availability = $itemData['availability'];
    }
}

// Handle form submission
if (isset($_POST['update'])) {
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $item_description = mysqli_real_escape_string($conn, $_POST['item_description']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);

    $sql = "UPDATE item SET item='$item_name', description='$item_description', availability='$availability' WHERE id='$item_id'";
    if ($conn->query($sql) === TRUE) {
        $errormsg = "<div class='alert alert-success'>Item updated successfully</div>";
    } else {
        $errormsg = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PLSP Finance Management System</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <link href="css/basic.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>

<?php include("php/header.php"); ?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Edit Item</h1>
                <?php echo $errormsg; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Edit Item</div>
                    <form action="edit_item.php?id=<?php echo $item_id; ?>" method="post" id="editItemForm" class="form-horizontal">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="item_name">Item Name*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo $item_name; ?>" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="item_description">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="item_description" name="item_description"><?php echo $item_description; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="availability">Availability*</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="availability" name="availability" required>
                                        <option value="In Stock" <?php if ($availability == 'available') echo 'selected'; ?>>In Stock</option>
                                        <option value="Out Of Stock" <?php if ($availability == 'unavailable') echo 'selected'; ?>>Out Of Stock</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel-footer">
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                            <a href="add_item.php" class="btn btn-default">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="footer-sec">
    PLSP Finance Management System | © BSIT 2A | Group 6 2024
    </div>
    
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
