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
                f = document.formUpdatecategory

                if (f.txtCatName.value == "") {
                    alert("Category Name can't be empty, please enter again");
                    f.txtCatName.focus();
                    return false;
                }
                if (f.txtCatDesc.value == "") {
                    alert("Category Description can't be empty, please enter again");
                    f.txtCatDesc.focus();
                    return false;
                }
                return true;
            }
        </script>
        <?php
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $result = mysqli_query($conn, "SELECT * FROM category WHERE CatID = '$id'");
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $cat_id = $row["CatID"];
            $cat_name = $row["CatName"];
            $cat_des = $row["CatDesc"];
            $pic = $row["Cat_image"];

        ?>
            <div class="container border my-2">
                <div class="m-5">
                    <h2 class="text-center mb-4">Updating Product Category</h2>
                    <form id="formUpdatecategory" name="formUpdatecategory" enctype="multipart/form-data" method="POST" onsubmit="return formValid()">
                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtCatID">Category ID:</label>
                            <input type="text" name="txtCatID" id="txtCatID" class="form-control" readonly value='<?php echo $cat_id; ?>' />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtCatName">Category Name:</label>
                            <input type="text" name="txtCatName" id="txtCatName" class="form-control" value='<?php echo $cat_name ?>' />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtCatDesc">Category Description:</label>
                            <input type="text" name="txtCatDesc" id="txtCatDesc" class="form-control" value='<?php echo $cat_des ?>' />
                        </div>

                        <div class="form-outline mb-3">
                            <label for="fileImage" class="form-label mb-1 fw-bold">Choose Picture:</label><br>
                            <img src='Category/<?php echo $pic; ?>' class="mb-2" border='0' width="100" height="50" />
                            <input type="file" name="fileImage" id="fileImage" class="form-control" value="">
                        </div>

                        <div class="form-group text-center">
                            <div class="">
                                <input type="submit" class="btn btn-primary" name="btnUpdateCat" id="btnUpdateCat" value="Update" />
                                <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=update_category&&id=<?php echo $row['CatID']; ?>'" />
                                <input type="button" class="btn btn-primary" name="btnCancel" id="btnCancel" value="Cancel" onclick="window.location='?page=category_management'" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
<?php
            if (isset($_POST["btnUpdateCat"])) {
                $id = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatID"]));
                $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatName"]));
                $des = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatDesc"]));
                $pic = $_FILES["fileImage"];

                if ($pic['name'] != "") {
                    if ($pic["type"] == "image/jpg" || $pic["type"] == "image/jpeg" || $pic["type"] == "image/png" || $pic["type"] == "image/gif") {
                        if ($pic["size"] <= 2097152) {
                            $sq = "SELECT * FROM category where CatID != '$id' AND CatName = '$name'";
                            $result = mysqli_query($conn, $sq);
                            if (mysqli_num_rows($result) == 0) {
                                copy($pic['tmp_name'], "Category/" . $pic['name']);
                                $filePic = $pic['name'];
                                $picturecategory = htmlspecialchars(mysqli_real_escape_string($conn, $filePic));
                                mysqli_query($conn, "UPDATE category SET CatName = '$name', CatDesc = '$des', Cat_image = '$picturecategory' WHERE CatID = '$id'");
                                echo '<meta http-equiv="refresh" content = "0; URL=?page=category_management"/>';
                            } else {
                                echo "<li>Duplicate category Name</li>";
                            }
                        } else {
                            echo "Size of image too big";
                        }
                    } else {
                        echo "Image format is not correct";
                    }
                } else {
                    $sq = "SELECT * FROM category WHERE CatID != '$id' AND CatName = '$name'";
                    $result = mysqli_query($conn, $sq);
                    if (mysqli_num_rows($result) == 0) {
                        mysqli_query($conn, "UPDATE category SET CatName = '$name', CatDesc = '$des' WHERE CatID = '$id'");
                        echo '<meta http-equiv="refresh" content = "0; URL=?page=category_management"/>';
                    } else {
                        echo "<li>Dulicate category Name</li>";
                    }
                }
            }
        } else {
            echo '<meta http-equiv="refresh" content = "0; URL=?page=category_management"/>';
        }
    }
}
?>