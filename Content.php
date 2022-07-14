<style>
  h2 {
    color: #000;
    font-size: 26px;
    font-weight: 300;
    text-align: center;
    text-transform: uppercase;
    position: relative;
    margin-top: 30px;
  }

  h2::after {
    content: "";
    width: 100px;
    position: absolute;
    margin: 0 auto;
    height: 4px;
    border-radius: 1px;
    background: wheat;
    left: 0;
    right: 0;
    bottom: -20px;
  }
</style>
<section class="my-2">
  <div class="p-5 mb-2 text-center bg-image" style="background-image: url(Image/backgroung.jpg);">
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6)">
      <div class="d-flex justify-content-center align-items-center h-100">
        <div class="text-white">
          <h1>SUMMER - AUTUMN</h1>
          <h1 class="mb-3">2022</h1>
          <a class="btn btn-outline-light btn-lg mb-3" href="?page=shop" role="button">Shop Now</a>
        </div>
      </div>
    </div>
  </div>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" src="Image/clothes.png" alt="First slide" />
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="Image/clothes1.jpg" alt="Second slide" />
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="Image/clothes2.jpg" alt="Third slide" />
      </div>
    </div>
    <a class="carousel-control-prev text-decoration-none" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only d-none d-md-block">Previous</span>
    </a>
    <a class="carousel-control-next text-decoration-none" href="#myCarousel" role="button" data-slide="next">
      <span class="sr-only d-none d-md-block">Next</span>
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
  </div>
  <hr>
  <div class="promo-area mt-2">
    <div class="zigzag-bottom"></div>
    <div class="row">
      <div class="col-md-4 col-sm-12">
        <div class="single-promo promo1">
          <i class="bi bi-truck"></i>
          <p>Free ship</p>
        </div>
      </div>
      <div class="col-md-4 col-sm-12 my-2 my-lg-0 my-md-0">
        <div class="single-promo promo2">
          <i class="bi bi-lock-fill"></i>
          <p>Payment security</p>
        </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="single-promo promo3">
          <i class="bi bi-gift-fill"></i>
          <p>New Product</p>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div id="brand">
    <h2><b>Brands</b></h2>
    <div class="row mt-50">
      <?php
      $result = mysqli_query($conn, "SELECT c.CatID, c.Cat_image, c.CatName, COUNT(c.CatID), SUM(Qty)
                                      FROM orderdetail o, product p, category c
                                      WHERE o.ProID = p.ProID AND p.CatID = c.CatID
                                      GROUP BY c.CatID
                                      ORDER BY SUM(Qty)
                                      DESC
                                      LIMIT 6");

      if (!$result) {
        die('Invalid query: ' . mysqli_error($conn));
      }

      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      ?>
        <a href="?page=shop&&id=<?php echo $row['CatID'] ?>" class="col-12 col-sm-6 col-md-4 px-5 py-3 d-flex align-items-center justify-content-center">
          <img class="img-fluid" src="Category/<?php echo $row['Cat_image'] ?>" alt="<?php echo $row['CatName'] ?>">
        </a>
      <?php
      }
      ?>
    </div>
  </div>
  <hr>
  <div class="mt-2">
    <h2><b>Top 4 - Products</b></h2>
    <div class="d-flex justify-content-center mt-50">
      <div class="row">
        <?php
        $No = 1;
        //Display best - selling product
        $result = mysqli_query($conn, "SELECT * , COUNT(o.ProID), SUM(Qty)
                                        FROM orderdetail o, product p
                                        WHERE o.ProID = p.ProID
                                        GROUP BY o.ProID
                                        ORDER BY SUM(Qty)
                                        DESC
                                        LIMIT 4;");

        if (!$result) {
          die('Invalid query: ' . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          if ($No <= 4) {
        ?>
            <div class="col-12 col-lg-3 col-sm-6">
              <div class="product-grid">
                <div class="product-image">
                  <a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>" class="image">
                    <img class="img-1" src="Product/<?php echo $row['Pro_image'] ?>">
                  </a>
                  <!-- <ul class="product-links">
                    <li><a href="#" data-tip="Add to Wishlist"><i class="bi bi-heart"></i></a></li>
                    <li><a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>" data-tip="View Detail"><i class="bi bi-eye-fill"></i></a></li>
                    <li><a href="#" data-tip="Compare"><i class="bi bi-cart-fill"></i></a></li>
                  </ul> -->
                </div>
                <div class="product-content">
                  <div class="price"><b>$<?php echo $row['ProPrice'] ?></b></div>
                  <h3 class="title"><a href="?page=viewdetail&id=<?php echo $row['ProID'] ?>" class="text-decoration-none"><?php echo $row['ProName'] ?></a></h3>
                </div>
              </div>
            </div>
        <?php
          }
          $No++;
        }
        ?>
      </div>
    </div>
  </div>
  <hr>
</section>