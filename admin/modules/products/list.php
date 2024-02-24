<?php
if (!defined("_CODE")) {
    die("Access Denied !");
}
$data = [
    'pageTitle' => 'Danh sách sản phẩm'
];
//Kiểm tra trạng thái đăng nhập
if (!isLogin()) {
    redirect('?module=authen&action=login');
}
//Truy vấn vào bảng user
$listProducts = getRaw("SELECT * FROM product ORDER BY updated_at");
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
//$error = getFlashData('error');
//$old = getFlashData('old');
?>
<div id="wrapper">
    <?php
    layouts('style', $data);
    layouts('sidebar', $data);
    ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php
            layouts('header', $data);
            ?>
            <div class="container-fluid">
                <div class="card shadow mb-4" style="max-width: 1240px">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Danh sách sản phẩm
                            <a href="?module=products&action=add" class="btn btn-success btn-sm"
                                style="float:right">Thêm sản phẩm mới<i class="fa-solid fa-plus"></i></a>
                        </h6>

                    </div>
                    <?php
                    if (!empty($msg)) {
                        getMSG($msg, $msg_type);
                    }
                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Giảm giá</th>
                                    <th>Ảnh bìa </th>
                                    <th>Mô tả sản phẩm </th>
                                    <th width="5%">Sửa</th>
                                    <th width="5%">Xóa</th>

                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($listProducts)):
                                        $count = 0; //STT
                                        foreach ($listProducts as $item):
                                            $count++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $count; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item['title'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $item['price'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $item['discount'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $item['thumbnail'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $item['description'] ?>
                                                </td>
                                                <td><a href="<?php echo _WEB_HOST; ?>?module=products&action=edit&id=<?php echo $item['id'] ?>"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                </td>
                                                <td><a href="<?php echo _WEB_HOST; ?>?module=products&action=delete&id=<?php echo $item['id'] ?>"
                                                        onclick="return confirm('Bạn có muốn xóa?')"
                                                        class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan="7">
                                                <div class="alert alert-danger text-center">Không có sản phẩm nào</div>
                                        </tr>
                                        <?php
                                    endif;

                                    ?>


                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        layouts('footer', $data);
        ?>
    </div>

</div>