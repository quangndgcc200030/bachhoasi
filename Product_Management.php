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
        include_once("connectdatabase.php");
        if (isset($_GET["function"]) == "del") {
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $sq = "SELECT Pro_image FROM product WHERE ProID = '$id'";
                $res = mysqli_query($conn, $sq);
                $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                $filePic = $row['Pro_image'];
                unlink("Product/" . $filePic);
                mysqli_query($conn, "DELETE FROM noti WHERE ProID = '$id'");
                mysqli_query($conn, "DELETE FROM product WHERE ProID = '$id'");
            }
        }
        ?>
        <div class="container border my-2">
            <form name="frm" method="post" action="" class="mt-3">
                <h1 class="text-center">Product Management</h1>
                <div class="text-center mb-2">
                    <a href="?page=add_product" class="btn btn-outline-primary">
                        <img src="Image/add.png" alt="Add new" width="16" height="16" border="0" /> Add new
                    </a>
                </div>
                <table id="tableproduct" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th><strong>No.</strong></th>
                            <th><strong>Product ID</strong></th>
                            <th><strong>Product Name</strong></th>
                            <th><strong>Price</strong></th>
                            <th><strong>Quantity</strong></th>
                            <th><strong>Category Name</strong></th>
                            <th><strong>Image</strong></th>
                            <th><strong>Edit</strong></th>
                            <th><strong>Delete</strong></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        include_once("connectdatabase.php");
                        $No = 1;
                        $result = mysqli_query($conn, "SELECT ProID, ProName, ProPrice, Pro_qty, Pro_image, CatName
                                                FROM product p, category c
                                                WHERE p.CatID = c.CatID
                                                ORDER BY ProDate DESC");
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        ?>
                            <tr valign="middle">
                                <td class="text-center"><?php echo $No; ?></td>
                                <td class="text-center"><?php echo $row["ProID"]; ?></td>
                                <td><?php echo $row["ProName"]; ?></td>
                                <td align='center'>$<?php echo $row["ProPrice"]; ?></td>
                                <td class="text-center"><?php echo $row["Pro_qty"]; ?></td>
                                <td><?php echo $row["CatName"]; ?></td>
                                <td align='center'>
                                    <img src='Product/<?php echo $row["Pro_image"] ?>' border='0' width="50" height="50" />
                                </td>
                                <td align='center'>
                                    <a href="?page=update_product&&id=<?php echo $row['ProID'] ?>">
                                        <i class="bi bi-pen-fill" style="color: black;"></i>
                                    </a>
                                </td>
                                <td align='center'>
                                    <a href="?page=product_management&&function=del&&id=<?php echo $row["ProID"] ?>" onclick="return deleteConfirm()">
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