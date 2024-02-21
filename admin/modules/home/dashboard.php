<?php
if (!defined("_CODE")) {
    die("Access Denied !");
}
?>
<div id="wrapper">

    <!-- Sidebar -->
    <?php
    require_once(_WEB_PATH_TEMPLATE . '/layout/sidebar.php');
    ?>

    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <?php
        require_once(_WEB_PATH_TEMPLATE . '/layout/header.php');

        require_once(_WEB_PATH_TEMPLATE . '/layout/footer.php');
        ?>
    </div>
    <!-- End of Content Wrapper -->
</div>