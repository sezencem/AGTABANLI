<?php 
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name'])) 
    {

        $id = $_GET['id'];
        $image_name = $_GET['image_name'];


        if($image_name != "")
        {

            $path = "../images".$image_name;

            $remove = unlink($path);
            if($remove==false)
            {
                //Failed to Remove image
                $_SESSION['upload'] = "<div class='error'>Resim Kaldırılamadı.</div>";
                header('location: manage-food.php');
                die();
            }

        }

        $sql = "DELETE FROM tbl_food WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            //Food Deleted
            $_SESSION['delete'] = "<div class='success'>Yemek Silindi.</div>";
            header('location: manage-food.php');
        }
        else
        {
            //Failed to Delete Food
            $_SESSION['delete'] = "<div class='error'>Yemek Silinemedi.</div>";
            header('location: manage-food.php');
        }
    }
?>