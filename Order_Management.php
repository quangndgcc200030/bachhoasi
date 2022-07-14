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
            $ido = $_GET["ido"];
            $idp = $_GET["idp"];
            mysqli_query($conn, "DELETE FROM orderdetail WHERE OrderID = '$ido' AND ProID = '$idp'");
        }
        ?>

        <div class="container border my-2">
            <form name="frm" method="POST" action="" class="mt-3 mx-md-2">
                <h1 class="text-center mb-4">Order Management</h1>
                <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th><strong>No.</strong></th>
                            <th><strong>Order date</strong></th>
                            <!-- <th><strong>Delivery date</strong></th> -->
                            <th><strong>Delivery local</strong></th>
                            <th><strong>Customer Name</strong></th>
                            <th><strong>Product</strong></th>
                            <th><strong>Quantity</strong></th>
                            <th><strong>Checked</strong></th>
                            <th><strong>Delete</strong></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $No = 1;

                        $sqo = "SELECT * FROM orders o, customer c WHERE o.Username = c.Username ORDER BY OrderDate DESC";
                        $reso = mysqli_query($conn, $sqo) or die('Invalid query: ' . mysqli_error($conn));

                        while ($rowo = mysqli_fetch_array($reso, MYSQLI_ASSOC)) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $No ?></td>
                                <td align='center'><?php echo $rowo["OrderDate"]; ?></td>
                                <!-- <td align='center'><?php echo $rowod["Deliverydate"]; ?></td> -->
                                <td><?php echo $rowo["Deliverylocal"]; ?></td>
                                <td><?php echo $rowo["CustName"]; ?></td>
                                <td align='center'>
                                    <?php
                                    $odID = $rowo["OrderID"];

                                    $sq = "SELECT * FROM orderdetail od, product p WHERE od.ProID = p.ProID AND OrderID = $odID";
                                    $resod = mysqli_query($conn, $sq) or die('Invalid query: ' . mysqli_error($conn));
                                    while ($rowod = mysqli_fetch_array($resod, MYSQLI_ASSOC)) {
                                    ?>
                                        <table>
                                            <tr>
                                                <hr class="mt-2"><img src='Product/<?php echo $rowod["Pro_image"] ?>' border='0' width="50" height="50" />
                                                <hr class="mb-0">
                                            </tr>
                                        </table>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td align='center'>
                                    <?php
                                    $odID = $rowo["OrderID"];

                                    $sq = "SELECT * FROM orderdetail od, product p WHERE od.ProID = p.ProID AND OrderID = $odID";
                                    $resod = mysqli_query($conn, $sq) or die('Invalid query: ' . mysqli_error($conn));
                                    while ($rowod = mysqli_fetch_array($resod, MYSQLI_ASSOC)) {
                                    ?>
                                        <br>
                                        <?php
                                        echo $rowod["Qty"];
                                        ?>
                                        <br><br>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <form action="" method="POST">
                                        <input type="hidden" id="check" name="check" value="<?php echo $rowo['Checked']; ?>">
                                        <label for="check" class="mb-2 fw-bold"><?php echo $rowo['Checked'] == 1 ? "Checked" : "Unchecked"; ?></label>
                                        <input type="hidden" id="ido" name="txtido" value="<?php echo $rowo['OrderID']; ?>">

                                        <?php
                                        if ($rowo['Checked'] == 1) {
                                        ?>
                                            <button type="submit" class="btn btn-success" name="btnchecked" width="10" height="10">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        <?php
                                        } else {
                                        ?>
                                            <button type="submit" class="btn btn-danger" name="btnchecked">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        <?php
                                        }
                                        ?>

                                    </form>
                                </td>
                                <td style='text-align:center'>
                                    <?php
                                    $odID = $rowo["OrderID"];

                                    $sq = "SELECT * FROM orderdetail od, product p WHERE od.ProID = p.ProID AND OrderID = $odID";
                                    $resod = mysqli_query($conn, $sq) or die('Invalid query: ' . mysqli_error($conn));
                                    while ($rowod = mysqli_fetch_array($resod, MYSQLI_ASSOC)) {
                                    ?>
                                        <br>
                                        <a href="?page=order_management&&function=del&&ido=<?php echo $rowo["OrderID"] ?>&&idp=<?php echo $rowod["ProID"] ?>" onclick="return deleteConfirm()">
                                            <i class="bi bi-trash-fill" style="color: red;"></i>
                                        </a>
                                        <br><br>
                                    <?php
                                    }
                                    ?>
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

// if (isset($_POST['check']) && $_POST['check'] == 1) {
//     $id = $_POST['check'];
//     mysqli_query($conn, "UPDATE orders SET Checked = 0 WHERE OrderID = '$id'") or die('Invalid query: ' . mysqli_error($conn));
//     echo '<meta http-equiv="refresh" content = "0; URL=?page=order_management"/>';
// }

if (isset($_POST['btnchecked']) && $_POST['check'] == 1) {
    $id = $_POST['txtido'];
    mysqli_query($conn, "UPDATE orders SET Checked = 0 WHERE OrderID = '$id'") or die('Invalid query: ' . mysqli_error($conn));
    echo '<meta http-equiv="refresh" content = "0; URL=?page=order_management"/>';
}

if (isset($_POST['btnchecked']) && $_POST['check'] == 0) {
    $id = $_POST['txtido'];
    mysqli_query($conn, "UPDATE orders SET Checked = 1 WHERE OrderID = '$id'") or die('Invalid query: ' . mysqli_error($conn));
    echo '<meta http-equiv="refresh" content = "0; URL=?page=order_management"/>';
}
?>