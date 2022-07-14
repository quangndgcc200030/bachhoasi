<script>
    function deleteConfirm() {
        if (confirm("Are you sure to clear all the cart!")) {
            return true;
        } else {
            return false;
        }
    }
</script>
<?php
if (isset($_SESSION['us']) == false) {
    echo "<script>alert('You need to login before accessing this page')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        echo "<script>alert('You are administrator that cant not access this page')</script>";
        echo '<meta http-equiv="refresh" content = "0; URL=?page=shop"/>';
    } else {
        //Cart initialization
        if (!isset($_SESSION['cart_item'])) $_SESSION['cart_item'] = [];
        //Clear all cart
        if (isset($_GET['delcard']) && ($_GET['delcard'] == 1)) unset($_SESSION['cart_item']);
        //Delete a product in cart
        if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart_item']) && isset($_SESSION['cart_item'][$_GET['remove']])) {
            // Remove the product from the shopping cart
            unset($_SESSION['cart_item'][$_GET['remove']]);
        }
        //Get information from form
        if (isset($_POST['addcart']) && ($_POST['addcart'])) {
            $proid = $_POST['proid'];
            $name = $_POST['proname'];
            $short = $_POST['shortdesc'];
            $image = $_POST['image'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];

            //Check whether or not the product has in the cart
            $fl = 0;
            //Check whether or not the product has been duplicated
            for ($i = 0; $i < sizeof($_SESSION['cart_item']); $i++) {
                if ($_SESSION['cart_item'][$i][1] == $name) {
                    $fl = 1;
                    $newqty = $quantity + $_SESSION['cart_item'][$i][4];
                    $_SESSION['cart_item'][$i][4] = $newqty;
                    break;
                }
            }

            if ($fl == 0) {
                $item = [$proid, $name, $short, $image, $quantity, $price];
                $_SESSION['cart_item'][] = $item;
                //var_dump($_SESSION['cart_item']);
            }
        }
?>
        <div class="my-2 border">
            <h2 class="text-center my-3">My Cart</h2>
            <div class="container">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="width:50%">Product</th>
                            <th style="width:10%">Price</th>
                            <th style="width:8%">Quantity</th>
                            <th style="width:22%" class="text-center">Total</th>
                            <th style="width:10%"> </th>
                        </tr>
                    </thead>
                    <?php
                    if (isset($_SESSION['cart_item']) && (is_array($_SESSION['cart_item']))) {
                        if (sizeof($_SESSION['cart_item']) > 0) {
                            $all = 0;
                            for ($i = 0; $i < sizeof($_SESSION['cart_item']); $i++) {
                                $total = $_SESSION['cart_item'][$i][4] * $_SESSION['cart_item'][$i][5];
                                $all += $total;
                    ?>
                                <tbody>
                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-12 col-md-4 col-lg-3 hidden-xs d-flex align-items-center">
                                                    <img src="Product/<?php echo $_SESSION['cart_item'][$i][3] ?>" alt="" class="img-responsive" width="100">
                                                </div>
                                                <div class="col-12 col-md-7 col-lg-8 mt-3 ms-md-3 ms-lg-0">
                                                    <h4 class="nomargin"><?php echo $_SESSION['cart_item'][$i][1] ?></h4>
                                                    <p><?php echo $_SESSION['cart_item'][$i][2] ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">$<?php echo $_SESSION['cart_item'][$i][5] ?></td>
                                        <td data-th="Quantity"><input type="number" min="1" readonly class="form-control text-center" value="<?php echo $_SESSION['cart_item'][$i][4] ?>">
                                        </td>
                                        <td data-th="Total" class="text-center">$<?php echo $total ?></td>
                                        <td class="actions" data-th="">
                                            <a class="btn btn-danger btn-sm" href="?page=cart&remove=<?php echo $i ?>" onclick="return deleteConfirm()">
                                                <i class="bi bi-trash-fill text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php
                            }
                            ?>
                            <tfoot>
                                <tr>
                                    <td><a href="?page=shop" class="btn btn-primary mb-2 mb-md-0"><i class="bi bi-caret-left-fill"></i>Keep Buying</a>
                                        <a href="?page=cart&delcard=1" class="btn btn-warning" onclick="return deleteConfirm()"><i class="bi bi-x-circle-fill"></i> Clear cart</a>
                                    </td>
                                    <td colspan="2" class="hidden-xs"> </td>
                                    <td class="hidden-xs text-center"><strong>Order Total $<?php echo $all ?></strong></td>
                                    <td><a href="?page=order" class="btn btn-success btn-block">Order Now<i class="fa fa-angle-right"></i></a></td>
                                </tr>
                            </tfoot>
                    <?php
                        } else {
                            echo "  <tr>
                                    <td colspan='5' class='me-4 text-center fw-bold'>Cart is empty</td>
                                </tr>";
                        }
                    }
                    ?>
                </table>
            </div>  
        </div>
<?php
    }
}
?>