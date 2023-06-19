<?php 
    include "Includes/header.php";
    include "Actions/support_Action.php";
?>

    <section class="support">
        <div class="left-side">
            <img src="Images/Questions _ Contact Us _).png">
            <form action="support.php" method="post">
                <input type="text" name="username" placeholder="Name" class="inputName"></input>
                <input type="email" name="email" placeholder="Email" class="inputEmail"></input>
                <input type="text" name="subject" placeholder="Subject" class="inputSubject"></input>
                <textarea name="message" placeholder="Message" class="inputMessage" rows="5" cols="64"></textarea>
                <div class="send">
                    <input type="submit" name="send" value="Send" class="inputSubmit">
                </div>
            </form>
        </div>
        <div class="right-side">
            <img src="Images/contact us.png" width="300px" height="400px">
        </div>
    </section>


<?php include "Includes/footer.php";?>