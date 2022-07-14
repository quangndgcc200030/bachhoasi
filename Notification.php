<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<style>
    .alert {
        border-radius: 0;
        -webkit-border-radius: 0;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.11);
        display: table;
        width: 100%;
    }

    .alert-white {
        background-image: linear-gradient(to bottom, #fff, #f9f9f9);
        border-top-color: #d8d8d8;
        border-bottom-color: #bdbdbd;
        border-left-color: #cacaca;
        border-right-color: #cacaca;
        color: #404040;
        padding-left: 61px;
        position: relative;
    }

    .alert-white.rounded {
        border-radius: 3px;
        -webkit-border-radius: 3px;
    }

    .alert-white.rounded .icon {
        border-radius: 3px 0 0 3px;
        -webkit-border-radius: 3px 0 0 3px;
    }

    .alert-white .icon {
        text-align: center;
        width: 45px;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        border: 1px solid #bdbdbd;
        padding-top: 15px;
    }

    .alert-white .icon:after {
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
        display: block;
        content: '';
        width: 10px;
        height: 10px;
        border: 1px solid #bdbdbd;
        position: absolute;
        border-left: 0;
        border-bottom: 0;
        top: 50%;
        right: -6px;
        margin-top: -3px;
        background: #fff;
    }

    .alert-white .icon i {
        font-size: 20px;
        color: #fff;
        left: 12px;
        margin-top: -10px;
        position: absolute;
        top: 50%;
    }

    /*============ colors ========*/
    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }

    .alert-white.alert-success .icon,
    .alert-white.alert-success .icon:after {
        border-color: #54a754;
        background: #60c060;
    }

    .alert-info {
        background-color: #d9edf7;
        border-color: #98cce6;
        color: #3a87ad;
    }

    .alert-white.alert-info .icon,
    .alert-white.alert-info .icon:after {
        border-color: #3a8ace;
        background: #4d90fd;
    }


    .alert-white.alert-warning .icon,
    .alert-white.alert-warning .icon:after {
        border-color: #d68000;
        background: #fc9700;
    }

    .alert-warning {
        background-color: #fcf8e3;
        border-color: #f1daab;
        color: #c09853;
    }

    .alert-danger {
        background-color: #f2dede;
        border-color: #e0b1b8;
        color: #b94a48;
    }

    .alert-white.alert-danger .icon,
    .alert-white.alert-danger .icon:after {
        border-color: #ca452e;
        background: #da4932;
    }
</style>
<script>
    function deleteConfirm() {
        if (confirm("Are you sure to delete!")) {
            return true;
        } else {
            return false;
        }
    }
</script>
<?php
if (isset($_GET["function"]) == "del") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        mysqli_query($conn, "DELETE FROM noti WHERE NoID = '$id'");
    }
}
?>
<div class="container border my-2">
    <div class="ms-4 mt-3">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM noti ORDER BY createdDate DESC LIMIT 10");

        if (!$result) {
            die('Invalid query: ' . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        ?>
                <div class="alert alert-info alert-white my-2 row d-flex text-decoration-none">
                    <a href="?page=viewdetail&&id=<?php echo $row['ProID'] ?>" class="col-11 text-decoration-none">
                        <div class="icon">
                            <i class="fa fa-info-circle"></i>
                        </div>
                        <?php echo $row['Nocontent'] ?>
                    </a>
                    <?php
                    if ($_SESSION['admin'] == 1) {
                    ?>
                        <a href="?page=notification&&function=del&&id=<?php echo $row["NoID"] ?>" class="col-1 text-end" onclick="return deleteConfirm()">
                            <i class="bi bi-x-lg text-black"></i>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
        } else {

            ?>
            <div class="text-center fw-bold">
                <?php echo "No notification" ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>