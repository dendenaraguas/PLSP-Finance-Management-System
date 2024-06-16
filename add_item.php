<?php
include("php/dbconnect.php");
include("php/checklogin.php");

$errormsg = '';

// Handle form submission for adding a new item
if (isset($_POST['save'])) {
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $item_description = mysqli_real_escape_string($conn, $_POST['item_description']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);

    $sql = "INSERT INTO item (item, description, availability) VALUES ('$item_name', '$item_description', '$availability')";
    if ($conn->query($sql) === TRUE) {
        $errormsg = "<div class='alert alert-success'>Item added successfully</div>";
    } else {
        $errormsg = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Delete item
if (isset($_GET['delete_item'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_item']);
    $sql = "DELETE FROM item WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: add_item.php?msg=deleted");
    } else {
        header("Location: add_item.php?msg=error");
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
    
	 <script src="js/jquery-1.10.2.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>

<?php include("php/header.php"); ?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Add Item
                <?php
                    echo (isset($_GET['action']) && @$_GET['action'] == "add" || @$_GET['action'] == "edit")?
                        '<a href="add_item.php" class="btn btn-primary btn-sm pull-right">Back <i class="glyphicon glyphicon-arrow-right"></i></a>' :
                        '<a href="add_item.php?action=add" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add </a>';
                    ?>
                </h1>
                <?php echo $errormsg; ?>
            </div>
        </div>
        <?php
        if(isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")
        {
       ?>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="panel panel-primary">

                    <div class="panel-heading"> Add New Item </div>
                    <form action="add_item.php" method="post" id="addItemForm" class="form-horizontal">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="item_name">Item Name*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="item_name" name="item_name" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="item_description">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="item_description" name="item_description"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="availability">Availability*</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="availability" name="availability" required>
                                        <option value="In Stock">In Stock</option>
                                        <option value="Out of Stock">Out Of Stock</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel-footer">
                            <button type="submit" name="save" class="btn btn-primary">Save</button>
                            <a href="add_item.php" class="btn btn-default">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
                   
       <?php
       }else{
       ?>
       
        <link href="css/datatable/datatable.css" rel="stylesheet" />
        

         <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
             <div class="panel-heading">Manage Items</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Description</th>
                                        <th>Availability</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM item WHERE delete_status='0'";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $i = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$i}</td>
                                                    <td>{$row['item']}</td>
                                                    <td>{$row['description']}</td>
                                                    <td>{$row['availability']}</td>
                                                    <td>
                                                        <a href='edit_item.php?id={$row['id']}' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-edit'></span></a>
                                                        <a href='add_item.php?delete_item={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this item?');\" class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span></a>
                                                    </td>
                                                </tr>";
                                            $i++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No items found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
 
       <?php
       }
       ?>

<div id="footer-sec">
    PLSP Finance Management System | © BSIT 2A | Group 6 2024
    </div>
  
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
