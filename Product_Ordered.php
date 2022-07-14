<?php
if (isset($_SESSION['us']) == false) {
    echo "<script>alert('You need to login before accessing this page')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        echo "<script>alert('You are administrator that cant not access this page')</script>";
        echo '<meta http-equiv="refresh" content = "0; URL=?page=shop"/>';
    } else {

?>
        <div class="container border my-2">
            <form name="frm" method="POST" class="mt-3 mx-md-2">
                <h1 class="text-center mb-4">Product Ordered</h1>
                <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th><strong>No.</strong></th>
                            <th><strong>Order date</strong></th>
                            <!-- <th><strong>Delivery date</strong></th> -->
                            <th><strong>Delivery local</strong></th>
                            <th><strong>Product</strong></th>
                            <th><strong>Quantity</strong></th>
                            <th><strong>Give Feedback</strong></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $No = 1;
                        $user = $_SESSION["us"];
                        $sqo = "SELECT * FROM orders o, customer c WHERE o.Username = c.Username AND c.Username = '$user' ORDER BY o.OrderDate DESC";
                        $reso = mysqli_query($conn, $sqo) or die('Invalid query: ' . mysqli_error($conn));

                        while ($rowo = mysqli_fetch_array($reso, MYSQLI_ASSOC)) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $No ?></td>
                                <td align='center'><?php echo $rowo["OrderDate"]; ?></td>
                                <!-- <td align='center'><?php echo $rowod["Deliverydate"]; ?></td> -->
                                <td><?php echo $rowo["Deliverylocal"]; ?></td>
                                <td align='center'>
                                    <?php
                                    $odID = $rowo["OrderID"];

                                    $sq = "SELECT * FROM orderdetail od, product p WHERE od.ProID = p.ProID AND od.OrderID = $odID";
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

                                    $sq = "SELECT * FROM orderdetail od, product p WHERE od.ProID = p.ProID AND od.OrderID = $odID";
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
                                    <?php
                                    $odID = $rowo["OrderID"];

                                    $sq = "SELECT * FROM orderdetail od, product p WHERE od.ProID = p.ProID AND OrderID = $odID";
                                    $resod = mysqli_query($conn, $sq) or die('Invalid query: ' . mysqli_error($conn));
                                    while ($rowod = mysqli_fetch_array($resod, MYSQLI_ASSOC)) {
                                    ?>
                                        <br>
                                        <a href="?page=feedback&&id=<?php echo $rowod['ProID']; ?>" class="btn btn-warning">Feedback</a>
                                        <br>
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
if (isset($_POST['btgiveFeed'])) {
    $idp = $_POST['txtproid'];
    $idc = $_POST['txtusername'];

    $sq = "SELECT * FROM customer c, feedback f, product p
            WHERE c.Username = f.Username AND f.ProID = p.ProID
            AND f.Username = '$idc' AND f.ProID = '$idp'";
    $result = mysqli_query($conn, $sq) or die('Invalid query: ' . mysqli_error($conn));

    if (mysqli_num_rows($result) == 1) {
        echo "<script>You gave feedback</script>";
    }
}
?>