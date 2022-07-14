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
        <script>
            function formValid() {
                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
                f = document.frmAddproduct;

                if (f.txtProID.value == "" || f.txtProName.value == "" || f.txtProPrice.value == "" || f.txtSmallDesc.value == "" || f.txtQty.value == "" || f.txtDetailDesc.value == "") {
                    alert("Enter fileds with marks(*), please");
                    f.txtProID.focus();
                    return false;
                }
                if (format.test(f.txtProID.value)) {
                    alert("Product ID invalid, please enter again");
                    f.txtProID.focus();
                    return false;
                }
                if (f.CategoryList.value == 0) {
                    alert("Please choose category");
                    return false;
                }
                if (f.fileImage.value == "") {
                    alert("You must select your picture");
                    f.fileImage.focus();
                    return false;
                }
                return true;
            }
        </script>

        <?php
        include_once("connectdatabase.php");
        function bind_Category_List($conn)
        {
            $sqlstring = "SELECT CatID, CatName from category";
            $result = mysqli_query($conn, $sqlstring);
            echo "<select name='CategoryList' class='form-control'>
					<option value='0'>Choose category</option>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<option value='" . $row['CatID'] . "'>" . $row['CatName'] . "</option>";
            }
            echo "</select>";
        }
        if (isset($_POST["btnAdd"])) {
            $id = $_POST["txtProID"];
            $proname = $_POST["txtProName"];
            $short = $_POST["txtSmallDesc"];
            $detail = $_POST["txtDetailDesc"];
            $price = $_POST["txtProPrice"];
            $qty = $_POST["txtQty"];
            $pic = $_FILES["fileImage"];
            $category = $_POST["CategoryList"];

            $iden = htmlspecialchars(mysqli_real_escape_string($conn, $id));
            $pronameen = htmlspecialchars(mysqli_real_escape_string($conn, $proname));
            $shorten = htmlspecialchars(mysqli_real_escape_string($conn, $short));
            $detailen = htmlspecialchars(mysqli_real_escape_string($conn, $detail));
            $categoryen = htmlspecialchars(mysqli_real_escape_string($conn, $category));

            if ($pic["type"] == "image/jpg" || $pic["type"] == "image/jpeg" || $pic["type"] == "image/png" || $pic["type"] == "image/gif") {
                if ($pic["size"] <= 2097152) {
                    $sq = "SELECT * FROM product WHERE ProID = '$iden' or ProName = '$pronameen'";
                    $result = mysqli_query($conn, $sq) or die(mysqli_error($conn));
                    if (mysqli_num_rows($result) == 0) {
                        copy($pic['tmp_name'], "Product/" . $pic['name']);
                        $filePic = $pic['name'];
                        $picture = htmlspecialchars(mysqli_real_escape_string($conn, $filePic));
                        $sqlstring = "INSERT INTO product (ProID, ProName, ProPrice, SmallDesc, DetailDesc, ProDate, Pro_qty, Pro_image, CatID)
                                    VALUES ('$iden', '$pronameen', '$price', '$shorten', '$detailen', '" . date('Y-m-d H:i:s') . "', $qty, '$picture', '$categoryen')";
                        $resultstring = mysqli_query($conn, $sqlstring) or die(mysqli_error($conn));

                        if ($resultstring) {
                            $sqlno = "INSERT INTO noti (Nocontent, createdDate, ProID)
                                        VALUES ('$pronameen is a new product that has been added', '" . date('Y-m-d H:i:s') . "', '$iden')";
                            mysqli_query($conn, $sqlno) or die(mysqli_error($conn));
                        } else {
                            die('Invalid query: ' . mysqli_error($conn));
                        }
                        echo '<meta http-equiv="refresh" content = "0; URL=?page=product_management"/>';
                    } else {
                        echo "<li>Duplicate product ID or Name</li>";
                    }
                } else {
                    echo "Size of image too big";
                }
            } else {
                echo "Image format is not correct";
            }
        }
        ?>

        <div class="my-3">
            <div class="p-5 border">
                <h2 class="text-center mb-4">Adding new Product</h2>

                <form id="frmAddproduct" name="frmAddproduct" method="post" enctype="multipart/form-data" class="form-horizontal" onsubmit="return formValid()">
                    <div class="form-outline">
                        <input type="text" name="txtProID" id="txtProID" class="form-control" placeholder="Product ID (*)" value='<?php echo isset($_POST["txtProID"]) ? ($_POST["txtProID"]) : ""; ?>' />
                        <label class="form-label" for="txtProID"></label>
                    </div>
                    <div class="form-outline">
                        <input type="text" name="txtProName" id="txtProName" class="form-control" placeholder="Product Name (*)" value='<?php echo isset($_POST["txtProName"]) ? ($_POST["txtProName"]) : ""; ?>' />
                        <label class="form-label" for="txtProName"></label>
                    </div>
                    <div class="form-outline">
                        <div name="slcategory">
                            <?php
                            bind_Category_List($conn);
                            ?>
                        </div>
                        <label class="form-label" for=""></label>
                    </div>
                    <div class="form-outline">
                        <input type="number" min="1" name="txtProPrice" id="txtProPrice" class="form-control" placeholder="Price (*)" value='<?php echo isset($_POST["txtProPrice"]) ? ($_POST["txtProPrice"]) : ""; ?>' />
                        <label class="form-label" for="txtProPrice"></label>
                    </div>
                    <div class="form-outline">
                        <input type="text" name="txtSmallDesc" id="txtSmallDesc" class="form-control" placeholder="Small Description (*)" value='<?php echo isset($_POST["txtSmallDesc"]) ? ($_POST["txtSmallDesc"]) : ""; ?>' />
                        <label class="form-label" for="txtSmallDesc"></label>
                    </div>

                    <div class="form-ouline mb-4">
                        <label for="lblDetail" class="control-label"></label>
                        <textarea name="txtDetailDesc" rows="4" placeholder="Detail Description (*)" class="btn-block"></textarea>
                    </div>

                    <div class="form-outline">
                        <input type="number" name="txtQty" id="txtQty" min="1" class="form-control" placeholder="Quantity (*)" value='<?php echo isset($_POST["txtQty"]) ? ($_POST["txtQty"]) : ""; ?>' />
                        <label class="form-label" for="txtQty"></label>
                    </div>

                    <div class="form-outline">
                        <input type="file" name="fileImage" id="fileImage" class="form-control" value="" />
                        <label for="fileImage" class="form-label"></label>
                    </div>

                    <div class="form-ouline mt-2 text-center">
                        <div class="">
                            <input type="submit" class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new" />
                            <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=add_product'" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
?>