<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- CSS only -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />
  <title>Bach hoa si - SecondHand</title>
  <link rel="icon" href="Image/BHS.png" />
</head>
<?php
session_start();
include_once("connectdatabase.php");
?>

<body>
  <div class="container">
    <header class="d-flex flex-wrap text-center justify-content-md-between py-4" style="background-color: #E0E0E0;">
      <div class="col-xl-3 col-lg-3 col-md-3 col-12 ms-lg-2 ms-md-2 d-flex justify-content-center text-dark align-items-center">
        <img title="Bach Hoa Si" onclick="location.href='index.php'" src="Image/BHS.png" height="40" width="40" class="me-2" style="border-radius: 5px" role="button" />
        <form class="d-flex input-group w-auto" method="POST" action="?page=shop">
          <input name="txtSearch" type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
          <button class="btn btn-secondary searching" type="submit" name="btnSearch">
            <i class="bi bi-search"></i>
          </button>
        </form>
      </div>
      <ul class="nav col-xl-auto col-lg-auto col-md-auto col-12 d-flex justify-content-center align-items-center mt-2 mt-lg-0 mt-md-0">
        <li><a href="index.php" class="nav-link px-2 link-dark text-uppercase">Home</a></li>
        <li><a href="?page=shop" class="nav-link px-2 link-dark text-uppercase">Shop</a></li>
        <!-- <li><a href="?page=contact" class="nav-link px-2 link-dark text-uppercase">Contact</a></li> -->
        <li><a href="?page=about" class="nav-link px-2 link-dark text-uppercase">About Us</a></li>
      </ul>
      <div class="col-xl-3 col-lg-3 col-md-3 col-12">
        <?php
        if (isset($_SESSION['us']) && $_SESSION['us'] != "") {
        ?>
          <div class="nav navbar navbar-expand-md d-flex justify-content-center ps-lg-5 ps-xl-5">
            <!-- Icon -->
            <a class="text-reset ms-xl-5" href="?page=cart">
              <i class="bi bi-cart-fill"></i>
            </a>

            <!-- Notifications -->
            <a class="text-reset mx-4" href="?page=notification">
              <i class="bi bi-bell-fill"></i>
            </a>

            <!-- Avatar -->
            <div class="dropdown">
              <a class="dropdown-toggle d-flex align-items-center text-reset" href="#" id="navbarDropdownMenuAvatar" role="button" data-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle" style="color: black;" loading="lazy"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                <li>
                  <a class="dropdown-item" href="">Hi, <?php echo $_SESSION['cname'] ?></a>
                </li>
                <?php
                if ($_SESSION['admin'] == 0) {
                ?>
                  <li>
                    <a class="dropdown-item" href="?page=update_profile">Update profile</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="?page=product_ordered">Ordered</a>
                  </li>
                <?php
                } else {
                ?>
                  <li>
                    <a class="dropdown-item" href="?page=update_profile">Update profile</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="?page=category_management">Category Management</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="?page=product_management">Product Management</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="?page=order_management">Order Management</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="?page=feedback_management">Feedback Management</a>
                  </li>
                <?php
                }
                ?>
                <div class="dropdown-divider"></div>
                <li>
                  <a class="dropdown-item" href="?page=logout">Log out</a>
                </li>
              </ul>
            </div>
          </div>
        <?php
        } else {
        ?>
          <div class="mt-2 mt-lg-0 mt-md-0 d-flex justify-content-center justify-content-md-end me-md-3">
            <a href="?page=login" class="btn btn-outline-primary me-2" class="btn btn-outline-primary" role="button">
              Login
            </a>
            <a href="?page=register" class="btn btn-primary" class="btn btn-outline-primary" role="button">
              Sign-up
            </a>
          </div>
        <?php
        }
        ?>
      </div>
    </header>

    <?php
    if (isset(($_GET['page']))) {
      $page = $_GET['page'];
      if ($page == "register") {
        include_once("Register.php");
      } elseif ($page == "login") {
        include_once("Login.php");
      } elseif ($page == "shop") {
        include_once("Shop.php");
      } elseif ($page == "about") {
        include_once("about.php");
      } elseif ($page == "notification") {
        include_once("Notification.php");
      } elseif ($page == "logout") {
        include_once("Logout.php");
      } elseif ($page == "category_management") {
        include_once("Category_Management.php");
      } elseif ($page == "product_management") {
        include_once("Product_Management.php");
      } elseif ($page == "add_category") {
        include_once("Add_Category.php");
      } elseif ($page == "update_category") {
        include_once("Update_Category.php");
      } elseif ($page == "add_product") {
        include_once("Add_Product.php");
      } elseif ($page == "update_product") {
        include_once("Update_Product.php");
      } elseif ($page == "cart") {
        include_once("Cart.php");
      } elseif ($page == "update_profile") {
        include_once("Update_profile.php");
      } elseif ($page == "viewdetail") {
        include_once("Viewdetail.php");
      } elseif ($page == "order") {
        include_once("Order.php");
      } elseif ($page == "feedback") {
        include_once("Feedback.php");
      } elseif ($page == "order_management") {
        include_once("Order_Management.php");
      } elseif ($page == "feedback_management") {
        include_once("Feed_Management.php");
      } elseif ($page == "product_ordered") {
        include_once("Product_Ordered.php");
      }
    } else {
      include_once("Content.php");
    }
    ?>

    <footer class="text-center bg-light text-muted">
      <!-- Section: Social media -->
      <div class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <!-- Left -->
        <div class="me-5 d-none d-md-block mx-md-4">
          <span>Get connected with us on social networks:</span>
        </div>

        <!-- Right -->
        <div class="mx-md-3">
          <a href="https://www.facebook.com/B%C3%A1ch-Ho%C3%A1-Si-103111491865418/" target="blank" class="me-4 figure" style="color: #3b5998">
            <i class="bi bi-facebook"></i>
          </a>
          <!-- <a href="https://twitter.com/?lang=en" target="blank" class="me-4 figure" style="color: #1da1f2">
            <i class="bi bi-twitter"></i>
          </a> -->
          <a href="https://www.instagram.com/bachhoasii/?hl=en" target="blank" class="figure" style="color: #d6249f">
            <i class="bi bi-instagram"></i>
          </a>
          <!-- <a href="https://www.pinterest.com/" target="blank" class="me-0 figure" style="color: #bd081c">
            <i class="bi bi-pinterest"></i>
          </a> -->
        </div>
      </div>

      <div class="text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row">
          <!-- Grid column -->
          <div class="col-md-4">
            <div class="mx-5 text-center">
              <!-- Content -->
              <h6 class="text-uppercase fw-bold mb-4">
                <i class="bi bi-gem me-2"></i>BACH HOA SI
              </h6>
              <p>
                BHS was founded in 2022. Our store offers a
                huge collection of unisex. What are you waiting for?
                Start shopping online today.
              </p>
            </div>
          </div>

          <!-- Grid column -->
          <div class="col-md-4">
            <div class="text-center">
              <h6 class="text-uppercase fw-bold mb-4">Brands</h6>
              <?php
              $result = mysqli_query($conn, "SELECT c.CatID, c.CatName , COUNT(c.CatID), SUM(Qty)
                                              FROM orderdetail o, product p, category c
                                              WHERE o.ProID = p.ProID AND p.CatID = c.CatID
                                              GROUP BY c.CatID
                                              ORDER BY SUM(Qty)
                                              DESC
                                              LIMIT 4");

              if (!$result) {
                die('Invalid query: ' . mysqli_error($conn));
              }

              while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
              ?>
                <p>
                  <a href="?page=shop&id=<?php echo $row['CatID'] ?>" class="text-reset text-decoration-none"><?php echo $row['CatName'] ?></a>
                </p>
              <?php
              }
              ?>
            </div>
          </div>

          <!-- Grid column -->
          <div class="col-md-4">
            <div class="mx-5 text-center">
              <!-- Links -->
              <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
              <p>
                <i class="bi bi-house-door me-2"></i>Xuan Khanh, Ninh Kieu, Can Tho
              </p>
              <p>
                <i class="bi bi-envelope me-2"></i>quangndgcc200030@fpt.edu.vn
              </p>
              <p><i class="bi bi-telephone me-2"></i>+84 916 843 367</p>
              <p><i class="bi bi-telephone me-2"></i>+84 327 281 160</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05)">© 2022 Copyright:
        <a class="text-reset fw-bold" href="index.php">bachhoasi.com</a>
      </div>
    </footer>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.dropdown-toggle').dropdown();
    });
  </script>
</body>

</html>