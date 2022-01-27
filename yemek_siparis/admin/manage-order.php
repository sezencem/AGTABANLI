<?php include('menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Siparişler</h1>
                <br /><br /><br />
                <?php 
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                ?>
                <br><br>

                <table class="tbl-full">
                    <tr>
                        <th>ID</th>
                        <th>Yemek</th>
                        <th>Fiyat</th>
                        <th>Adet</th>
                        <th>Total</th>
                        <th>Şipariş Tarihi</th>
                        <th>Durum</th>
                        <th>Müşteri Adı</th>
                        <th>Telefon</th>
                        <th>Email</th>
                        <th>Adres</th>
                    </tr>

                    <?php 
                        $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
                        $query = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($query);

                        if($count>0)
                        {
                            while($row=mysqli_fetch_assoc($query))
                            {
                                //Get all the order details
                                $id = $row['id'];
                                $food = $row['food'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $total = $row['total'];
                                $order_date = $row['order_date'];
                                $status = $row['status'];
                                $customer_name = $row['customer_name'];
                                $customer_contact = $row['customer_contact'];
                                $customer_email = $row['customer_email'];
                                $customer_address = $row['customer_address'];
                                
                                ?>

                                    <tr>
                                        <td><?php echo $id; ?>. </td>
                                        <td><?php echo $food; ?></td>
                                        <td><?php echo $price; ?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo $total; ?></td>
                                        <td><?php echo $order_date; ?></td>

                                        <td>
                                            <?php 
                                                if($status=="Ordered")
                                                {
                                                    echo "<label>Şipariş Alındı</label>";
                                                }
                                                elseif($status=="On Delivery")
                                                {
                                                    echo "<label style='color: orange;'>Teslim ediliyor</label>";
                                                }
                                                elseif($status=="Delivered")
                                                {
                                                    echo "<label style='color: green;'>Teslim edildi</label>";
                                                }
                                                elseif($status=="Cancelled")
                                                {
                                                    echo "<label style='color: red;'>İptal Edildi</label>";
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $customer_name; ?></td>
                                        <td><?php echo $customer_contact; ?></td>
                                        <td><?php echo $customer_email; ?></td>
                                        <td><?php echo $customer_address; ?></td>
                                    </tr>

                                <?php

                            }
                        }
                        else
                        {
                            echo "<tr><td colspan='12' class='error'>Hiç sipariş bulumadı</td></tr>";
                        }
                    ?>

 
                </table>
    </div>
    
</div>
