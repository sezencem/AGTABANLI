<?php include('menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Katergorileri Düzenle</h1>

        <br /><br />
        <?php

        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['no-category-found'])) {
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }

        ?>
        <br><br>
        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Başlık</th>
                <th>Görsel</th>
                <th>Eylem</th>
            </tr>

            <?php

            $sql = "SELECT * FROM tbl_category";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
            ?>
                    <tr>
                        <td><?php echo $id; ?>. </td>
                        <td><?php echo $title; ?></td>

                        <td>

                            <?php
                            if ($image_name != "") {
                            ?>

                                <img src="../<?php echo $image_name; ?>" width="100px">

                            <?php
                            }
                            ?>

                        </td>
                        <td>
                            <a href="update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Düzenle</a>
                            <a href="delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Sil</a>
                        </td>
                    </tr>

                <?php

                }
            } else {

                ?>

                <tr>
                    <td colspan="6">
                        <div class="error">Hiç Kategori Yok.</div>
                    </td>
                </tr>

            <?php
            }

            ?>
        </table>
    </div>

</div>