<?php
//Get custmer information
$query = "SELECT CustName, CustPhone, CustMail, CustAddress, Birthday
			FROM customer
			WHERE Username = '" . $_SESSION['us'] . "'";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$us = $_SESSION['us'];
$fullname = $row["CustName"];
$telephone = $row["CustPhone"];
$email = $row["CustMail"];
$address = $row["CustAddress"];
$birth = $row["Birthday"];

//Update information when the user presses the "Update" button
if (isset($_POST['btnUpdate'])) {
    $oldPass = md5($_POST['txtoldPass']);
    $newPass = $_POST['txtPass1'];
    $fullname = $_POST['txtFullname'];
    $address = $_POST['txtAddress'];
    $tel = $_POST['txtTel'];
    $year = $_POST['slYear'];
    $month = $_POST["slMonth"];
    $day = $_POST["slDay"];

    if ($_POST['txtPass1'] != "") {
        $res = mysqli_query($conn, "SELECT Password FROM customer WHERE Username = '$us'") or die(mysqli_error($conn));
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $oldPassword = $row['Password'];
        $tempPass = md5($newPass);
        if ($oldPass == $oldPassword) {;
            $sq = "UPDATE customer SET Password = '$tempPass', Custname = '$fullname', Custphone = '$tel', CustAddress = '$address', Birthday = '$year-$month-$day'
                    WHERE Username = '$us'";

            mysqli_query($conn, $sq) or die(mysqli_error($conn));
            echo "<script>alert('Change Password successfully')</script>";
        } else {
            echo "<script>alert('Old Password does not match')</script>";
        }
    } else {
        $sq = "UPDATE customer SET Custname = '$fullname', Custphone = '$tel', CustAddress = '$address', Birthday = '$year-$month-$day'
                WHERE Username = '$us'";
        mysqli_query($conn, $sq) or die(mysqli_error($conn));
    }
    echo '<meta http-equiv="refresh" content = "0; URL=?page=update_profile"/>';
}

//Get birth year
function get_Birth_Year($year)
{
    echo "<select name='slYear' id='slYear' class='form-control'>
            <option value='0'>Choose Year</option>";
    for ($i = 1970; $i <= 2020; $i++) {
        if ($i == $year) {
            echo "<option value='" . $i . "' selected>" . $i . "</option>";
        } else {
            echo "<option value='" . $i . "'>" . $i . "</option>";
        }
    }
    echo "</select>";
}

//Get birth month
function get_Birth_Month($month)
{
    echo "<select name='slMonth' id='slMonth' class='form-control'>
            <option value='0'>Choose Month</option>";
    for ($i = 1; $i <= 12; $i++) {
        if ($i == $month) {
            echo "<option value='" . $i . "' selected>" . $i . "</option>";
        } else {
            echo "<option value='" . $i . "'>" . $i . "</option>";
        }
    }
    echo "</select>";
}

//Get birth day
function get_Birth_Day($day)
{
    echo "<select name='slDay' id='slDay' class='form-control'>
    <option value='0'>Choose Day</option>";
    for ($i = 1; $i <= 31; $i++) {
        if ($i == $day) {
            echo "<option value='" . $i . "' selected>" . $i . "</option>";
        } else {
            echo "<option value='" . $i . "'>" . $i . "</option>";
        }
    }
    echo "</select>";
}
?>
<!--Write formValid() function to check information-->
<script>
    function is_leap_year($year) {
        return $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
    }

    function formValid() {
        f = document.formUpdateprofile
        var phone_pattern = /^(\(0\d{1,3}\)\d{7})|(0\d{9,10})$/;
        var email_pattern = /^[a-zA-Z]\w*(\.\w+)*\@\w+(\.\w{2,3})+$/;

        if (f.txtFullname.value == "") {
            alert("Full name can't be empty");
            f.txtFullname.focus();
            return false;
        }
        if (f.txtPass1.value != f.txtPass2.value) {
            alert("Password and Confirm Pass do not match");
            f.txtPass2.focus();
            return false;
        }
        if (f.txtAddress.value == "") {
            alert("Address can't be empty");
            f.txtAddress.focus();
            return false;
        }
        if (phone_pattern.test(f.txtTel.value) == false) {
            alert("Invalid phone number");
            f.txtTel.focus();
            return false;
        }
        if (f.slYear.value == 0 || f.slMonth.value == 0 || f.slDay.value == 0) {
            alert("Invalid Birthday, please enter again");
            return false;
        }
        if ((is_leap_year(f.slYear.value) && f.slMonth.value == 2) && f.slDay.value > 29) {
            alert("1 Invalid Birthday, please enter again");
            return false;
        }
        if ((!is_leap_year(f.slYear.value) && f.slMonth.value == 2) && f.slDay.value > 28) {
            alert("2 Invalid Birthday, please enter again");
            return false;
        }
        if ((f.slMonth.value == 4 || f.slMonth.value == 6 || f.slMonth.value == 9 || f.slMonth.value == 11) && f.slDay.value > 30) {
            alert("3 Invalid Birthday, please enter again");
            return false;
        }
        return true;
    }
