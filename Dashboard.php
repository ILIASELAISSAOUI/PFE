<?php 
include "Actions/connectDB.php";
include "Includes/header.php" ;
include "Actions/Dashboard_Action.php";
?>
<section class="all-parts">
    <section class="first-part">
        <div class="box">
            <div class="box-info">
                <p class="title">BUDGET</p>
                <p><?php echo number_format((float)$bdjt, 2, '.', '');?> DHS</p>
            </div>
            <img src="Images/budget.png" width="55px" height="55px">
        </div>
        <div  class="box">
            <div class="box-info">
                <p class="title">TOTAL PROFIT</p>
                <p><?php echo number_format((float)$profit, 2, '.', ''); ?> DHS</p>
            </div>
            <img src="Images/total_profit.png" width="55px" height="55px">
        </div>
        <div  class="box">
            <div class="box-info">
                <p class="title">ACTIVE CUSTOMERS</p>
                <p><?php echo number_format((float)$prcn, 2, '.', '');?>%</p>
            </div>
            <img src="Images/tasks_progress.png" width="55px" height="55px">
        </div>
        <div  class="box">
            <div class="box-info">
                <p class="title">TOTAL CUSTOMERS</p>
                <p><?php echo $total1 ;?></p>
            </div>
            <img src="Images/total_customers.png" width="55px" height="55px">
        </div>
    </section>
    <section class="second-part">
        <div class="diagram">
            <div style="width:90%;margin-left:40px;margin-top:15px;">
                <canvas id="bar-chart-grouped" width="800" height="450"></canvas>
            </div>
            <script>
                new Chart(document.getElementById("bar-chart-grouped"), {
                    type: 'bar',
                    data: {
                    labels: ["january", "february", "march", "april", "Mai", "june", "july", "august", "september", "october"],
                    datasets: [
                        {
                        label: "budget",
                        backgroundColor: "#E5E5E5",
                        data: [<?php 
                                        for($i=1;$i<12;$i++){  
                                        $stmt=$conn->prepare("CALL INCOME(?)");    
                                        $date=date("2022-$i-1");
                                        $stmt->bindParam(1,$date); 
                                        $stmt->execute();
                                        $dat =$stmt->fetch(PDO::FETCH_ASSOC);
                                        echo $dat['sum(b.prix_box)'].",";
                                        }
                                        $stmt=$conn->prepare("CALL INCOME(?)");    
                                        $date=date("2022-12-1");
                                        $stmt->bindParam(1,$date); 
                                        $stmt->execute();
                                        $dat =$stmt->fetch(PDO::FETCH_ASSOC);
                                        echo $dat['sum(b.prix_box)'];

                                ?>]
                        }, {
                        label: "benefits",
                        backgroundColor: "#3e95cd",
                        data: [<?php 
                                        for($i=1;$i<12;$i++){  
                                        $stmt=$conn->prepare("CALL INCOME(?)");    
                                        $date=date("2022-$i-1");
                                        $stmt->bindParam(1,$date); 
                                        $stmt->execute();
                                        $dat =$stmt->fetch(PDO::FETCH_ASSOC);
                                        echo  $dat['sum(o.total_order)']-$dat['sum(b.prix_box)'].",";
                                        }
                                        $stmt=$conn->prepare("CALL INCOME(?)");    
                                        $date=date("2022-12-1");
                                        $stmt->bindParam(1,$date); 
                                        $stmt->execute();                                            
                                        $dat =$stmt->fetch(PDO::FETCH_ASSOC);
                                        echo $dat['sum(o.total_order)']-$dat['sum(b.prix_box)'];                                
                        ?>]
                        }
                    ]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Population growth (millions)'
                        }
                    }
                });
        </script>
        </div>
        <div class="circle">
            <h6>Last month sales by city</h6>
            <div style="width:90%;margin-left:20px;margin-top:30px;">
            <canvas id="doughnut-chart"></canvas>
            </div>
            <script>
                new Chart(document.getElementById("doughnut-chart"), { 
                type: 'doughnut',
                data: {
                    labels: ["Agadir", "Ouarzazate", "Marrakech","Casablanca"],
                    datasets: [
                    {
                        label: "Population (millions)",
                        backgroundColor: ["#a1f545", "#8d47a2","#c45850","#333EFF"],
                        data: [<?php echo $agadir;?>,<?php echo $ouarzazate;?>,<?php echo $marrakech; ?>,<?php echo $casablanca; ?>]
                    }
                    ]
                },
                options: {
                    title: {
                    display: true,
                    text: 'Predicted world population (millions) in 2050'
                    }
                }
                });
            </script>
        </div>
    </section>
    <section class="third-part">
        <div class="orders-table">
            <h6>Active clients</h6>
            <table>
                <tr>
                    <th class="name">Full name</th>
                    <th class="email">Email</th>
                    <th class="subs_date">Subsription end date</th>
                    <th class="phone">Phone N°</th>
                    <th class="birthday">Date of birth</th>
                    <th class="city">City</th>
                </tr> 
                <?php 
                foreach($table as $row){
                    echo "<tr>";
                    echo "<td>".$row["last_name"]." ".$row["first_name"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["subscription_end"]."</td>";
                    echo "<td>".$row["phone"]."</td>";
                    echo "<td>".$row["birthday"]."</td>";
                    echo "<td>".$row["city"]."</td>";
                    echo "</tr> ";
                }
                ?>   
            </table>
        </div>
    </section>
</section>


<?php include "Includes/footer.php" ?>