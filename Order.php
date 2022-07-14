<?php
if (isset($_SESSION['us']) == false) {
    echo "<script>alert('You need to login before accessing this page')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        echo "<script>alert('You are administrator that cant not access this page')</script>";
        echo '<meta http-equiv="refresh" content = "0; URL=?page=shop"/>';
    } else {
        if (isset($_POST["btnPayment"])) {
            $dlocal = $_POST['txtAddress'];
            $username = $_POST['txtUsername'];
            $year = $_POST['slYear'];
            $month = $_POST['slMonth'];
            $day = $_POST['slDay'];

            $sq = "INSERT INTO orders (Orderdate, Deliverydate, Deliverylocal, Paymentmethod, Checked, Username) 
                    VALUES ('$year-$month-$day', '$year-$month-$day', '$dlocal', 'Cash', 0, '$username')";

            $res = mysqli_query($conn, $sq);

            if (!$res) {
                die('Invalid query: ' . mysqli_error($conn));
            } else {
                $last_id = mysqli_insert_id($conn);
                for ($item = 0; $item < sizeof($_SESSION['cart_item']); $item++) {
                    $proid = $_SESSION['cart_item'][$item][0];
                    $proqty = $_SESSION['cart_item'][$item][4];
                    $proprice = $_SESSION['cart_item'][$item][5];
                    $allprice = $proqty * $proprice;

                    $sq = "INSERT INTO orderdetail (OrderID, ProID, Qty, TotalPrice) VALUES ('$last_id', '$proid', '$proqty', '$allprice')";

                    $result = mysqli_query($conn, $sq) or die(mysqli_error($conn));
                    $res = mysqli_query($conn, "SELECT Pro_qty FROM product WHERE ProID = '$proid'");
                    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                    $updateqty = $row['Pro_qty'] - $proqty;
                    mysqli_query($conn, "UPDATE product SET Pro_qty = '$updateqty' WHERE ProID = '$proid'");
                }
                echo '<meta http-equiv="refresh" content = "0; URL=?page=cart"/>';
                echo "<script>alert('Payment successfully')</script>";
                unset($_SESSION['cart_item']);
            }
        }
        if (isset($_POST["btnPaymentnow"])) {
            $dlocal = $_POST['txtAddress'];
            $username = $_POST['txtUsername'];

            $sq = "INSERT INTO orders (Orderdate, Deliverydate, Deliverylocal, Paymentmethod, Username) 
                VALUES ('" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', '$dlocal', 'Cash', '$username')";

            $res = mysqli_query($conn, $sq);

            if (!$res) {
                die('Invalid query: ' . mysqli_error($conn));
            } else {
                $last_id = mysqli_insert_id($conn);

                $proid = $_POST['proid'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                $allprice = $quantity * $price;

                $sq = "INSERT INTO orderdetail (OrderID, ProID, Qty, TotalPrice) VALUES ('$last_id', '$proid', '$quantity', '$allprice')";

                $result = mysqli_query($conn, $sq) or die(mysqli_error($conn));

                $res = mysqli_query($conn, "SELECT Pro_qty FROM product WHERE ProID = '$proid'");
                $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                $updateqty = $row['Pro_qty'] - $quantity;
                mysqli_query($conn, "UPDATE product SET Pro_qty = '$updateqty' WHERE ProID = '$proid'");

                echo "<script>alert('Payment successfully')</script>";
                echo '<meta http-equiv="refresh" content = "0; URL=?page=shop"/>';
            }
        }
?>
        <div class="cardorder border my-2 p-md-3">
            <div class="cardorder-top border-bottom text-center mb-4">
                <span id="logo">bachhoasi.com</span>
            </div>
            <form action="" method="POST" class="cardorder-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="left border">
                            <div class="header">Payment by Cash</div>
                            <div class="row mt-3">
                                <div><span>Username:</span>
                                    <input class="input" name="txtUsername" placeholder="Username" readonly value="<?php echo $_SESSION['us'] ?>">
                                </div>
                                <div><span>Order's name:</span>
                                    <input class="input" name="txtFullname" placeholder="Full name" readonly value="<?php echo $_SESSION['cname'] ?>">
                                </div>
                                <div><span>Phone Number:</span>
                                    <input class="input" name="txtPhonenumber" placeholder="Phone Number" readonly value="<?php echo $_SESSION['phone'] ?>">
                                </div>
                                <div class="col-12"><span>Order date:</span>
                                    <div class="input-group mb-5">
                                        <span class="col-md-4 pb-md-0 col-12 pb-2">
                                            <select name="slYear" id="slYear" class="form-control">
                                                <option value="0">Choose Year</option>
                                                <?php
                                                for ($i = 1970; $i <= 2030; $i++) {
                                                    if ($i == substr(date('Y-m-d'), 0, 4)) {
                                                        echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                                    } else {
                                                        echo "<option value='" . $i . "'>" . $i . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </span>
                                        <span class="col-md-4 px-md-2 col-12">
                                            <select name="slMonth" id="slMonth" class="form-control">
                                                <option value="0">Choose Month</option>
                                                <?php
                                                for ($i = 1; $i <= 12; $i++) {
                                                    if ($i == trim(substr(date('Y-m-d'), 4, 4), "-")) {
                                                        echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                                    } else {
                                                        echo "<option value='" . $i . "'>" . $i . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </span>
                                        <span class="col-md-4 pt-md-0 col-12 pt-2">
                                            <select name="slDay" id="slDay" class="form-control">
                                                <option value="0">Choose Day</option>
                                                <?php
                                                for ($i = 1; $i <= 31; $i++) {
                                                    if ($i == substr(date('Y-m-d'), 8, 9)) {
                                                        echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                                    } else {
                                                        echo "<option value='" . $i . "'>" . $i . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </span>
                                    </div>
                                    <!-- <input class="input" name="txtOderdate" placeholder="yy-mm-dd" value="<?php echo date('Y-m-d') ?>"> -->
                                </div>
                                <!-- <div class="col-6"><span>Delivery date</span>
                                    <input class="input" name="txtDeliverydate" placeholder="yy-mm-dd" value="<?php echo date('Y-m-d') ?>">
                                </div> -->
                                <div><span>Address:</span>
                                    <input class="input" name="txtAddress" placeholder="Address" value="<?php echo $_SESSION['address'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['btnBuynow'])) {
                        $proid = $_POST['proid'];
                        $name = $_POST['proname'];
                        $short = $_POST['shortdesc'];
                        $image = $_POST['image'];
                        $quantity = $_POST['quantity'];
                        $price = $_POST['price'];
                    ?>
                        <div class="col-md-6">
                            <input type="hidden" name="proid" value="<?php echo $proid ?>">
                            <input type="hidden" name="quantity" value="<?php echo $quantity ?>">
                            <input type="hidden" name="price" value="<?php echo $price ?>">
                            <div class="right border">
                                <div class="header">Order Summary</div>
                                <hr>
                                <div class="row item">
                                    <div class="col-4 align-self-center"><img class="img-fluid" src="Product/<?php echo $image ?>"></div>
                                    <div class="col-8">
                                        <b>$ <?php echo $price ?></b>
                                        <div class="row text-muted"><?php echo $name ?></div>
                                        <div class="row">Qty: <?php echo $quantity ?></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row lower">
                                    <div class="col text-left">item</div>
                                    <div class="col text-right">1</div>
                                </div>
                                <div class="row lower">
                                    <div class="col text-left">Subtotal</div>
                                    <div class="col text-right">$ <?php echo ($price * $quantity) ?></div>
                                </div>
                                <div class="row lower">
                                    <div class="col text-left">Delivery</div>
                                    <div class="col text-right">Free</div>
                                </div>
                                <div class="row lower">
                                    <div class="col text-left"><b>Total to pay</b></div>
                                    <div class="col text-right"><b>$ <?php echo ($price * $quantity) ?></b></div>
                                </div>
                                <input type="submit" class="btn btn-primary btnorder my-3" name="btnPaymentnow" id="btnPaymentnow" value="Payment" />
                                <input type="button" class="btn btn-light btn-block" style="font-size: 0.7rem;" name="btnCancel" id="btnCancel" value="Cancel" onclick="window.location='?page=viewdetail&id=<?php echo $proid ?>'" />
                                <p class="text-muted text-center">Complimentary Shipping</p>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-md-6">
                            <div class="right border">
                                <div class="header">Order Summary</div>
                                <hr>
                                <?php
                                if (isset($_SESSION['cart_item'])) {
                                    $all = 0;
                                    $item = 0;
                                    for ($item; $item < sizeof($_SESSION['cart_item']); $item++) {
                                        $total = $_SESSION['cart_item'][$item][4] * $_SESSION['cart_item'][$item][5];
                                        $all += $total;
                                ?>
                                        <div class="row item">
                                            <div class="col-4 align-self-center"><img class="img-fluid" src="Product/<?php echo $_SESSION['cart_item'][$item][3] ?>"></div>
                                            <div class="col-8">
                                                <b>$ <?php echo $_SESSION['cart_item'][$item][5] ?></b>
                                                <div class="row text-muted"><?php echo $_SESSION['cart_item'][$item][1] ?></div>
                                                <div class="row">Qty: <?php echo $_SESSION['cart_item'][$item][4] ?></div>
                                            </div>
                                        </div>
                                        <hr>
                                    <?php
                                    }
                                    ?>
                                    <div class="row lower">
                                        <div class="col text-left">item</div>
                                        <div class="col text-right"><?php echo $item ?></div>
                                    </div>
                                    <div class="row lower">
                                        <div class="col text-left">Subtotal</div>
                                        <div class="col text-right">$ <?php echo $all ?></div>
                                    </div>
                                    <div class="row lower">
                                        <div class="col text-left">Delivery</div>
                                        <div class="col text-right">Free</div>
                                    </div>
                                    <div class="row lower">
                                        <div class="col text-left"><b>Total to pay</b></div>
                                        <div class="col text-right"><b>$ <?php echo $all ?></b></div>
                                    </div>
                                <?php
                                }
                                ?>
                                <input type="submit" class="btn btn-primary btnorder my-3" name="btnPayment" id="btnPayment" value="Payment" />
                                <p class="text-muted text-center">Complimentary Shipping</p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </form>
        </div>
<?php
    }
}
?>