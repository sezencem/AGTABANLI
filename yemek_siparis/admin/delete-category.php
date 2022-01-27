<?php 
    //Include Constants File
    include('../config/constants.php');

    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        $sql = "DELETE FROM tbl_category WHERE id=$id";

        $query = mysqli_query($conn, $sql);

        if($query)
        {
            $_SESSION['delete'] = "<div class='success'>Kategori silindi...</div>";
            header('location: manage-category.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Kategori silinemedi.</div>";
            header('location: manage-category.php');
        }
    }
    else
    {
        header('location: manage-category.php');
    }
?>