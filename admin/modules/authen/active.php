<!-- Kích hoạt tài khoản -->
<?php
if (!defined("_CODE")) {
    die("Access Denied !");
}

$token = filter()['token'];


if (!empty($token)) {
    //Truy vấn kiểm tra token với db
    $tokenQuery = oneRaw("SELECT id FROM user WHERE activeToken = '$token'");
    var_dump($tokenQuery);
    if (!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        $dataUpdate = [
            'status' => 1,
            'activeToken' => null
        ];

        $updateStatus = update('user', $dataUpdate, "id = $userId");

        if ($updateStatus) {
            setFlashData('msg', 'Kích hoạt tài khoản thành công.');
            setFlashData('msg_type','success');
        }else{
            setFlashData('msg', 'Kích hoạt tài khoản không thành công.');
            setFlashData('msg_type','danger');
        }
        redirect('?module=authen&action=login');
    } else {
        getMSG('Liên kết không tồn tại hoặc đã hết hạn.', 'danger');
    }

} else {
    getMSG('Liên kết không tồn tại hoặc đã hết hạn.', 'danger');
}
?>

<?php
layouts('footer');

?>