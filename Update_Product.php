<script type="text/javascript" src="scripts/ckeditor/ckeditor.js"></script>
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
        <?php
        function bind_Category_List($conn, $selectValue)
        {
            $sqlstring = "SELECT CatID, CatName from category";
            $result = mysqli_query($conn, $sqlstring);
            echo "<select name='CategoryList' class='form-control'>
					<option value='0'>Choose category</option>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                if ($row['CatID'] == $selectValue) {
                    echo "<option value='" . $row['CatID'] . "' selected>" . $row['CatName'] . "</option>";
                } else {
                    echo "<option value='" . $row['CatID'] . "'>" . $row['CatName'] . "</option>";
                }
            }
            echo "</select>";
        }
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $sqlstring = "SELECT ProID, ProName, ProPrice, SmallDesc, DetailDesc, ProDate, Pro_qty, Pro_image, CatID
					        FROM product
                            WHERE ProID = '$id'";
            $result = mysqli_query($conn, $sqlstring);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $proname = $row["ProName"];
            $short = $row["SmallDesc"];
            $detail = $row["DetailDesc"];
            $price = $row["ProPrice"];
            $qty = $row["Pro_qty"];
            $pic = $row["Pro_image"];
            $category = $row["CatID"];
        ?>
            <div class="container border my-2">
                <h2 class="text-center my-3">Updating Product</h2>

                <form id="frmProduct" name="frmProduct" method="post" enctype="multipart/form-data" action="" class="form-horizontal mx-md-5" role="form">
                    <div class="form-outline mb-3">
                        <label class="form-label mb-1 fw-bold" for="txtProID">Product ID:</label>
                        <input type="text" name="txtProID" id="txtProID" class="form-control" placeholder="" readonly value='<?php echo $id; ?>' />
                    </div>

                    <div class="form-outline mb-3">
                        <label class="form-label mb-1 fw-bold" for="txtProName">Product Name:</label>
                        <input type="text" name="txtProName" id="txtProName" class="form-control" placeholder="" value='<?php echo $proname; ?>' />
                    </div>

                    <div class="form-outline mb-3">
                        <label class="form-label mb-1 fw-bold" for="txtCatID">Choose Category:</label>
                        <div>
                            <?php
                            bind_Category_List($conn, $category);
                            ?>
                        </div>
                    </div>

                    <div class="form-outline mb-3">
                        <label class="form-label mb-1 fw-bold" for="txtProPrice">Price:</label>
                        <input type="text" name="txtProPrice" id="txtProPrice" class="form-control" placeholder="" value='<?php echo $price ?>' />
                    </div>

                    <div class="form-outline mb-3">
                        <label class="form-label mb-1 fw-bold" for="txtSmallDesc">Small Description:</label>
                        <input type="text" name="txtSmallDesc" id="txtSmallDesc" class="form-control" placeholder="" value='<?php echo $short ?>' />
                    </div>

                    <div class="form-group mb-4">
                        <label for="lblDetail" class="control-label mb-1 fw-bold">Detail description: </label>
                        <div class="">
                            <textarea name="txtDetailDesc" rows="4" class="btn-block"><?php echo $detail ?></textarea>
                        </div>
                    </div>

                    <div class="form-outline mb-3">
                        <label class="form-label mb-1 fw-bold" for="txtQty">Quantity:</label>
                        <input type="number" min="1" name="txtQty" id="txtQty" class="form-control" placeholder="" value="<?php echo $qty ?>" />
                    </div>

                    <div class="form-outline mb-3">
                        <label for="txtImage" class="form-label mb-1 fw-bold">Choose Picture:</label><br>
                        <img src='Product/<?php echo $pic; ?>' class="mb-2" border='0' width="50" height="50" />
                        <input type="file" name="txtImage" id="txtImage" class="form-control" value="" />
                    </div>

                    <div class="form-ouline my-3 text-center">
                        <div class="">
                            <input type="submit" class="btn btn-primary" name="btnUpdatePro" id="btnUpdatePro" value="Update" />
                            <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=update_product&&id=<?php echo $row['ProID']; ?>'" />
                            <input type="button" class="btn btn-primary" name="btnCancel" id="btnCancel" value="Cancel" onclick="window.location='?page=product_management'" />
                        </div>
                    </div>
                </form>
            </div>

<?php
            if (isset($_POST["btnUpdatePro"])) {
                $id = $_POST["txtProID"];
                $proname = $_POST["txtProName"];
                $short = $_POST["txtSmallDesc"];
                $detail = $_POST["txtDetailDesc"];
                $price = $_POST["txtProPrice"];
                $qty = $_POST["txtQty"];
                $pic = $_FILES["txtImage"];
                $category = $_POST["CategoryList"];

                if ($pic['name'] != "") {
                    if ($pic["type"] == "image/jpg" || $pic["type"] == "image/jpeg" || $pic["type"] == "image/png" || $pic["type"] == "image/gif") {
                        if ($pic["size"] <= 2097152) {
                            $sq = "SELECT * FROM product WHERE ProID != '$id' AND ProName = '$proname'";
                            $result = mysqli_query($conn, $sq);
                            if (mysqli_num_rows($result) == 0) {

                                copy($pic['tmp_name'], "Product/" . $pic['name']);
                                $filePic = $pic['name'];

                                $sqlstring = "UPDATE product SET ProName = '$proname',
                                                    ProPrice = '$price',
                                                    SmallDesc = '$short',
                                                    DetailDesc = '$detail',
                                                    ProDate = '" . date('Y-m-d H:i:s') . "',
                                                    Pro_qty = '$qty',
                                                    Pro_image = '$filePic',
                                                    CatID = '$category'
                                                    WHERE ProID = '$id'";
                                $res = mysqli_query($conn, $sqlstring);
                                if (!$result) {
                                    die('Invalid query: ' . mysqli_error($conn));
                                }
                                echo '<meta http-equiv="refresh" content = "0; URL=?page=product_management"/>';
                            } else {
                                echo "<li>Duplicate product Name</li>";
                            }
                        } else {
                            echo "Size of image too big";
                        }
                    } else {
                        echo "Image format is not correct";
                    }
                } else {
                    $sq = "SELECT * FROM product WHERE ProID != '$id' AND ProName = '$proname'";
                    $result = mysqli_query($conn, $sq);
                    if (mysqli_num_rows($result) == 0) {
                        $sqlstring = "UPDATE product SET ProName = '$proname',
                                            ProPrice = '$price',
                                            SmallDesc = '$short',
                                            DetailDesc = '$detail',
                                            ProDate = '" . date('Y-m-d H:i:s') . "',
                                            Pro_qty = '$qty',
                                            CatID = '$category'
                                            WHERE ProID = '$id'";
                        mysqli_query($conn, $sqlstring);
                        echo '<meta http-equiv="refresh" content = "0; URL=?page=product_management"/>';
                    } else {
                        echo "<li>Duplicate product Name</li>";
                    }
                }
            }
        } else {
            echo '<meta http-equiv="refresh" content = "0; URL=?page=product_management"/>';
        }
    }
}
?>