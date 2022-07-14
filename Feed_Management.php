<?php
if (isset($_SESSION['us']) == false) {
    echo "<script>alert('You need to login before accessing this page')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
        echo "<script>alert('You are administrator that cant not access this page')</script>";
        echo '<meta http-equiv="refresh" content = "0; URL=index.php"/>';
    } else {

?>
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
                mysqli_query($conn, "DELETE FROM feedback WHERE FeedID = '$id'");
            }
        }
        ?>

        <div class="container border my-2">
            <form name="frm" method="post" action="" class="mt-3 mx-md-2">
                <h1 class="text-center">Feedback Management</h1>
                <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th><strong>No.</strong></th>
                            <th><strong>Content</strong></th>
                            <th><strong>Send Date</strong></th>
                            <th><strong>Customer Name</strong></th>
                            <th><strong>Product ID</strong></th>
                            <th><strong>State</strong></th>
                            <th><strong>Delete</strong></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $No = 1;
                        $sq = "SELECT * FROM feedback f, customer c WHERE f.Username = c.Username ORDER BY sendDate DESC";
                        $res = mysqli_query($conn, $sq);
                        if (!$res) {
                            die('Invalid query: ' . mysqli_error($conn));
                        }
                        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $No ?></td>
                                <td><?php echo $row["Content"]; ?></td>
                                <td align="center"><?php echo $row["sendDate"]; ?></td>
                                <td><?php echo $row["CustName"]; ?></td>
                                <td align="center"><a class="text-decoration-none" href="?page=viewdetail&&id=<?php echo $row["ProID"]; ?>"><?php echo $row["ProID"]; ?></a></td>
                                <td align="center">
                                    <form action="" method="POST">
                                        <input type="hidden" id="txtIDFeed" name="txtIDFeed" value="<?php echo $row['FeedID']; ?>">
                                        <input type="hidden" id="txtupdateFeed" name="txtupdateFeed" value="<?php echo $row['state']; ?>">
                                        <?php
                                        if ($row['state'] == 1) {
                                        ?>
                                            <button type="submit" class="btn btn-success" name="btnUpdateFeedback">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        <?php
                                        } else {
                                        ?>
                                            <button type="submit" class="btn btn-danger" name="btnUpdateFeedback">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        <?php
                                        }
                                        ?>
                                    </form>
                                </td>
                                <td style='text-align:center'>
                                    <a href="?page=feedback_management&&function=del&&id=<?php echo $row["FeedID"] ?>" onclick="return deleteConfirm()">
                                        <i class="bi bi-trash-fill" style="color: red;"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $No++;
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
<?php
    }
}
if (isset($_POST['btnUpdateFeedback']) && $_POST['txtupdateFeed'] == 1) {
    $id = $_POST['txtIDFeed'];
    mysqli_query($conn, "UPDATE feedback SET state = 0 WHERE FeedID = '$id'") or die('Invalid query: ' . mysqli_error($conn));
    echo '<meta http-equiv="refresh" content = "0; URL=?page=feedback_management"/>';
}

if (isset($_POST['btnUpdateFeedback']) && $_POST['txtupdateFeed'] == 0) {
    $id = $_POST['txtIDFeed'];
    mysqli_query($conn, "UPDATE feedback SET state = 1 WHERE FeedID = '$id'") or die('Invalid query: ' . mysqli_error($conn));
    echo '<meta http-equiv="refresh" content = "0; URL=?page=feedback_management"/>';
}
?>