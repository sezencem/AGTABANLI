<?php include('menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Yemekleri Düzenle</h1>

        <br /><br />

                <!-- Button to Add Admin -->
                <a href="add-food.php" class="btn-primary">Yemek Ekle</a>

                <br /><br /><br />

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }

                    if(isset($_SESSION['unauthorize']))
                    {
                        echo $_SESSION['unauthorize'];
                        unset($_SESSION['unauthorize']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                
                ?>

                <table class="tbl-full">
                    <tr>
                        <th>ID</th>
                        <th>İsim</th>
                        <th>Fiyat</th>
                        <th>Görsel</th>
                        <th>Eylem</th>
                    </tr>

                    <?php 
                        $sql = "SELECT * FROM tbl_food";

                        $query = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($query);
                        $sn=1;

                        if($count>0)
                        {
                            while($row=mysqli_fetch_assoc($query))
                            {
                                $id = $row['id'];
                                $title = $row['title'];
                                $price = $row['price'];
                                $image_name = $row['image_name'];
                                ?>

                                <tr>
                                    <td><?php echo $id; ?>. </td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $price; ?>tl</td>
                                    <td>
                                        <?php  
                                            if($image_name=="")
                                            {
                                                echo "<div class='error'>Resim bulunamdı.</div>";
                                            }
                                            else
                                            {
                                                ?>
                                                <img src="../<?php echo $image_name; ?>" width="100px">
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Güncelle</a>
                                        <a href="delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Sil</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        else
                        {
                            //Food not Added in Database
                            echo "<tr> <td colspan='7' class='error'> Herhangi bir yemek yok. </td> </tr>";
                        }

                    ?>                    
                </table>
    </div>
    
</div>

