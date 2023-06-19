<?php include "paypal/box_Action.php"?>

<?php if($end > new DateTime()):?>
    <h1>Bravo</h1>
    <p>Well done <br> You are Premium <br> Your Subscription's Account ends on <?= $end->format('d/m/Y H:i:s'); ?></p>
    <?php if($dat['profile_id']): ?>
        <p> Votre abonnement est actif </p>
        <div>
            <a href ="?cancel=1" class="btn-danger"> Se desabonner</a>
        </div>
     <?php endif ;?>

<?php else: ?>
    <section class="box">
        <div class="contenaire">
            <div class="top">
                <div class="abbonnements">
                    <form action="" method="post">
                        <?php foreach(getOffers() as $k => $offer) : ?>
                            <div class="abbonnement">
                                    <input type="radio" name="offer" value="<?= $k ?>">
                                    <h5><?= $offer['name']?></h5>
                                    <p class="price"><?= $offer['price_text']?>Dhs<span>/month</span></p>
                                    <div class="info">
                                        <img src="Images/green_done.png" width="17px" height="17px">
                                        <p>5 to 6 organic natural products</p>
                                    </div>
                                    <div class="info">
                                        <img src="Images/green_done.png" width="17px" height="17px">
                                        <p>100% healthy and ethical</p>
                                    </div>
                                    <div class="info">
                                        <img src="Images/green_done.png" width="17px" height="17px"> 
                                        <p>A box worth 1200dhs</p>
                                    </div>
                                    <div class="info">
                                        <img src="Images/green_done.png" width="17px" height="17px">
                                        <p>Cancel anytime</p>
                                    </div>
                                    <div class="info">
                                        <img src="Images/green_done.png" width="17px" height="17px">
                                        <p>Free Shipping</p>
                                    </div>
                            </div>   
                        <?php endforeach ;?>
                        
                </div>
                <input  type="Submit" value="S'abonner" class="input_follow">
            </div>
                </form>
            <!--<div class="down">
                <h5>Orders History</h5>
                <table>
                    <tr>
                        <th class="date_col">Date</th>
                        <th class="city_col">City</th>
                        <th class="adress_col">Adress</th>
                        <th class="price_col">Price</th>
                    </tr>
                    <tr>
                        <td class="date_col">qqqq</td>
                        <td class="city_col">sss</td>
                        <td class="adress_col">sss</td>
                        <td class="price_col">sss</td>
                    </tr>
                    <tr>
                        <td class="date_col">qqqq</td>
                        <td class="city_col">sss</td>
                        <td class="adress_col">sss</td>
                        <td class="price_col">sss</td>
                    </tr>
                    <tr>
                        <td class="date_col">qqqq</td>
                        <td class="city_col">sss</td>
                        <td class="adress_col">sss</td>
                        <td class="price_col">sss</td>
                    </tr>
                    <tr>
                        <td class="date_col">qqqq</td>
                        <td class="city_col">sss</td>
                        <td class="adress_col">sss</td>
                        <td class="price_col">sss</td>
                    </tr>
                    
                </table>
                <a href="">Print</a>
            </div>-->
        </div>
    </section>
<?php endif; ?>

<?php include "Includes/footer.php"; ?>