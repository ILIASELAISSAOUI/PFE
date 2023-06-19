

<?php 
    include "Includes/header.php";
    session_start();
?>

<section class="first-section">
    <div class="header">
        <div class="header-left">
            <img src="Images/logo.png" width="250px" height="50px" class="logo">
            <a href="#second-section" class="first-child"><strong>Discover</strong></a>
            <a href="#third-section" class="first-child"><strong>How It Works</strong></a>
            <a href="#fourth-section" class="first-child"><strong>Our Boxes</strong></a>
        </div>
        <div class="header-right">
            <div class="login_button" <?php if(isset($_SESSION['email']) && $_SESSION['verified']==1){echo 'style="display:none;"';} ?>>
                <img src="Images/signIn.svg" width="35px" height="35px">
                <a href="signIn.php"><strong>LOG IN</strong></a>
            </div>
            <a href="signUp.php" class="joinUs" <?php if(isset($_SESSION['email']) && $_SESSION['verified']==1){echo 'style="display:none;"';} ?>><strong>Join Us Now</strong></a>
            <div class="myAccount" <?php if(!isset($_SESSION['email']) || $_SESSION['verified']!=1){echo 'style="display:none;"';} ?>>
                <img src="Images/signIn.svg" width="35px" height="35px">
                <a href="nav.php?x=Account"><strong>MY ACCOUNT</strong></a>
            </div>
        </div>
    </div>
    <div class="left-side">
            <img src="Images/title.svg">
            <div class="infos">
                <div class="info">
                    <img src="Images/done.png" >
                    <p>5 to 6 organic natural products</p>
                </div>
                <div class="info">
                    <img src="Images/done.png" >
                    <p>100% healthy and ethical</p>
                </div>
                <div class="info">
                    <img src="Images/done.png" > 
                    <p>A box worth 800dhs</p>
                </div>
                <div class="info">
                    <img src="Images/done.png" >
                    <p>Cancel anytime</p>
                </div>
                <div class="info">
                    <img src="Images/done.png" >
                    <p>Free Shipping</p>
                </div>
            </div>
            
            <a href="signUp.php">Join Us Now</a>
    </div>
    <div class="right-side">
        <img src="Images/EMILIE_COVERCC 1.svg">
    </div>
</section>
<section class="second-section" id="second-section">
    <h2>What is <strong>My Moroccan Box</strong></h2>
    <div class="left-side">
        <div class="infos">
            <img src="Images/cadeau.svg">
            <h5>One surprise box per month</h5>
            <p style="text-align:left;">Every month, receive a varied and cutting-edge selection of cosmetics & treatments.</p>
        </div>
        <div class="infos">
            <img src="Images/Bio.svg">
            <h5>Organic and ethical discoveries</h5>
            <p style="text-align:left;">Healthy, natural, organic and ethical. You avoid hundreds of substances chemicals.</p>
        </div>
        <div class="infos">
            <img src="Images/verre.svg">
            <h5>High Quality Products</h5>
            <p style="text-align:left;">The latest trends, new brands, without any samples!</p>
        </div>
        <div class="infos">
            <img src="Images/ciseau.svg">
            <h5>Up to 70% savings</h5>
            <p style="text-align:left;">Without an intermediary, you benefit from an unbeatable price compared to the shop price.</p>
        </div>       
    </div>
    <div class="right-side">
            <img src="Images/box1.jpg">
    </div>
    <a href="">Discover</a>
</section>
<section class="third-section" id="third-section">
    <img src="Images/parallèlogramme.png" class="speciale">
    <div class="contenaire">
        <div class="row1">
            <div class="infos">
                <img src="Images/icn_no5.png" >
                <h6>ORGANIC</h6>
            </div>
            <div class="infos">
                <img src="Images/icn_no6.png">
                <h6>NATURAL</h6>
            </div>
            <div class="infos">
                <img src="Images/icn_no4.png">
                <h6>CRUELTY FREE</h6>
            </div>
        </div>
        <div class="row2">
            <div class="infos">
                <img src="Images/icn_no1.png">
                <h6>WITHOUT PARABEN</h6>
            </div>
            <div class="infos">
                <img src="Images/icn_no2.png">
                <h6>WITHOUT SILICONE</h6>
            </div>
            <div class="infos">
                <img src="Images/icn_no3.png">
                <h6>WITHOUT PETROCHIMICAL</h6>
            </div>
        </div>      
    </div>
</section>
<section class="fourth-section" id="fourth-section">
    <h2>Here’s<strong> How It Works</strong></h2>
    <p class="p-fourth">New Boxes Released Monthly</p>
    <div class="contenaire">
        <div class="info">
            <img src="Images/section4_1.png">
            <h4>Choose Your Plan</h4>
            <p>In every box, you will receive 5 full-size beauty itemsevery box has a thecrate average value 800DH.</p>
        </div>
        <div class="info">
            <img src="Images/section4_2.png">
            <h4>Get Your Moroccan Box</h4>
            <p>Your monthly beauty treats will mix of prestige and niche brands. Discover what works for you</p>
        </div>
        <div class="info">
            <img src="Images/section4_3.png">
            <h4>Join Our Community</h4>
            <p>Become an official Customer, with over 300,000 members & Receive reward points.</p>
        </div>
    </div>
</section>

<section class="fifth-section">
    <h2>Here’s <strong>Our Previous Boxes</strong></h2>
    <div class="contenaire">
        <img src="Images/section5_1.jpeg">
        <img src="Images/section5_2.jpg" >
        <img src="Images/section5_3.jpg">
    </div>
</section>

<section class="separateur">
        <p></p>
</section>

<section class="sixth-section">
    <div class="left-side">
        <img src="Images/Questions _ Contact Us _).png">
        <form action="">
            <input type="text" placeholder="Name" class="inputName"></input>
            <input type="email" placeholder="Email" class="inputEmail"></input>
            <input type="text" placeholder="Subject" class="inputSubject"></input>
            <textarea placeholder="Message" class="inputMessage" rows="10" cols="64"></textarea>
            <div class="send">
                <img src="Images/enveloppe.png">
                <input type="submit" value="Send" class="inputSubmit">
            </div>
        </form>
    </div>
    <div class="right-side">
        <img src="Images/contact us.png">
    </div>
</section>

<section class="last-section">
    <div class="parags">
        <div class="parag first">
            <img src="Images/logo.png">
            <p>We are a natural box with subscription We use Organic Products your beauty</p>
            <p>Agadir Salam 80 0000</p>
        </div>
        <div class="parag">
            <h6>Help</h6>
            <a href="">Contact Us</a>
            <a href="">Return Policies</a>
            <a href="">Cancellation</a>
            <a href="">Shipping</a>
        </div>
        <div class="parag">
            <h6>Quick Links</h6>
            <a href="">Login</a>
            <a href="">Our Boxes</a>
            <a href="">Discover</a>
            <a href="">How It Works</a>
        </div>
        <div class="parag">
            <h6>Follow Us</h6>
        </div>
    </div>
</section>

<?php

$data = [
    ["month" => 2, "subs" => 1000],
    ["month" => 3, "subs" => 2000],
    ["month" => 4, "subs" => 500],
    ["month" => 5, "subs" => 1000],
]

?>

<script>
    const data = <?php echo str_replace('"', '', json_encode($data)); ?>;
    console.log(data[0].subs);
</script>

<?php include "Includes/footer.php"?>
