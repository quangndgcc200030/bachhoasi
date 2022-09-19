<div class="row">
  <div class="col-lg-2 col-md-3 ps-0">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md bg-light navbar-light bg-white">
      <!-- Toggle button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Brand -->
      <a class="text-decoration-none text-black ps-3" href="index.php">
        <h3>BACH HOA SI</h3>
      </a>
    </nav>
    <!-- Navbar -->

    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-md-block bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush">
          <a href="?page=shop" class="list-group-item list-group-item-action py-2">All</a>
          <?php
          $per_page_record_C = 20;

          if (isset($_GET["pagec"])) {
            $pageC  = $_GET["pagec"];
          } else {
            $pageC = 1;
          }
          $start_from_C = ($pageC - 1) * $per_page_record_C;

          $result = mysqli_query($conn, "SELECT CatID, CatName FROM category LIMIT $start_from_C, $per_page_record_C");

          if (!$result) {
            die('Invalid query: ' . mysqli_error($conn));
          }

          $query = "SELECT COUNT(*) FROM category";
          $rs_result = mysqli_query($conn, $query);
          $row = mysqli_fetch_row($rs_result);
          $total_records_C = $row[0];

          $total_pages_C = ceil($total_records_C / $per_page_record_C);

          while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          ?>
            <a href="?page=shop&id=<?php echo $row['CatID'] ?>" class="list-group-item list-group-item-action py-2"><?php echo $row['CatName'] ?></a>
          <?php
          }
          ?>
        </div>
      </div>
      <small>
        <nav aria-label="Page navigation example">
          <ul class="pagination pg-blue justify-content-center mt-2">
            <?php
            $pagLinkC = "";
            if ($pageC >= 2) {
              echo "<li class='page-item'>
                      <a class='page-link' href='?page=shop&&pagec=" . ($pageC - 1) . "' aria-label='Previous'>
                        <span aria-hidden='true'>&laquo;</span>
                      </a>
                    </li>";
            }
            for ($i = 1; $i <= $total_pages_C; $i++) {
              if ($i == $pageC) {
                $pagLinkC .= "<li class='page-item'><a class='page-link' href='?page=shop&&pagec=" . $i . "'>" . $i . "</a></li>";
              } else {
                $pagLinkC .= "<li class='page-item'><a class='page-link' href='?page=shop&&pagec=" . $i . "'>" . $i . "</a></li>";
              }
            };
            echo $pagLinkC;
            if ($pageC < $total_pages_C) {
              echo "<li class='page-item'>
                    <a class='page-link' href='?page=shop&&pagec=" . ($pageC + 1) . "' aria-label='Next'>
                      <span aria-hidden='true'>&raquo;</span>
                    </a>
                  </li>";
            }
            ?>
          </ul>
        </nav>
      </small>
    </nav>
    <!-- Sidebar -->
  </div>
  <div class="col-lg-10 col-md-9 col-12 pe-0">
    <div id="carouselExampleSlidesOnly" class="carousel slide mb-3 mt-2" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" src="Image/Fashion-ads-3.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="Image/Fashion-ads-2.png" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="Image/Fashion-ads-1.jpg" alt="Third slide">
        </div>
      </div>
    </div>
    <section>
      <div class="row">
        <?php
        $per_page_record = 12;

        if (isset($_GET["pagep"])) {
          $page  = $_GET["pagep"];
        } else {
          $page = 1;
        }
        $start_from = ($page - 1) * $per_page_record;
        /*Show by Brand*/
        if (isset($_GET["id"])) {
          $id = $_GET["id"];

          $result = mysqli_query($conn, "SELECT * FROM product WHERE CatID = '$id' ORDER BY ProDate DESC LIMIT $start_from, $per_page_record");

          if (!$result) {
            die('Invalid query: ' . mysqli_error($conn));
          }
          $query = "SELECT COUNT(*) FROM product WHERE CatID = '$id'";
          $rs_result = mysqli_query($conn, $query);
          $row = mysqli_fetch_row($rs_result);
          $total_records = $row[0];
          echo "</br>";
          $total_pages = ceil($total_records / $per_page_record);
          while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if ($row['CatID'] == $id) {
        ?>
              <div class="col-12 col-md-3 col-sm-6 mb-md-4">
                <div class="product-grid1">
                  <div class="product-image1">
                    <a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>" class="image1">
                      <img class="img" src="Product/<?php echo $row['Pro_image'] ?>">
                    </a>
                    <!-- <ul class="product-links1">
                      <li><a href="#" data-tip="Add to Wishlist"><i class="bi bi-heart"></i></a></li>
                      <li><a href="#" data-tip="Compare"><i class="bi bi-shuffle"></i></i></a></li>
                      <li><a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>" data-tip="Quick View"><i class="bi bi-eye-fill"></i></a></li>
                    </ul> -->
                  </div>
                  <div class="product-content1">
                  <div class="title1 mb-2"><a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>"><strong><?php echo $row['ProName'] ?></strong></a></div>
                    <div class="price1">$<?php echo $row['ProPrice'] ?></div>
                    <form action="?page=cart" method="POST" class="d-flex">
                      <input type="hidden" name="quantity" class="text-center" value="1">
                      <input type="submit" name="addcart" class="add-to-cart" value="Add to cart">
                      <input type="hidden" name="proid" value="<?php echo $id ?>">
                      <input type="hidden" name="proname" value="<?php echo $row['ProName'] ?>">
                      <input type="hidden" name="shortdesc" value="<?php echo $row['SmallDesc'] ?>">
                      <input type="hidden" name="image" value="<?php echo $row['Pro_image'] ?>">
                      <input type="hidden" name="price" value="<?php echo $row['ProPrice'] ?>">
                    </form>
                  </div>
                </div>
              </div>
            <?php
            }
          }
        } elseif (isset($_POST['btnSearch'])) {
          /*Searching*/
          $searching = $_POST['txtSearch'];

          $keywords = explode(' ', $searching);
          $searchTermKeywords = array();

          foreach ($keywords as $word) {
            $searchTermKeywords[] = "ProName LIKE '%$word%'";
          }

          $result = mysqli_query($conn, "SELECT * FROM product WHERE " . implode('AND ', $searchTermKeywords) . "ORDER BY ProDate DESC LIMIT $start_from, $per_page_record");

          if (!$result) {
            die('Invalid query: ' . mysqli_error($conn));
          }
          $query = "SELECT COUNT(*) FROM product WHERE " . implode('AND ', $searchTermKeywords) . "";
          $rs_result = mysqli_query($conn, $query);
          $row = mysqli_fetch_row($rs_result);
          $total_records = $row[0];
          echo "</br>";
          $total_pages = ceil($total_records / $per_page_record);
          while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>
            <div class="col-12 col-md-3 col-sm-6 mb-md-4">
              <div class="product-grid1">
                <div class="product-image1">
                  <a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>" class="image1">
                    <img class="img" src="Product/<?php echo $row['Pro_image'] ?>">
                  </a>
                  <!-- <ul class="product-links1">
                    <li><a href="#" data-tip="Add to Wishlist"><i class="bi bi-heart"></i></a></li>
                    <li><a href="#" data-tip="Compare"><i class="bi bi-shuffle"></i></i></a></li>
                    <li><a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>" data-tip="Quick View"><i class="bi bi-eye-fill"></i></a></li>
                  </ul> -->
                </div>
                <div class="product-content1">
                <div class="title1 mb-2"><a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>"><strong><?php echo $row['ProName'] ?></strong></a></div>
                  <div class="price1">$<?php echo $row['ProPrice'] ?></div>
                  <form action="?page=cart" method="POST" class="d-flex">
                    <input type="hidden" name="quantity" class="text-center" value="1">
                    <input type="submit" name="addcart" class="add-to-cart" value="Add to cart">
                    <input type="hidden" name="proid" value="<?php echo $row['ProID'] ?>">
                    <input type="hidden" name="proname" value="<?php echo $row['ProName'] ?>">
                    <input type="hidden" name="shortdesc" value="<?php echo $row['SmallDesc'] ?>">
                    <input type="hidden" name="image" value="<?php echo $row['Pro_image'] ?>">
                    <input type="hidden" name="price" value="<?php echo $row['ProPrice'] ?>">
                  </form>
                </div>
              </div>
            </div>
          <?php
          }
        } else {
          /*Show all*/
          $result = mysqli_query($conn, "SELECT * FROM product ORDER BY ProDate DESC LIMIT $start_from, $per_page_record");

          if (!$result) {
            die('Invalid query: ' . mysqli_error($conn));
          }
          $query = "SELECT COUNT(*) FROM product";
          $rs_result = mysqli_query($conn, $query);
          $row = mysqli_fetch_row($rs_result);
          $total_records = $row[0];
          echo "</br>";
          $total_pages = ceil($total_records / $per_page_record);
          while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          ?>
            <div class="col-12 col-lg-4 col-xl-3 col-md-6 col-sm-6 mb-xl-4">
              <div class="product-grid1">
                <div class="product-image1">
                  <a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>" class="image1">
                    <img class="img" src="Product/<?php echo $row['Pro_image'] ?>">
                  </a>
                  <!-- <ul class="product-links1">
                    <li><a href="#" data-tip="Add to Wishlist"><i class="bi bi-heart"></i></a></li>
                    <li><a href="#" data-tip="Compare"><i class="bi bi-shuffle"></i></i></a></li>
                    <li><a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>" data-tip="Quick View"><i class="bi bi-eye-fill"></i></a></li>
                  </ul> -->
                </div>
                <div class="product-content1">
                  <div class="title1 mb-2"><a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>"><strong><?php echo $row['ProName'] ?></strong></a></div>
                  <div class="price1">$<?php echo $row['ProPrice'] ?></div>
                  <form action="?page=cart" method="POST" class="d-flex">
                    <input type="hidden" name="quantity" class="text-center" value="1">
                    <input type="submit" name="addcart" class="add-to-cart" value="Add to cart">
                    <input type="hidden" name="proid" value="<?php echo $row['ProID'] ?>">
                    <input type="hidden" name="proname" value="<?php echo $row['ProName'] ?>">
                    <input type="hidden" name="shortdesc" value="<?php echo $row['SmallDesc'] ?>">
                    <input type="hidden" name="image" value="<?php echo $row['Pro_image'] ?>">
                    <input type="hidden" name="price" value="<?php echo $row['ProPrice'] ?>">
                  </form>
                </div>
              </div>
            </div>
        <?php
          }
        }
        ?>
      </div>
    </section>
    <nav aria-label="Search results pages">
      <ul class="pagination justify-content-center">
        <?php
        $pagLink = "";
        if ($page >= 2) {
          echo "<li class='page-item'>
                    <a class='page-link' href='?page=shop&&pagep=" . ($page - 1) . "'>Previous</a>
                </li>";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
          if ($i == $page) {
            $pagLink .= "<li class='page-item active'>
                            <a class='page-link' href='?page=shop&&pagep=" . $i . "'>" . $i . "</a>
                        </li>";
          } else {
            $pagLink .= "<li class='page-item'>
                            <a class='page-link' href='?page=shop&&pagep=" . $i . "'>" . $i . "</a>
                          </li>";
          }
        };
        echo $pagLink;
        if ($page < $total_pages) {
          echo "<li class='page-item'>
                    <a class='page-link' href='?page=shop&&pagep=" . ($page + 1) . "'>Next</a>
                  </li>";
        }
        ?>
      </ul>
    </nav>
  </div>
</div>