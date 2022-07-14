<script>
    function formValid() {
        f = document.feedbackform;

        if (f.txtname.value == "" || f.txtusername.value == "" || f.txtproduct.value == "" || f.txtmessage.value == "") {
            alert("Enter fileds with marks(*), please");
            f.txtmessage.focus();
            return false;
        }
        return true;
    }
</script>
<?php
if (isset($_SESSION['us']) == false) {
    echo "<script>alert('You need to login before accessing this page')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        echo "<script>alert('You are authorized that cant not access this page')</script>";
        echo '<meta http-equiv="refresh" content = "0; URL=?page=shop"/>';
    } else {
        if (isset($_POST['btnSendfeedback'])) {
            $fid = $_POST['txtid'];
            $us = $_POST['txtusername'];
            $content = $_POST['txtmessage'];

            mysqli_query($conn, "INSERT INTO feedback (Content, sendDate, Username, ProID) VALUES ('$content', '" . date('Y-m-d H:i:s') . "', '$us', '$fid')");
            echo '<meta http-equiv="refresh" content = "0; URL=?page=shop"/>';
            echo "<script>alert('Send feedback successfully')</script>";
        }
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sq = "SELECT ProName FROM product WHERE ProID = '$id'";
            $res = mysqli_query($conn, $sq);
            if (!$res) {
                die('Invalid query: ' . mysqli_error($conn));
            }
            $row = mysqli_fetch_array($res, MYSQLI_ASSOC)
?>
            <section class="my-2 border" style="background-color: #f3f3f3">
                <div class="m-md-5 m-3 card">
                    <!--Section heading-->
                    <h2 class="font-weight-bold text-center py-3">
                        Feedback
                    </h2>
                    <!--Section description-->
                    <p class="text-center w-responsive mx-3 mx-md-5 mb-4">
                        Do you have any feedback? Please do not hesitate to contact us directly.
                    </p>

                    <form id="feedbackform" name="feedbackform" method="POST" class="mx-md-5 m-3" onsubmit="return formValid()">
                        <!--Grid row-->
                        <div class="row">
                            <!--Grid column-->
                            <div class="col-md-6">
                                <input type="hidden" name="txtid" value="<?php echo $id ?>">
                                <input type="text" id="txtname" name="txtname" class="form-control" placeholder="Your name (*)" value="<?php echo $_SESSION['cname'] ?>" />
                                <label for="name" class=""></label>
                            </div>
                            <!--Grid column-->

                            <!--Grid column-->
                            <div class="col-md-6">
                                <input type="text" id="txtusername" name="txtusername" class="form-control" placeholder="Username (*)" value="<?php echo $_SESSION['us'] ?>" />
                                <label for="email" class=""></label>
                            </div>
                            <!--Grid column-->
                        </div>
                        <!--Grid row-->

                        <div class="mx-2">
                            <!--Grid row-->
                            <input type="text" id="txtproduct" name="txtproduct" class="form-control" placeholder="Product (*)" value="<?php echo $row['ProName'] ?>" />
                            <label for="product" class=""></label>
                            <!--Grid row-->

                            <!--Grid row-->
                            <textarea type="text" id="txtmessage" name="txtmessage" rows="3" class="form-control md-textarea" placeholder="Your feedback (*)"></textarea>
                            <label for="message"></label>
                            <!--Grid row-->
                            <div class="form-ouline text-center">
                                <input type="submit" class="btn btn-primary" name="btnSendfeedback" id="btnSendfeedback" value="Send Feedback" />
                                <input type="button" class="btn btn-primary" name="btnCancel" id="btnCancel" value="Cancel" onclick="window.location='?page=viewdetail&id=<?php echo $id ?>'" />
                            </div>
                        </div>
                    </form>
                </div>
            </section>
<?php
        }
    }
}
?>