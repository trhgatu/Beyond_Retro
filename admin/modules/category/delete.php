<?php
if (!defined("_CODE")) {
    die("Access Denied !");
}
//Kiểm tra id trong db -> tồn tại -> tiến hành xóa
$filterAll = filter();
if (!empty($filterAll['id'])) {
    $categoryId = $filterAll['id'];
    $categoryDetail = getRaw("SELECT * FROM category WHERE id = $categoryId");
    if ($categoryDetail > 0) {
        //Thực hiện xóa
        $deleteCategory = delete('category', "id = $categoryId");
        if ($deleteCategory) {
            setFlashData('msg', 'Xóa danh mục thành công.');
            setFlashData('msg_type', 'success');
        }

    } else {
        setFlashData('msg', 'Danh mục không tồn tại trong hệ thống.');
        setFlashData('msg_type', 'danger');
    }

} else {
    setFlashData('msg', 'Liên kết không tồn tại.');
    setFlashData('msg_type', 'danger');
}
redirect('?module=category&action=list');