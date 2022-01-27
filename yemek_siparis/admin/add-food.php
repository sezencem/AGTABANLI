<?php include('menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Yemek Ekle</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        
            <table class="tbl-30">

                <tr>
                    <td>İsim: </td>
                    <td>
                        <input type="text" name="title" placeholder="Yemeğin İsmi">
                    </td>
                </tr>

                <tr>
                    <td>Tanım: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Yemek hakkında detay."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Fiyat: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Resim Seç: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Kategori: </td>
                    <td>
                        <select name="category">

                            <?php 
                                $sql = "SELECT * FROM tbl_category";
                            
                                $query = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($query);

                                if($count>0)
                                {
                                    //WE have categories
                                    while($row=mysqli_fetch_assoc($query))
                                    {
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <option value="0">Kategori Bulunamadı</option>
                                    <?php
                                }
                        
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Yemeği Ekle" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        
        <?php 

            if(isset($_POST['submit']))
            {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];


                if(isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];
                    if($image_name!="")
                    {
                        $ext = end(explode('.', $image_name));

                        // Create New Name for Image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;
                        $src = $_FILES['image']['tmp_name'];

                        $dst = "../".$image_name;

                        $upload = move_uploaded_file($src, $dst);
                        if($upload==false)
                        {

                            $_SESSION['upload'] = "<div class='error'>Resim Yüklenemedi.</div>";
                            header('location: add-food.php');
                        }

                    }

                }
                else
                {
                    $image_name = ""; 
                }

                $sql2 = "INSERT INTO tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category
                ";

                $query2 = mysqli_query($conn, $sql2);

                if($query)
                {
                    $_SESSION['add'] = "<div class='success'>Yemek Eklendi.</div>";
                    header('location: manage-food.php');
                }
                else
                {
                    //FAiled to Insert Data
                    $_SESSION['add'] = "<div class='error'>Yemek Eklenemedi.</div>";
                    header('location: manage-food.php');
                }

                
            }

        ?>
    </div>
</div>

