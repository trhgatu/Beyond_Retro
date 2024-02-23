<!-- Đăng ký tài khoản -->
<?php
if (!defined("_CODE")) {
    die("Access Denied !");
}
$data = [
    'pageTitle' => 'Thêm người dùng'
];
if (isPost()) {
    $filterAll = filter();
    $error = [];//Mảng chữa lỗi
    //Validate fullname: bắt buộc phải nhập, họ tên có ít nhất 5 ký tự
    if (empty($filterAll['fullname'])) {
        $error['fullname']['required'] = 'Họ tên bắt buộc phải nhập.';
    } else {
        if (strlen($filterAll['fullname']) < 5) {
            $error['fullname']['min'] = 'Họ tên phải có ít nhất 5 ký tự.';
        }
    }
    //Validate Email: bắt buộc phải nhập, đúng định dạng email không, email đã tồn tại trong csdl chưa
    if (empty($filterAll['email'])) {
        $error['email']['required'] = 'Email bắt buộc phải nhập.';
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT * FROM user WHERE email = '$email'";
        if (getRows($sql) > 0) {
            $error['email']['unique'] = 'Email đã tồn tại.';
        }
    }
    //Validate Số điện thoại: bắt buộc phải nhập, đúng định dạng không
    if (empty($filterAll['phone_number'])) {
        $error['phone_number']['required'] = 'SDT bắt buộc phải nhập.';
    } else {
        if (!isPhone($filterAll['phone_number'])) {
            $error['phone_number']['isPhone'] = 'SDT không hợp lệ.';
        }
    }
    //Validate password: bắt buộc phải nhập, >= 8 ký tự
    if (empty($filterAll['password'])) {
        $error['password']['required'] = 'Mật khẩu bắt buộc phải nhập.';
    } else {
        if (strlen($filterAll['password']) < 8) {
            $error['password']['min'] = 'Mật khẩu phải nhiều hơn 8 ký tự';
        }
    }
    //Validate password confirm: bắt buộc phải nhập, giống password
    if (empty($filterAll['password_confirm'])) {
        $error['password_confirm']['required'] = 'Bạn phải nhập lại mật khẩu.';
    } else {
        if (($filterAll['password']) != ($filterAll['password_confirm'])) {
            $error['password_confirm']['match'] = 'Mật khẩu nhập lại không đúng.';
        }
    }
    if (empty($error)) {
        $activeToken = sha1(uniqid() . time());
        $dataInsert = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone_number' => $filterAll['phone_number'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'status' => $filterAll['status'],
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $insertStatus = insert('user', $dataInsert);


        if ($insertStatus) {
                setFlashData('msg', 'Thêm người dùng mới thành công.');
                setFlashData('msg_type', 'success');
                redirect('?module=users&action=list');
            } else {
                setFlashData('msg', 'Thêm người dùng thất bại, vui lòng thử lại.    ');
                setFlashData('msg_type', 'danger');
            }
        redirect('?module=users&action=add');
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu');
        setFlashData('msg_type', 'danger');
        setFlashData('error', $error);
        setFlashData('old', $filterAll);
        redirect('?module=users&action=add');
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
                                <h1 class="h4 text-gray-900 mb-4">Thêm người dùng</h1>
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
                                            <input type="fullname" class="form-control form-control-user"
                                                id="exampleInputEmail" placeholder="Họ tên" name="fullname" value="<?php
                                                echo old('fullname', $old)
                                                    ?>">
                                            <?php
                                            echo form_error('fullname', '<span class= "error">', '</span>', $error);

                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" placeholder="Địa chỉ email" name="email" value="<?php
                                                echo old('email', $old)
                                                    ?>">
                                            <?php
                                            echo form_error('email', '<span class= "error">', '</span>', $error);

                                            ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Trạng thái</label>
                                            <select name="status" id="" class="form-control">
                                                <option value="0" <?php echo(old('status', $old) == 0) ? 'selected' : false; ?>>Chưa kích hoạt</option>
                                                <option value="1" <?php echo(old('status', $old) == 1) ? 'selected' : false; ?>>Đã kích hoạt</option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" class="form-control form-control-user"
                                                    id="exampleInputPassword" placeholder="Mật khẩu" name="password"
                                                    value="<?php
                                                    echo old('password', $old)
                                                        ?>">
                                                <?php
                                                echo form_error('password', '<span class= "error">', '</span>', $error);

                                                ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-user"
                                                    id="exampleRepeatPassword" placeholder="Nhập lại mật khẩu"
                                                    name="password_confirm" value="<?php
                                                    echo old('password_confirm', $old)
                                                        ?>">
                                                <?php
                                                echo form_error('password_confirm', '<span class= "error">', '</span>', $error);

                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Số điện thoại"
                                                name="phone_number" value="<?php
                                                echo old('phone_number', $old)
                                                    ?>">
                                            <?php
                                            echo form_error('phone_number', '<span class= "error">', '</span>', $error);

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
                                    <div class="col-sm-6"><a href="?module=users&action=list" class="mg-btn btn btn-success btn-block"
                                    >Quay lại</a></div>
                                </div>




                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="?module=authen&action=forgot">Quên mật khẩu?</a>
                            </div>
                            <div class=" text-center">
                                <a class="small" href="?module=authen&action=login">Đã có tài khoản? Hãy
                                    đăng nhập!</a>
                            </div>
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