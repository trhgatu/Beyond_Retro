<?php
if (!defined("_CODE")) {
    die("Access Denied !");
}
//Kiểm tra id trong db -> tồn tại -> tiến hành xóa
$filterAll = filter();
if (!empty($filterAll['id'])) {
    $productId = $filterAll['id'];
    $productDetail = getRaw("SELECT * FROM product WHERE id = $productId");
    if ($productDetail > 0) {
        //Thực hiện xóa
        $deleteGalery = delete('galery',"product_id = $productId");
        if($deleteGalery)
        {
            $deleteProduct = delete('product', "id = $productId");
            if ($deleteProduct) {
                setFlashData('msg', 'Xóa sản phẩm thành công.');
                setFlashData('msg_type', 'success');
            }
        }
    } else {
        setFlashData('msg', 'Sản phẩm không tồn tại trong hệ thống.');
        setFlashData('msg_type', 'danger');
    }

} else {
    setFlashData('msg', 'Liên kết không tồn tại.');
    setFlashData('msg_type', 'danger');
}
redirect('?module=products&action=list');