</script>
<div class="container border my-2">
    <div class="mx-md-5 m-2">
        <h2 class="text-center my-4">Update Profile</h2>

        <form id="formUpdateprofile" name="formUpdateprofile" method="post" onsubmit="return formValid()">
            <div class="form-outline mb-3">
                <label class="form-label mb-1 fw-bold" for="txtUsername">Username(*):</label>
                <label class="form-control" name="txtUsername" id="txtUsername" style="font-weight:400"><?php echo $us; ?></label>
            </div>

            <div class="form-group mb-3">
                <label for="txtoldPass" class="control-label mb-1 fw-bold">Old Password(*):</label>
                <input type="password" name="txtoldPass" id="txtoldPass" class="form-control" />
            </div>

            <div class="form-group mb-3">
                <label for="txtPass1" class="control-label mb-1 fw-bold">Password(*):</label>
                <input type="password" name="txtPass1" id="txtPass1" class="form-control" />
            </div>

            <div class="form-group mb-3">
                <label for="txtPass2" class="control-label mb-1 fw-bold">Confirm Password(*): </label>
                <input type="password" name="txtPass2" id="txtPass2" class="form-control" />
            </div>

            <div class="form-group mb-3">
                <label for="txtFullname" class="control-label mb-1 fw-bold">Full name(*): </label>
                <input type="text" name="txtFullname" id="txtFullname" value="<?php echo $fullname; ?>" class="form-control" placeholder="Enter Fullname, please" />
            </div>

            <div class="form-outline mb-3">
                <label for="txtCustMail" class="form-label mb-1 fw-bold">Email(*):</label>
                <label class="form-control" style="font-weight:400"><?php echo $email; ?></label>
            </div>

            <div class="form-group mb-3">
                <label for="txtAddress" class="control-label mb-1 fw-bold">Address(*):</label>
                <input type="text" name="txtAddress" id="txtAddress" value="<?php echo $address; ?>" class="form-control" placeholder="Enter Address, please" />
            </div>

            <div class="form-group mb-3">
                <label for="txtTel" class="control-label mb-1 fw-bold">Telephone(*): </label>
                <input type="text" name="txtTel" id="txtTel" value="<?php echo $telephone; ?>" class="form-control" placeholder="Enter Telephone, please" />
            </div>

            <div class="form-group mb-3">
                <label for="txtTel" class="control-label mb-1 fw-bold">Birthday(*): </label>
                <div class="input-group">
                    <span class="col-md-4 pb-md-0 col-12 pb-2">
                        <?php
                        get_Birth_Year(date('Y', strtotime($birth)));
                        ?>
                    </span>
                    <span class="col-md-4 px-md-2 col-12">
                        <?php
                        get_Birth_Month(date('m', strtotime($birth)));
                        ?>
                    </span>
                    <span class="col-md-4 pt-md-0 col-12 pt-2">
                        <?php
                        get_Birth_Day(date('d', strtotime($birth)));
                        ?>

                    </span>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="">
                    <input type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" />
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
    });
</script>