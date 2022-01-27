<?php include('menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Kategoriyi Düzenle</h1>
        <br><br>
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            $query = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($query);

            if ($count == 1) {
                $row = mysqli_fetch_assoc($query);
                $title = $row['title'];
                $current_image = $row['image_name'];
            } else {
                $_SESSION['no-category-found'] = "<div class='error'>Kategori Bulunamadı.</div>";
                header('location: manage-category.php');
            }
        } else {
            header('location: manage-category.php');
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Başlık: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Resim: </td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            //Display the Image
                        ?>
                            <img src="../<?php echo $current_image; ?>" width="150px">
                        <?php
                        } else {
                            echo "<div class='error'>Resim eklenmedi.</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Yeni Resim: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Güncelle" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php

        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];

            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];
                if ($image_name != "") {
                    //Rename the Image
                    $image_name = "";

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/" . $image_name;

                    $upload = move_uploaded_file($source_path, $destination_path);

                    if ($upload == false) {
                        //SEt message
                        $_SESSION['upload'] = "<div class='error'>Resim yüklenemedi. </div>";
                        header('location: manage-category.php');
                        die();
                    }

                    //B. Remove the Current Image if available
                    if ($current_image != "") {
                        $remove_path = "../images/category/" . $current_image;

                        $remove = unlink($remove_path);

                        if ($remove == false) {
                            //Failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Resim kaldırılamadı.</div>";
                            header('location: manage-category.php');
                        }
                    }
                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }

            $sql2 = "UPDATE tbl_category SET 
                    title = '$title',
                    image_name = '$image_name',
                    WHERE id=$id
                ";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                //Category Updated
                $_SESSION['update'] = "<div class='success'>Kategori Güncellendi.</div>";
                header('location: manage-category.php');
            } else {
                //failed to update category
                $_SESSION['update'] = "<div class='error'>Kategori Güncellenemedi.</div>";
                header('location: manage-category.php');
            }
        }
        ?>

    </div>
</div>