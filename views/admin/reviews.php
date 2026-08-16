<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i><?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-star me-2"></i>Quản lý Đánh giá & Bình luận</h6>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 15%">Khách hàng</th>
                    <th style="width: 25%">Sản phẩm</th>
                    <th style="width: 10%">Đánh giá</th>
                    <th style="width: 30%">Nội dung</th>
                    <th style="width: 15%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reviews)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Chưa có đánh giá nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($reviews as $i => $review): ?>
                    <tr>
                        <td class="fw-semibold text-secondary"><?= $offset + $i + 1 ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($review['user_full_name']) ?></td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($review['product_name']) ?>">
                                <?= htmlspecialchars($review['product_name']) ?>
                            </div>
                        </td>
                        <td>
                            <span class="text-warning fs-5">
                                <?= str_repeat('★', $review['rating']) ?><?= str_repeat('☆', 5 - $review['rating']) ?>
                            </span>
                        </td>
                        <td>
                            <p class="mb-1 text-dark" style="font-size: 0.9rem;"><?= nl2br(htmlspecialchars($review['content'])) ?></p>
                            <small class="text-muted"><i class="bi bi-clock me-1"></i><?= date('H:i d/m/Y', strtotime($review['review_date'])) ?></small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 action-dropdown position-relative">
                                <button type="button" class="btn-action-detail" data-bs-toggle="modal" data-bs-target="#replyModal<?= $review['review_id'] ?>">
                                    <i class="bi bi-info-circle"></i> Chi tiết
                                </button>
                                <div class="dropdown dropend">
                                    <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        <li>
                                            <a class="dropdown-item text-danger" href="?action=admin-delete-review&id=<?= $review['review_id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
                                                <i class="bi bi-trash"></i> Xóa đánh giá
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>



                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-between align-items-center p-3 border-top" style="border-color:var(--border-light)!important">
        <!-- Chỉnh số lượng hiển thị -->
        <div class="d-flex align-items-center gap-2">
            <select class="form-select form-select-sm" style="width: auto; border-radius: 4px;" onchange="window.location.href='?action=admin-reviews&limit='+this.value">
                <option value="10" <?= ($limit ?? 10) == 10 ? 'selected' : '' ?>>10 / trang</option>
                <option value="20" <?= ($limit ?? 10) == 20 ? 'selected' : '' ?>>20 / trang</option>
                <option value="50" <?= ($limit ?? 10) == 50 ? 'selected' : '' ?>>50 / trang</option>
                <option value="100" <?= ($limit ?? 10) == 100 ? 'selected' : '' ?>>100 / trang</option>
            </select>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:0.85rem;">Tổng <?= $totalReviews ?? 0 ?> bản ghi</span>
            
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-reviews&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php 
                        $start = max(1, ($page ?? 1) - 2);
                        $end = min($totalPages, ($page ?? 1) + 2);
                        
                        if ($start > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-reviews&limit='.($limit ?? 10).'&page=1">1</a></li>';
                            if ($start > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        for ($i = $start; $i <= $end; $i++) {
                            $active = ($i == ($page ?? 1)) ? 'active' : '';
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?action=admin-reviews&limit='.($limit ?? 10).'&page='.$i.'">' . $i . '</a></li>';
                        }
                        
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-reviews&limit='.($limit ?? 10).'&page='.$totalPages.'">'.$totalPages.'</a></li>';
                        }
                        ?>
                        
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-reviews&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Render Modals Outside Table-Responsive -->
<?php if (!empty($reviews)): ?>
    <?php foreach ($reviews as $review): ?>
        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal<?= $review['review_id'] ?>" tabindex="-1" aria-labelledby="replyModalLabel<?= $review['review_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold" id="replyModalLabel<?= $review['review_id'] ?>">Trả lời Đánh giá</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="?action=admin-reply-review" method="POST">
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto; background-color: #f8f9fa;">
                            <input type="hidden" name="review_id" value="<?= $review['review_id'] ?>">
                            
                            <!-- Original Review -->
                            <div class="d-flex mb-3">
                                <div class="p-3 bg-white border rounded shadow-sm w-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong class="text-dark"><i class="bi bi-person-circle text-secondary me-1"></i> <?= htmlspecialchars($review['user_full_name']) ?></strong>
                                        <small class="text-muted"><?= date('H:i d/m/Y', strtotime($review['review_date'])) ?></small>
                                    </div>
                                    <p class="mb-0 text-dark"><?= nl2br(htmlspecialchars($review['content'])) ?></p>
                                </div>
                            </div>
                            
                            <!-- Threaded Replies -->
                            <?php if (!empty($review['replies'])): ?>
                                <?php foreach ($review['replies'] as $reply): ?>
                                    <?php if ($reply['is_admin'] == 1): ?>
                                        <div class="d-flex mb-3 justify-content-end">
                                            <div class="p-3 bg-primary text-white border-0 rounded shadow-sm" style="max-width: 85%;">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong><i class="bi bi-shop me-1"></i> Shop phản hồi</strong>
                                                    <small class="text-white-50 ms-3"><?= date('H:i d/m', strtotime($reply['created_at'])) ?></small>
                                                </div>
                                                <p class="mb-0"><?= nl2br(htmlspecialchars($reply['content'])) ?></p>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex mb-3">
                                            <div class="p-3 bg-white border rounded shadow-sm" style="max-width: 85%;">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong class="text-dark"><i class="bi bi-person-circle text-secondary me-1"></i> <?= htmlspecialchars($reply['full_name'] ?? 'Khách hàng') ?></strong>
                                                    <small class="text-muted ms-3"><?= date('H:i d/m', strtotime($reply['created_at'])) ?></small>
                                                </div>
                                                <p class="mb-0 text-dark"><?= nl2br(htmlspecialchars($reply['content'])) ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                        <div class="modal-footer bg-light border-0 d-block">
                            <label class="form-label fw-bold">Nội dung phản hồi của Shop <span class="text-danger">*</span></label>
                            <textarea class="form-control mb-2" name="reply_content" rows="3" placeholder="Nhập câu trả lời..." required></textarea>
                            <div class="text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i> Gửi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Reply Modal -->
    <?php endforeach; ?>
<?php endif; ?>
