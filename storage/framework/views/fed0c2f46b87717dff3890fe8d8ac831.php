<?php $__env->startSection('title', 'Katalog Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><strong>Filter Produk</strong></div>
                <div class="card-body">
                    <form action="<?php echo e(route('catalog.index')); ?>" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">Semua Kategori</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Provinsi</label>
                            <select name="province_id" class="form-select form-select-sm">
                                <option value="">Semua Provinsi</option>
                                <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($province->id); ?>" <?php echo e(request('province_id') == $province->id ? 'selected' : ''); ?>>
                                        <?php echo e($province->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urutkan</label>
                            <select name="sort" class="form-select form-select-sm">
                                <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Terbaru</option>
                                <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Harga Terendah</option>
                                <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Harga Tertinggi</option>
                                <option value="rating" <?php echo e(request('sort') == 'rating' ? 'selected' : ''); ?>>Rating Tertinggi</option>
                            </select>
                        </div>
                        <?php if(request('search')): ?>
                            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Terapkan Filter</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <?php if(request('search')): ?>
                <p class="text-muted mb-3">Hasil pencarian untuk: <strong>"<?php echo e(request('search')); ?>"</strong></p>
            <?php endif; ?>
            
            <?php if($products->count() > 0): ?>
                <div class="row">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mb-4">
                            <div class="card product-card h-100 shadow-sm">
                                <a href="<?php echo e(route('catalog.show', $product->slug)); ?>">
                                    <?php if($product->foto_utama): ?>
                                        <?php if(str_starts_with($product->foto_utama, 'http')): ?>
                                            <img src="<?php echo e($product->foto_utama); ?>" class="card-img-top product-image" alt="<?php echo e($product->nama_produk); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset($product->foto_utama)); ?>" class="card-img-top product-image" alt="<?php echo e($product->nama_produk); ?>">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="card-img-top product-image bg-light d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="card-body">
                                    <a href="<?php echo e(route('catalog.show', $product->slug)); ?>" class="text-decoration-none text-dark">
                                        <h6 class="card-title text-truncate"><?php echo e($product->nama_produk); ?></h6>
                                    </a>
                                    <p class="text-primary fw-bold mb-1"><?php echo e($product->formatted_harga); ?></p>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="rating-stars">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="bi bi-star<?php echo e($i <= round($product->rating_avg) ? '-fill' : ''); ?>"></i>
                                            <?php endfor; ?>
                                        </span>
                                        <small class="text-muted ms-1">(<?php echo e($product->rating_count); ?>)</small>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-shop"></i> 
                                        <a href="<?php echo e(route('catalog.seller', $product->seller->id)); ?>" class="text-decoration-none text-muted">
                                            <?php echo e($product->seller->nama_toko); ?>

                                        </a>
                                    </small><br>
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt"></i> <?php echo e($product->seller->city->name ?? ''); ?>, <?php echo e($product->seller->province->name ?? ''); ?>

                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="d-flex justify-content-center">
                    <?php echo e($products->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">Tidak ada produk ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/benjamin/Documents/BeliDongBos/resources/views/catalog/index.blade.php ENDPATH**/ ?>