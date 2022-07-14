<style>
  .col-md-6 {
    padding: 0 5px 0 0px;
  }
</style>
<?php
if (isset($_POST["btnSignup"])) {
  $username = $_POST["txtUsername"];
  $pass = $_POST["txtPassword"];
  $confirmPass = $_POST["txtConfirmPass"];
  $firstname = $_POST["txtFirstname"];
  $lastname = $_POST["txtLastname"];
  $year = $_POST["slYear"];
  $month = $_POST["slMonth"];
  $day = $_POST["slDay"];

  if (isset($_POST["cbSex"])) {
    $sex = $_POST["cbSex"];
  }

  $phone = $_POST["txtTelephone"];
  $email = $_POST["txtEmail"];
  $address = $_POST["txtAddress"];

  include_once("connectdatabase.php");
  $password = md5($pass);
  $sq = "SELECT * FROM customer where Username = '$username' or CustMail = '$email' or CustPhone = '$phone'";
  $result = mysqli_query($conn, $sq);
  if (mysqli_num_rows($result) == 0) {
    mysqli_query($conn, "INSERT INTO customer (UserName, Password, CustName, CustSex, CustPhone, CustMail, CustAddress, Birthday, State)
                            VALUES ('$username', '$password', '$firstname $lastname', '$sex', '$phone', '$email', '$address', '$year-$month-$day', 0)");
    echo ("<script>alert('You registered successfully')</script>");
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
  } else {
    echo "<script>alert('Username, email, or telephone already exists')</script>";
  }
}
?>
<script>
  function hasWhiteSpace(s) {
    return (/\s/).test(s);
  }

  function is_leap_year($year) {
    return $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
  }

  function formValid() {
    f = document.formRegister
    var validname = /^[A-Za-z]+|(\s)$/;
    var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
    var phone_pattern = /^(\(0\d{1,3}\)\d{7})|(0\d{9,10})$/;
    var email_pattern = /^[a-zA-Z]\w*(\.\w+)*\@\w+(\.\w{2,3})+$/;

    // Username validation
    if (f.txtUsername.value == "" || hasWhiteSpace(f.txtUsername.value)) {
      alert("Username can't be empty and special character, please enter again");
      f.txtUsername.focus();
      return false;
    }
    if (format.test(f.txtUsername.value)) {
      alert("Invalid Username, please enter again");
      f.txtUsername.focus();
      return false;
    }
    // Password validation
    if (f.txtPassword.value == "" || f.txtConfirmPass.value == "") {
      alert("Password and Confirm Password can't be empty, please enter again");
      f.txtPassword.focus();
      return false;
    }
    if (f.txtPassword.value.length <= 5) {
      alert("Password must be greater than 5 chars, please enter again");
      f.txtPassword.focus();
      return false;
    }
    if (f.txtPassword.value != f.txtConfirmPass.value) {
      alert("Password and Confirm Pass do not match, please enter again");
      f.txtConfirmPass.focus();
      return false;
    }
    // Firstname and Lastname validation
    if (f.txtFirstname.value == "" || format.test(f.txtFirstname.value) || validname.test(f.txtFirstname.value) == false) {
      alert("First name can't be empty, number, and special character. Please enter again");
      f.txtFirstname.focus();
      return false;
    }
    if (f.txtLastname.value == "" || format.test(f.txtLastname.value) || validname.test(f.txtLastname.value) == false) {
      alert("Last name can't be empty, number, and special character. Please enter again");
      f.txtLastname.focus();
      return false;
    }
    // Sex validation
    if (f.cbSex.value == 0) {
      alert("Please choose your sex");
      return false;
    }
    // DoB validation
    if (f.slYear.value == 0 || f.slMonth.value == 0 || f.slDay.value == 0) {
      alert("Invalid Birthday, please enter again");
      return false;
    }
    if ((is_leap_year(f.slYear.value) && f.slMonth.value == 2) && f.slDay.value > 29) {
      alert("Invalid Birthday, please enter again");
      return false;
    }
    if ((!is_leap_year(f.slYear.value) && f.slMonth.value == 2) && f.slDay.value > 28) {
      alert("Invalid Birthday, please enter again");
      return false;
    }
    if ((f.slMonth.value == 4 || f.slMonth.value == 6 || f.slMonth.value == 9 || f.slMonth.value == 11) && f.slDay.value > 30) {
      alert("Invalid Birthday, please enter again");
      return false;
    }
    // Telephone validation
    if (phone_pattern.test(f.txtTelephone.value) == false) {
      alert("Invalid phone number, please enter again");
      f.txtTelephone.focus();
      return false;
    }
    // Email validation
    if (email_pattern.test(f.txtEmail.value) == false) {
      alert("Invalid email address, please enter again");
      f.txtEmail.focus();
      return false;
    }
    // Address validation
    if (f.txtAddress.value == "") {
      alert("Address can't be empty, please enter again");
      f.txtAddress.focus();
      return false;
    }
    if (format.test(f.txtAddress.value)) {
      alert("Invalid Address, please enter again");
      f.txtAddress.focus();
      return false;
    }
    return true;
  }
</script>
<div class="my-2">
  <section class="d-flex justify-content-center align-items-center h-100 border">
    <div class="row g-0">
      <div class="col-lg-6 d-none d-lg-block">
        <img src="Image/register.jpg" width="100%">
      </div>
      <div class="col-lg-6 my-4" style="background-color: #f3f3f3;">
        <form id="formRegister" name="formRegister" method="POST" class="card-body p-md-5 text-black" onsubmit="return formValid()">
          <h3 class="mb-5 text-uppercase" align="center">
            <strong>Customer registration</strong>
          </h3>

          <div class="form-outline mb-0">
            <input type="text" id="txtUsername" class="form-control" name="txtUsername" placeholder="Username(*)" value='<?php echo isset($_POST["txtUsername"]) ? ($_POST["txtUsername"]) : ""; ?>' />
            <label class="form-label" for="txtUsername"></label>
          </div>

          <div class="form-outline mb-0">
            <input type="password" id="txtPassword" class="form-control" name="txtPassword" placeholder="Password(*)" />
            <label class="form-label" for="txtPassword"></label>
          </div>

          <div class="form-outline mb-0">
            <input type="password" id="txtConfirmPass" class="form-control" name="txtConfirmPass" placeholder="Confirm Password(*)" />
            <label class="form-label" for="txtConfirmPass"></label>
          </div>

          <div class="row">
            <div class="col-md-6 mb-0">
              <div class="form-outline">
                <input type="text" id="txtFirstname" class="form-control" name="txtFirstname" placeholder="First name(*)" value='<?php echo isset($_POST["txtFirstname"]) ? ($_POST["txtFirstname"]) : ""; ?>' />
                <label class="form-label" for="txtFirstname"></label>
              </div>
            </div>
            <div class="col-md-6 mb-0">
              <div class="form-outline">
                <input type="text" id="txtLastname" class="form-control" name="txtLastname" placeholder="Last name(*)" value='<?php echo isset($_POST["txtLastname"]) ? ($_POST["txtLastname"]) : ""; ?>' />
                <label class="form-label" for="txtLastname"></label>
              </div>
            </div>
          </div>

          <div class="d-md-flex justify-content-start align-items-center mb-3">
            <h6 class="mb-3 mb-lg-0 me-4">Gender:</h6>

            <div class="form-check form-check-inline mb-0 me-4">
              <input class="form-check-input" type="radio" name="cbSex" id="MaleGender" value="Male" />
              <label class="form-check-label" for="femaleGender">Male</label>
            </div>

            <div class="form-check form-check-inline mb-0 me-4">
              <input class="form-check-input" type="radio" name="cbSex" id="FemaleGender" value="Female" />
              <label class="form-check-label" for="maleGender">Female</label>
            </div>
          </div>

          <div class="d-md-flex justify-content-start align-items-center pb-4">
            <h6 class="mb-md-0 me-3 mb-3">Birthday:</h6>
            <div class="input-group">
              <span class="col-md-4 pb-md-0 col-12 pb-2">
                <select name="slYear" id="slYear" class="form-control">
                  <option value="0">Choose Year</option>
                  <?php
                  for ($i = 1970; $i <= 2020; $i++) {
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                  }
                  ?>
                </select>
              </span>
              <span class="col-md-4 py-md-0 col-12 py-2">
                <select name="slMonth" id="slMonth" class="form-control">
                  <option value="0">Choose Month</option>
                  <?php
                  for ($i = 1; $i <= 12; $i++) {
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                  }

                  ?>
                </select>
              </span>
              <span class="col-md-4 pt-md-0 col-12 pt-2">
                <select name="slDay" id="slDay" class="form-control">
                  <option value="0">Choose Day</option>
                  <?php
                  for ($i = 1; $i <= 31; $i++) {
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                  }
                  ?>
                </select>
              </span>
            </div>
          </div>

          <div class="form-outline mb-0">
            <input type="text" id="txtTelephone" class="form-control" name="txtTelephone" placeholder="Telephone(*)" value='<?php echo isset($_POST["txtTelephone"]) ? ($_POST["txtTelephone"]) : ""; ?>' />
            <label class="form-label" for="txtTelephone"></label>
          </div>

          <div class="form-outline mb-0">
            <input type="text" id="txtEmail" class="form-control" name="txtEmail" placeholder="Email(*)" value='<?php echo isset($_POST["txtEmail"]) ? ($_POST["txtEmail"]) : ""; ?>' />
            <label class="form-label" for="txtEmail"></label>
          </div>

          <div class="form-outline mb-0">
            <input type="text" id="txtAddress" class="form-control" name="txtAddress" placeholder="Address(*)" value='<?php echo isset($_POST["txtAddress"]) ? ($_POST["txtAddress"]) : ""; ?>' />
            <label class="form-label" for="txtAddress"></label>
          </div>

          <div class="d-flex justify-content-end pt-0">
            <button class="btn btn-light btn-lg" name="btnReset" onclick="window.location='?page=register'">
              Reset all
            </button>
            <button type="submit" class="btn btn-dark btn-lg ms-2" name="btnSignup">
              Sign up
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>