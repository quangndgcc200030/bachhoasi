<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<?php
if (isset($_SESSION['us']) == false) {
    echo "<script>alert('You need to login before accessing this page')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $sqlstring = "SELECT ProID, ProName, ProPrice, SmallDesc, DetailDesc, Pro_qty, Pro_image, CatName
                FROM product p, category c
                WHERE p.CatID = c.CatID AND ProID = '$id'";
        $result = mysqli_query($conn, $sqlstring);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $proname = $row["ProName"];
        $price = $row["ProPrice"];
        $short = $row["SmallDesc"];
        $detail = $row["DetailDesc"];
        $qty = $row["Pro_qty"];
        $pic = $row["Pro_image"];
        $catname = $row["CatName"];
?>
        <div class="my-2 border">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title ms-2"><?php echo $proname ?></h3>
                    <h6 class="card-subtitle ms-2"><?php echo $short ?></h6>
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="white-box text-center"><img src="Product/<?php echo $pic ?>" class="img-responsive" height="100%" width="100%"></div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <h4 class="box-title">Product description</h4>
                            <p><?php echo $detail ?></p>
                            <?php
                            if ($qty > 0) {
                            ?>
                                <h4 class="mt-md-4">Remaining products: <?php echo $qty ?></h4>
                                <div class="my-4 align-items-center">
                                    <h2 class="me-3">
                                        $<?php echo $price ?>
                                    </h2>
                                </div>
                                <form action="?page=cart" method="POST" class="mb-2">
                                    <div class="row d-flex">
                                        <input type="number" name="quantity" class="col-md-2" value="1" min="1" max="<?php echo $qty ?>">
                                        <input type="submit" name="addcart" class="btn btn-dark btn-rounded mx-md-2 my-2 my-md-0 col-md-3" value="Add to cart">
                                        <input type="submit" name="btnBuynow" formaction="?page=order" class="btn btn-primary btn-rounded me-md-2 my-md-0 mb-2 col-md-3" value="Buy Now">
                                    </div>
                                    <input type="hidden" name="proid" value="<?php echo $id ?>">
                                    <input type="hidden" name="proname" value="<?php echo $proname ?>">
                                    <input type="hidden" name="shortdesc" value="<?php echo $short ?>">
                                    <input type="hidden" name="image" value="<?php echo $pic ?>">
                                    <input type="hidden" name="price" value="<?php echo $price ?>">
                                </form>
                            <?php
                            } else {
                            ?>
                                <h4 class="mt-md-4">Out of stock</h4>
                            <?php
                            }
                            ?>
                            <h3 class="box-title mt-5">Key Highlights</h3>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-check text-success"></i> Quality fabric is cool</li>
                                <li><i class="fa fa-check text-success"></i> Designed to fit all sizes</li>
                                <li><i class="fa fa-check text-success"></i> The perfect product to flaunt your amazing collection</li>
                            </ul>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3 class="box-title mt-5 mb-3">General Info</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-product">
                                    <tbody>
                                        <tr>
                                            <td width="190">Brand</td>
                                            <td><?php echo $catname ?></td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Condition</td>
                                            <td>Knock Down</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Clothes</td>
                                        </tr>
                                        <tr>
                                            <td>Style</td>
                                            <td>Modern</td>
                                        </tr>
                                        <tr>
                                            <td>Suitable For</td>
                                            <td>Everyone</td>
                                        </tr>
                                        <tr>
                                            <td>Care Instructions</td>
                                            <td>Do not apply any toxic chemical for cleaning</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h3 class="box-title mt-5 mb-3">Feedback from customer</h3>
                                <table class="table table-striped table-product">
                                    <?php
                                    $No = 1;
                                    $sql = "SELECT CustName, Content FROM feedback f, customer c WHERE f.Username = c.Username AND f.state = 1 AND ProID = '$id'";
                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    ?>
                                        <tbody>
                                            <tr>
                                                <td width="190"><?php echo $row['CustName'] ?></td>
                                                <td><?php echo $row['Content'] ?></td>
                                            </tr>
                                        </tbody>
                                    <?php
                                        $No++;
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        echo '<meta http-equiv="refresh" content = "0; URL=?page=index.php"/>';
    }
}
?>