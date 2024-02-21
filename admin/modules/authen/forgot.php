<!-- Quên mật khẩu -->
<?php
if (!defined("_CODE")) {
    die("Access Denied !");
}
$data = [
    'pageTitle' => 'Quên mật khẩu'
];
if (isLogin()) {
    redirect('?module=authen&action=login');
}
if (isPost()) {

}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>
<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <?php
                                    if (!empty($msg)) {
                                        getMSG($msg, $msg_type);
                                    }
                                    ?>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Nhập email" name="email">
                                        </div>


                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Gửi
                                        </button>
                                        <hr>

                                    </form>

                                    <div class="text-center">
                                        <a class="small" href="?module=authen&action=forgot">Đăng nhập</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="?module=authen&action=login">Chưa có tài khoản? Đăng
                                            ký!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>
<?php
layouts('style',$data);
?>