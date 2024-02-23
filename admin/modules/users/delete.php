<?php
if (!defined("_CODE")) {
    die("Access Denied !");
}
//Kiểm tra id trong db -> tồn tại -> tiến hành xóa
//Xóa dữ liệu bảng tokenlogin -> xóa dữ liệu bảng user
$filterAll = filter();
if (!empty($filterAll['id'])) {
    $userId = $filterAll['id'];
    $userDetail = getRaw("SELECT * FROM user WHERE id = $userId");
    if ($userDetail > 0) {
        //Thực hiện xóa
        $deleteToken = delete('tokenlogin', "user_id = $userId");
        if ($deleteToken) {
            //Xóa user
            $deleteUser = delete('user', "id = $userId");
            if($deleteUser){
                setFlashData('msg', 'Xóa người dùng thành công.');
                setFlashData('msg_type', 'success');
            }
        }
    } else {
        setFlashData('msg', 'Người dùng không tồn tại trong hệ thống.');
        setFlashData('msg_type', 'danger');
    }

} else {
    setFlashData('msg', 'Liên kết không tồn tại.');
    setFlashData('msg_type', 'danger');
}
redirect('?module=users&action=list');