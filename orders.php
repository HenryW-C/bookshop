<div class="custom-column">
    <h3>Past Orders</h3>
    <?php
        // fetch all orders that the user has made
        $stmt = $conn->prepare("SELECT * FROM tblOrders WHERE userID = :userID");
        $stmt->bindParam(':userID', $_SESSION['UserID'], PDO::PARAM_INT);
        $stmt->execute();
        $orderData = $stmt->fetch(PDO::FETCH_ASSOC);
        // sets variable to determine if there are orders
        if ($orderData) {
            $orderFull = 1;
        }
        else {
            $orderFull = 0;
        }
        if ($orderFull == 1) {
            // if there are orders, they are displayed
            do {
                // row to fill the width of the page
                echo ('<a class="link" href="order.php?orderID=' .$orderData["orderID"]. '" class="card-title">'); // link to order page
                    echo('<div class="custom-row">');
                        echo ('<div class="title">');
                            echo('<h4>Order #'.$orderData["orderID"].'</h4>');
                        echo ('</div>');
                        echo ('<div class="price">');
                            $price = number_format($orderData['totalPrice'], 2, '.', ',');
                            echo('<h4>£'.$price.'</h4>');
                        echo ('</div>');
                    echo('</div>');
                echo ('</a>');
            } while ($orderData = $stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            // message to be shown if there are no orders
            echo('<br>There are no past orders');
        }
    ?>
</div>
<a type="button" href="list.php" class="btn btn-primary btn-list">List Book</a>