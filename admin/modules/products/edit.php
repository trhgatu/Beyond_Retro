<!-- Sửa tài khoản -->
<?php
if (!defined("_CODE")) {
    die ("Access Denied !");
}
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "fashionweb";

$filterAll = filter();
if (!empty ($filterAll['id'])) {
    $productId = $filterAll['id'];
    $productDetail = oneRaw("SELECT * FROM product WHERE id='$productId'");
    if (!empty ($productDetail)) {
        //Tồn tại
        setFlashData('product-detail', $productDetail);
    } else {
        redirect('?module=products&action=list');
    }
}
$data = [
    'pageTitle' => 'Sửa sản phẩm'
];
if (isPost()) {
    $filterAll = filter();
    $error = [];
    //Validate title: bắt buộc phải nhập
    if (empty ($filterAll['title'])) {
        $error['title']['required'] = 'Tên sản phẩm không được để trống.';
    } else {
        if (strlen($filterAll['title']) < 5) {
            $error['title']['min'] = 'Tên sản phẩm phải có ít nhất 10 ký tự.';
        }
    }
    //Validate giá: bắt buộc phải nhập, đúng định dạng số nguyên
    if (empty ($filterAll['price'])) {
        $error['price']['required'] = 'Giá không được để trống.';
    } else {
        if (!isNumberInt($filterAll['price'])) {
            $error['price']['isNumberInt'] = 'Giá phải có giá trị là số nguyên.';
        }
    }
    //Validate mô tả: bắt buộc phải nhập, > 50 ký tự
    if (empty ($filterAll['description'])) {
        $error['description']['required'] = 'Mô tả không được để trống.';
    } else {
        if (strlen($filterAll['description']) < 20) {
            $error['description']['min'] = 'Mô tả phải có ít nhất 20 ký tự.';
        }
    }
    if (empty ($error)) {
        $dataUpdate = [
            'title' => $filterAll['title'],
            'category_id' => $filterAll['category_id'],
            'price' => $filterAll['price'],
            'thumbnail' => $filterAll['thumbnail'],
            'description' => $filterAll['description'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $condition = "id = $productId";
        $UpdateStatus = update('product', $dataUpdate, $condition);
        $conditionImg = "product_id = $productId";
        $dataImagesUpdate = [
            'product_id' => $productId,
            'images_path' => implode(",", $filterAll['images_path']),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $UpdateImagesStatus = update('galery', $dataImagesUpdate, $conditionImg);
        if ($UpdateStatus && $UpdateImagesStatus) {


            setFlashData('msg', 'Cập nhật sản phẩm thành công.');
            setFlashData('msg_type', 'success');
            redirect('?module=products&action=list');
        } else {
            setFlashData('msg', 'Cập nhật sản phẩm thất bại, vui lòng thử lại.');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=products&action=edit');

    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu');
        setFlashData('msg_type', 'danger');
        setFlashData('error', $error);
        setFlashData('old', $filterAll);
        redirect('?module=products&action=edit');
    }
    redirect('?module=products&action=edit&id=' . $productId);
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('error');
$old = getFlashData('old');
$productDetails = getFlashData('product-detail');
if ($productDetails) {
    $old = $productDetails;
}
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
                                <h1 class="h4 text-gray-900 mb-4">Sửa sản phẩm </h1>
                            </div>
                            <?php
                            if (!empty ($msg)) {
                                getMSG($msg, $msg_type);
                            }
                            ?>
                            <form class="products" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <p>Tên sản phẩm:</p>
                                            <input type="title" class="form-control form-control-user" name="title"
                                                value="<?php
                                                echo old('title', $old)
                                                    ?>">
                                            <?php
                                            echo form_error('title', '<span class= "error">', '</span>', $error);
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Chọn danh mục:</label>
                                            <select id="category_id" name="category_id" class="form-control">
                                                <?php
                                                try {
                                                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                    $stmt = $conn->query("SELECT id, name FROM category");
                                                    $categories = $stmt->fetchAll();

                                                    foreach ($categories as $category) {
                                                        echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
                                                    }
                                                } catch (PDOException $e) {
                                                    echo "Lỗi kết nối: " . $e->getMessage();
                                                }
                                                $conn = null;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <p>Giá sản phẩm:</p>
                                            <input type="text" class="form-control form-control-user" name="price"
                                                value="<?php
                                                echo old('price', $old)
                                                    ?>">
                                            <?php
                                            echo form_error('price', '<span class= "error">', '</span>', $error);
                                            ?>
                                        </div>

                                        <div class="form-group">
                                            <p>Ảnh bìa:</p>
                                            <input type="file" class="form-control form-control-user" name="thumbnail"
                                                onchange="readThumbnailURL(this);">
                                            <?php if (!empty ($old['thumbnail'])): ?>
                                                <img id="ShowImage" src="../images/<?php echo $old['thumbnail']; ?>"
                                                    width="150" height="200" />
                                            <?php else: ?>
                                                <p>Không có hình ảnh bìa hiện tại.</p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            // Thực hiện truy vấn để lấy danh sách các ảnh từ bảng galery dựa trên product_id
                                            $conn = new PDO("mysql:host=localhost;dbname=fashionweb", "root", "mysql");
                                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                            // Sau đó, thực hiện truy vấn
                                            $stmt = $conn->prepare("SELECT images_path FROM galery WHERE product_id = :product_id");
                                            $stmt->bindParam(':product_id', $productId);
                                            $stmt->execute();
                                            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <p>Thư viện ảnh:</p>
                                            <input type="file" class="form-control form-control-user"
                                                onchange="readGalleryURL(this);" name="images_path[]" id="uploadInput"
                                                multiple>
                                            <div id="imagePreview">
                                                <?php
                                                // Hiển thị các hình ảnh từ bảng galery
                                                if ($stmt->rowCount() > 0) {
                                                    foreach ($images as $image) {
                                                        $image_paths = explode(",", $image['images_path']);
                                                        foreach ($image_paths as $image_path) {
                                                            // Hiển thị mỗi ảnh trong thẻ <img>
                                                            echo "<img src='../images/$image_path' style='max-width: 180px;'> ";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <style>
                                            .img-preview {
                                                width: 200px;
                                                padding: 20px;
                                            }
                                        </style>
                                        <script>
                                            function readThumbnailURL(input) {
                                                if(input.files && input.files[0]) {
                                                    var reader = new FileReader();
                                                    reader.onload = function (e) {
                                                        $('#ShowImage')
                                                            .attr('src', e.target.result)
                                                            .width(150)
                                                            .height(200);
                                                    };
                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            }

                                            function readGalleryURL(input) {
                                                var files = input.files;
                                                var imagePreview = document.getElementById('imagePreview');
                                                imagePreview.innerHTML = ''; // Xóa hình ảnh trước đó
                                                for(var i = 0; i < files.length; i++) {
                                                    var file = files[i];
                                                    var imageType = /image.*/;
                                                    if(!file.type.match(imageType)) {
                                                        continue;
                                                    }
                                                    var img = document.createElement('img');
                                                    img.classList.add('img-preview');
                                                    img.file = file;
                                                    imagePreview.appendChild(img);
                                                    var reader = new FileReader();
                                                    reader.onload = (function (aImg) {
                                                        return function (e) {
                                                            aImg.src = e.target.result;
                                                        };
                                                    })(img);
                                                    reader.readAsDataURL(file);
                                                }
                                            }

                                            document.getElementById('uploadInput').addEventListener('change', function () {
                                                readGalleryURL(this);
                                            });

                                            document.getElementById('uploadThumbnail').addEventListener('change', function () {
                                                readThumbnailURL(this);
                                            });


                                        </script>

                                        <div class="form-group">
                                            <p>Mô tả:</p>
                                            <input type="text" class="form-control form-control-user" name="description"
                                                value="<?php
                                                echo old('description', $old)
                                                    ?>">
                                            <?php
                                            echo form_error('description', '<span class= "error">', '</span>', $error);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input type="hidden" name="id" value="<?php echo $productId ?>">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <button type="submit" class="mg-btn btn btn-primary btn-block">
                                            Cập nhật
                                        </button>
                                    </div>
                                    <div class="col-sm-6"><a href="?module=products&action=list"
                                            class="mg-btn btn btn-success btn-block">Quay lại</a></div>
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