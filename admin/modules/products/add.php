<!-- Đăng ký tài khoản -->
<?php
if (!defined("_CODE")) {
    die("Access Denied !");
}
$data = [
    'pageTitle' => 'Thêm sản phẩm mới'
];
if (isPost()) {
    $filterAll = filter();
    $error = [];//Mảng chữa lỗi
    //Validate title: bắt buộc phải nhập
    if (empty($filterAll['title'])) {
        $error['title']['required'] = 'Tên sản phẩm không được để trống.';
    } else {
        if (strlen($filterAll['title']) < 10) {
            $error['title']['min'] = 'Tên sản phẩm phải có ít nhất 5 ký tự.';
        }
    }
    //Validate giá: bắt buộc phải nhập, đúng định dạng số nguyên
    if (empty($filterAll['price'])) {
        $error['price']['required'] = 'Giá không được để trống.';
    }else {
        if (!isNumberInt($filterAll['price'])) {
            $error['price']['isNumberInt'] = 'Giá phải có giá trị là số nguyên.';
        }

    }
    //Validate mô tả: bắt buộc phải nhập, > 50 ký tự
    if (empty($filterAll['description'])) {
        $error['description']['required'] = 'Mô tả không được để trống.';
    }else {
        if (strlen($filterAll['description']) < 50) {
            $error['description']['min'] = 'Mô tả phải có ít nhất 50 ký tự.';
        }

    }
    if (empty($error)) {
        $dataInsert = [
            'title' => $filterAll['title'],
            'price' => $filterAll['price'],
            'discount' => $filterAll['discount'],
            'thumbnail' => $filterAll['thumbnail'],
            'description' => $filterAll['description'],
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $insertStatus = insert('product', $dataInsert);


        if ($insertStatus) {
                setFlashData('msg', 'Thêm sản phẩm mới thành công.');
                setFlashData('msg_type', 'success');
                redirect('?module=products&action=list');
            } else {
                setFlashData('msg', 'Thêm sản phẩm thất bại, vui lòng thử lại.');
                setFlashData('msg_type', 'danger');
            }
        redirect('?module=products&action=add');
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu');
        setFlashData('msg_type', 'danger');
        setFlashData('error', $error);
        setFlashData('old', $filterAll);
        redirect('?module=products&action=add');
    }

}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('error');
$old = getFlashData('old');
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
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->


                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Thêm sản phẩm mới</h1>
                            </div>
                            <?php
                            if (!empty($msg)) {
                                getMSG($msg, $msg_type);
                            }
                            ?>
                            <form class="user" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <p>Tiêu đề sản phẩm:</p>
                                            <input type="title" class="form-control form-control-user"
                                                name="title" value="<?php
                                                echo old('title', $old)
                                                    ?>">
                                            <?php
                                            echo form_error('title', '<span class= "error">', '</span>', $error);

                                            ?>
                                        </div>
                                        <div class="form-group">
                                        <p>Giá sản phẩm:</p>
                                            <input type="text" class="form-control form-control-user"
                                                 name="price" value="<?php
                                                echo old('price', $old)
                                                    ?>">
                                            <?php
                                            echo form_error('price', '<span class= "error">', '</span>', $error);

                                            ?>
                                        </div>
                                        <div class="form-group">
                                        <p>Giảm giá:</p>
                                            <input type="text" class="form-control form-control-user"
                                                 name="discount" value="<?php
                                                echo old('discount', $old)
                                                    ?>">

                                        </div>
                                        <div class="form-group">
                                            <p>Ảnh bìa:</p>
                                            <input type="" class="form-control form-control-user"
                                                 name="thumbnail" value="<?php
                                                echo old('thumbnail', $old)
                                                    ?>">

                                        </div>
                                        <div class="form-group">
                                            <p>Mô tả:</p>
                                            <input type="text" class="form-control form-control-user"
                                                 name="description" value="<?php
                                                echo old('description', $old)
                                                    ?>">
                                            <?php
                                            echo form_error('description', '<span class= "error">', '</span>', $error);

                                            ?>
                                        </div>


                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                    <button type="submit" class="mg-btn btn btn-primary btn-block">
                                    Thêm
                                </button>
                                    </div>
                                    <div class="col-sm-6"><a href="?module=products&action=list" class="mg-btn btn btn-success btn-block"
                                    >Quay lại</a></div>
                                </div>




                            </form>
                            <hr>

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