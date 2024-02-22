<?php
if (!defined("_CODE")) {
    die("Access Denied !");
}
$data = [
    'pageTitle' => 'Danh sách User'
];
//Kiểm tra trạng thái đăng nhập
if (!isLogin()) {
    redirect('?module=authen&action=login');
}

?>
<div id="wrapper">
    <?php
    layouts('style',$data);
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
                            Danh sách khách hàng
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Trạng thái</th>
                                    <th width="5%">Sửa</th>
                                    <th width="5%">Xóa</th>

                                </thead>
                                <tbody>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td><a href="" class="btn btn-warning btn-sm"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                    <td><a href="" onclick="return confirm('Bạn có muốn xóa?')"
                                            class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
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