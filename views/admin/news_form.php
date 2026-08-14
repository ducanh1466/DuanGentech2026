<div class="row g-4 justify-content-center">
    <div class="col-lg-12">
        <div class="admin-form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    <?= isset($news) ? 'Chỉnh sửa bài viết' : 'Thêm bài viết mới' ?>
                </h5>
            </div>

            <form action="<?= isset($news) ? '?action=admin-news-update' : '?action=admin-news-create' ?>" method="POST" enctype="multipart/form-data">
                
                <?php if (isset($news)): ?>
                    <input type="hidden" name="news_id" value="<?= $news['id'] ?>">
                    <input type="hidden" name="old_image_url" value="<?= htmlspecialchars($news['image_url']) ?>">
                <?php endif; ?>

                <div class="row">
                    <!-- Cột Trái -->
                    <div class="col-md-8 border-end pe-4">
                        <div class="mb-4">
                            <label class="form-horizontal-label d-block mb-2">Tiêu đề bài viết <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="titleInput" value="<?= isset($news) ? htmlspecialchars($news['title']) : '' ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-horizontal-label d-block mb-2">Đường dẫn thân thiện (Slug) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="slug" id="slugInput" value="<?= isset($news) ? htmlspecialchars($news['slug']) : '' ?>" required>
                            <small class="text-muted mt-1 d-block">Đường dẫn tự động tạo từ tiêu đề, viết liền không dấu, ngăn cách bằng dấu gạch ngang.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-horizontal-label d-block mb-2">Đoạn tóm tắt (Summary)</label>
                            <textarea class="form-control" name="summary" rows="3"><?= isset($news) ? htmlspecialchars($news['summary']) : '' ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-horizontal-label d-block mb-2">Nội dung chi tiết <span class="text-danger">*</span></label>
                            <div id="quill-editor" style="height: 400px;"><?= isset($news) ? $news['content'] : '' ?></div>
                            <input type="hidden" name="content" id="contentInput">
                        </div>
                    </div>

                    <!-- Cột Phải -->
                    <div class="col-md-4 ps-4">
                        <div class="mb-4">
                            <label class="form-horizontal-label d-block mb-2">Danh mục</label>
                            <select class="form-select" name="category_id">
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= (isset($news) && $news['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-horizontal-label d-block mb-2">Trạng thái</label>
                            <select class="form-select" name="status">
                                <option value="1" <?= (isset($news) && $news['status'] == 1) ? 'selected' : '' ?>>Xuất bản (Hiện)</option>
                                <option value="0" <?= (isset($news) && $news['status'] == 0) ? 'selected' : '' ?>>Bản nháp (Ẩn)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="isFeatured" name="is_featured" value="1" <?= (isset($news) && $news['is_featured'] == 1) ? 'checked' : '' ?>>
                                <label class="form-check-label form-horizontal-label" for="isFeatured">Đặt làm bài Nổi bật</label>
                            </div>
                            <small class="text-muted d-block mt-1">Bài nổi bật sẽ xuất hiện to nhất ở đầu trang Tin tức.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-horizontal-label d-block mb-2">Ảnh đại diện (Thumbnail)</label>
                            <input type="file" class="form-control mb-2" name="image" accept="image/*" onchange="previewImage(event)">
                            
                            <div id="imagePreviewContainer" class="mt-2 text-center p-2 border rounded <?= !isset($news) || empty($news['image_url']) ? 'd-none' : '' ?>">
                                <img id="imagePreview" src="<?= isset($news) ? htmlspecialchars($news['image_url']) : '' ?>" alt="Preview" style="max-width: 100%; border-radius: 4px; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions mt-5">
                    <?php if (isset($news)): ?>
                        <button type="button" class="btn-form-delete me-auto"
                        onclick="if(confirm('Bạn có chắc chắn muốn xóa bài viết này?')) { document.getElementById('deleteForm').submit(); }">
                            <i class="bi bi-trash me-1"></i> Xóa
                        </button>
                    <?php endif; ?>
                    
                    <a href="?action=admin-news" class="btn-form-close text-decoration-none d-inline-flex align-items-center">
                        <i class="bi bi-x-lg me-1"></i> Đóng
                    </a>
                    
                    <button type="submit" class="btn-form-save d-inline-flex align-items-center">
                        <i class="bi bi-save me-1"></i> Lưu
                    </button>
                </div>
            </form>

            <?php if (isset($news)): ?>
            <form id="deleteForm" method="POST" action="?action=admin-news-delete">
                <input type="hidden" name="news_id" value="<?= $news['id'] ?>">
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Nạp QuillJS từ CDN -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    // Khởi tạo Quill Editor
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image', 'video'],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ]
        }
    });

    // Khi submit form, copy nội dung HTML từ editor vào input ẩn
    document.querySelector('form').onsubmit = function() {
        document.querySelector('#contentInput').value = quill.root.innerHTML;
    };

    // Hàm chuyển tiêu đề thành Slug
    document.getElementById('titleInput').addEventListener('keyup', function() {
        let title = this.value;
        let slug = title.toLowerCase();
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/[^a-z0-9 -]/g, '');
        slug = slug.replace(/\s+/g, '-');
        slug = slug.replace(/-+/g, '-');
        
        document.getElementById('slugInput').value = slug;
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            document.getElementById('imagePreviewContainer').classList.remove('d-none');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
