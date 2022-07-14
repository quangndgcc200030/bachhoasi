<?php
if (isset($_SESSION['us']) == false) {
    echo "<script>alert('You need to login before accessing this page')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
        echo "<script>alert('You are not administrator to access this page')</script>";
        echo '<meta http-equiv="refresh" content = "0; URL=index.php"/>';
    } else {

?>

        <script>
            function deleteConfirm() {
                if (confirm("Are you sure to delete!")) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>

        <?php
        if (isset($_GET["function"]) == "del") {
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $sq = "SELECT Cat_image FROM category WHERE CatID = '$id'";
                $res = mysqli_query($conn, $sq);
                $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                $filePic = $row['Cat_image'];
                unlink("Category/" . $filePic);
                mysqli_query($conn, "DELETE FROM product WHERE CatID = '$id'");
                mysqli_query($conn, "DELETE FROM category WHERE CatID = '$id'");
            }
        }
        ?>

        <div class="border my-2">
            <form name="frm" method="post" action="" class="mt-3 mx-md-2">
                <h1 class="text-center">Product Category</h1>
                <div class="text-center mb-2">
                    <a href="?page=add_category" class="btn btn-outline-primary">
                        <img src="Image/add.png" alt="Add new" width="16" height="16" border="0" />Add
                    </a>
                </div>
                <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th><strong>No.</strong></th>
                            <th><strong>Category Name</strong></th>
                            <th><strong>Description</strong></th>
                            <th><strong>Image</strong></th>
                            <th><strong>Edit</strong></th>
                            <th><strong>Delete</strong></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $No = 1;
                        $result = mysqli_query($conn, "SELECT * FROM category");
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $No; ?></td>
                                <td><?php echo $row["CatName"]; ?></td>
                                <td><?php echo $row["CatDesc"]; ?></td>
                                <td align='center'>
                                    <img src='Category/<?php echo $row["Cat_image"] ?>' border='0' width="100" height="50" />
                                </td>
                                <td style='text-align:center'>
                                    <a href="?page=update_category&&id=<?php echo $row["CatID"]; ?>">
                                        <i class="bi bi-pen-fill" style="color: black;"></i>
                                    </a>
                                </td>
                                <td style='text-align:center'>
                                    <a href="?page=category_management&&function=del&&id=<?php echo $row["CatID"] ?>" onclick="return deleteConfirm()">
                                        <i class="bi bi-trash-fill" style="color: red;"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $No++;
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
<?php
    }
}
?>