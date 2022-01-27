<?php include('menu.php'); ?>

<?php 
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];

        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        $query2 = mysqli_query($conn, $sql2);

        $row2 = mysqli_fetch_assoc($query2);

        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
    }
    else
    {
        header('location: manage-food.php');
    }
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Yemeği Güncelle</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
        
        <table class="tbl-30">

            <tr>
                <td>İsim: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Tanım: </td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Fiyat: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Resim: </td>
                <td>
                    <?php 
                        if($current_image == "")
                        {
                            //Image not Available 
                            echo "<div class='error'>Görsel Bulunamadı.</div>";
                        }
                        else
                        {
                            ?>
                            <img src="../<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Yeni resim seç: </td>
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
                                while($row=mysqli_fetch_assoc($query))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    $category_title = $row["title"];
                                    echo "<option value='0'>$category_title </option>";
                                }
                            }
                            else
                            {
                                echo "<option value='0'>Kategori Bulunamadı.</option>";
                            }

                        ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                    <input type="submit" name="submit" value="Güncelle" class="btn-secondary">
                </td>
            </tr>
        
        </table>
        
        </form>

        <?php 
        
            if(isset($_POST['submit']))
            {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                if(isset($_FILES['image']['name']))
                {
                    //Upload BUtton Clicked
                    $image_name = $_FILES['image']['name']; //New Image NAme

                    //CHeck whether th file is available or not
                    if($image_name!="")
                    {
                        $ext = end(explode('.', $image_name)); //Gets the extension of the image

                        $image_name = $ext; //THis will be renamed image

                        //Get the Source Path and DEstination PAth
                        $src_path = $_FILES['image']['tmp_name']; //Source Path
                        $dest_path = "../images/food/".$image_name; //DEstination Path

                        //Upload the image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        /// CHeck whether the image is uploaded or not
                        if($upload==false)
                        {
                            //FAiled to Upload
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload new Image.</div>";
                            //REdirect to Manage Food 
                            header('location: manage-food.php');
                            //Stop the Process
                            die();
                        }
                        //3. Remove the image if new image is uploaded and current image exists
                        //B. Remove current Image if Available
                        if($current_image!="")
                        {
                            //Current Image is Available
                            //REmove the image
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //Check whether the image is removed or not
                            if($remove==false)
                            {
                                //failed to remove current image
                                $_SESSION['remove-failed'] = "<div class='error'>Faile to remove current image.</div>";
                                //redirect to manage food
                                header('location: manage-food.php');
                                //stop the process
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image; 
                }

                $sql3 = "UPDATE tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    WHERE id=$id
                ";

                $res3 = mysqli_query($conn, $sql3);
                if($res3==true)
                {
                    $_SESSION['update'] = "<div class='success'>Yemek Güncellendi.</div>";
                    header('location: manage-food.php');
                }
                else
                {

                    $_SESSION['update'] = "<div class='error'>Yemek Güncellenemedi.</div>";
                    header('location: manage-food.php');
                }  
            }
        
        ?>

    </div>
</div>
