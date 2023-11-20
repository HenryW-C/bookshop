<div class="custom-column">
    <h3>Messages</h3>
    <?php
        // fetch all messages sent to the user
        $stmt = $conn->prepare("SELECT * FROM tblMessages WHERE recieveUserID = :userID");
        $stmt->bindParam(':userID', $_SESSION['UserID'], PDO::PARAM_INT);
        $stmt->execute();
        $messageData = $stmt->fetch(PDO::FETCH_ASSOC);
        // sets variable to determine if there are messages
        if ($messageData) {
            $messageFull = 1;
        }
        else {
            $messageFull = 0;
        }
        if ($messageFull == 1) {
            // if there are messages, they are displayed
            do {
                // row to fill the width of the page
                echo('<div class="custom-row messageBtn" style="cursor: pointer;">');
                    echo ('<div class="sender">');
                        echo('<h4>User #'.$messageData["messageID"].'</h4>');
                    echo ('</div>');
                    echo ('<div class="date">');    
                        echo('<h4>'.$messageData["sendDate"].'</h4>');
                    echo ('</div>');
                echo('</div>');
    ?>
                <!-- message modal -->
                <div class="modal message-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">&times;</span>
                            <h2>Message</h2>
                        </div>
                        <div class="modal-body">
                            <?php
                                echo('<p>'.$messageData["content"].'</p>');
                            ?>
                        </div>
                        <div class="modal-footer">
                            <?php
                                echo('<h5> Sent: '.$messageData["sendDate"].'</h5>');
                            ?>
                        </div>
                    </div>
                </div>
    <?php
            } while ($messageData = $stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            // message to be shown if there are no messages
            echo('<br>There are no messages');
        }
    ?> 
</div>

<a type="button" class="btn btn-primary btn-list messageBtn">Send Message</a>

<!-- send modal -->
<form action="sendmessage.php" method="post">
    <div class="modal message-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>New Message</h2>
            </div>
            <div class="modal-body">
                <textarea type="text" name="description" placeholder="Type message here..." style="border: none; height: 100%; width: 100%; text-align: left" required></textarea>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</form>

<!-- modal script -->
<script>
    // define variables
    var modals = document.querySelectorAll('.message-modal');
    var btns = document.querySelectorAll('.messageBtn');
    var spans = document.querySelectorAll('.close');

    // iterate over modals and attach event listeners
    btns.forEach(function(btn, index) {
        btn.onclick = function() {
            modals[index].style.display = "block";
        }
    });
    spans.forEach(function(span, index) {
        span.onclick = function() {
            modals[index].style.display = "none";
        }
    });
    window.onclick = function(event) {
        modals.forEach(function(modal) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    }
</script>