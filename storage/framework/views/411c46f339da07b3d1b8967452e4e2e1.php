<?php $__env->startSection('title', $product->nama_produk); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('catalog.index')); ?>">Katalog</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('catalog.index', ['category_id' => $product->category_id])); ?>"><?php echo e($product->category->name); ?></a></li>
            <li class="breadcrumb-item active"><?php echo e(Str::limit($product->nama_produk, 30)); ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <?php if($product->foto_utama): ?>
                    <?php if(str_starts_with($product->foto_utama, 'http')): ?>
                        <img src="<?php echo e($product->foto_utama); ?>" class="card-img-top" alt="<?php echo e($product->nama_produk); ?>" style="max-height: 400px; object-fit: contain;">
                    <?php else: ?>
                        <img src="<?php echo e(asset('storage/' . $product->foto_utama)); ?>" class="card-img-top" alt="<?php echo e($product->nama_produk); ?>" style="max-height: 400px; object-fit: contain;">
                    <?php endif; ?>
                <?php else: ?>
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                    </div>
                <?php endif; ?>
            </div>
            <?php if($product->foto_galeri && count($product->foto_galeri) > 0): ?>
                <div class="row mt-2">
                    <?php $__currentLoopData = $product->foto_galeri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-3">
                            <img src="<?php echo e(asset('storage/' . $foto)); ?>" class="img-thumbnail" alt="Galeri">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-7">
            <h4><?php echo e($product->nama_produk); ?></h4>
            <div class="d-flex align-items-center mb-2">
                <span class="rating-stars">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <i class="bi bi-star<?php echo e($i <= round($product->rating_avg) ? '-fill' : ''); ?>"></i>
                    <?php endfor; ?>
                </span>
                <span class="ms-2"><?php echo e(number_format($product->rating_avg, 1)); ?></span>
                <span class="text-muted ms-1">(<?php echo e($product->rating_count); ?> ulasan)</span>
            </div>
            <h3 class="text-primary fw-bold"><?php echo e($product->formatted_harga); ?></h3>
            
            <hr>
            
            <table class="table table-sm">
                <tr><td class="text-muted" width="150">Kondisi</td><td><?php echo e(ucfirst($product->kondisi)); ?></td></tr>
                <tr><td class="text-muted">Stok</td><td><?php echo e($product->stok); ?> pcs</td></tr>
                <tr><td class="text-muted">Berat</td><td><?php echo e($product->berat ?? '-'); ?></td></tr>
                <tr><td class="text-muted">Min. Pembelian</td><td><?php echo e($product->min_pembelian); ?> pcs</td></tr>
                <tr><td class="text-muted">Kategori</td><td><?php echo e($product->category->name); ?></td></tr>
                <?php if($product->etalase): ?>
                <tr><td class="text-muted">Etalase</td><td><?php echo e($product->etalase); ?></td></tr>
                <?php endif; ?>
            </table>

            <hr>
            
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shop fs-1 text-primary me-3"></i>
                        <div>
                            <h6 class="mb-0">
                                <a href="<?php echo e(route('catalog.seller', $product->seller->id)); ?>" class="text-decoration-none">
                                    <?php echo e($product->seller->nama_toko); ?>

                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="bi bi-geo-alt"></i> <?php echo e($product->seller->city->name ?? ''); ?>, <?php echo e($product->seller->province->name ?? ''); ?>

                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><strong>Deskripsi Produk</strong></div>
                <div class="card-body">
                    <?php echo nl2br(e($product->deskripsi)); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><strong>Ulasan Produk (<?php echo e($product->rating_count); ?>)</strong></div>
                <div class="card-body">
                    <?php if($product->ratings->count() > 0): ?>
                        <?php $__currentLoopData = $product->ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong><?php echo e($rating->nama); ?></strong>
                                    <span class="rating-stars">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?php echo e($i <= $rating->rating ? '-fill' : ''); ?>"></i>
                                        <?php endfor; ?>
                                    </span>
                                </div>
                                <small class="text-muted"><?php echo e($rating->created_at->format('d M Y')); ?></small>
                                <p class="mb-0 mt-2"><?php echo e($rating->komentar); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($product->rating_count > 10): ?>
                            <a href="<?php echo e(route('catalog.ratings', $product)); ?>" class="btn btn-outline-primary btn-sm">
                                Lihat Semua Ulasan
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-muted mb-0">Belum ada ulasan untuk produk ini.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><strong>Tulis Ulasan</strong></div>
                <div class="card-body">
                    <form action="<?php echo e(route('rating.store', $product)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nama')); ?>" required>
                            <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_hp" class="form-control <?php $__errorArgs = ['nomor_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nomor_hp')); ?>" required>
                                <?php $__errorArgs = ['nomor_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi Anda</label>
                            <select name="province_id" class="form-select">
                                <option value="">Pilih Provinsi (opsional)</option>
                                <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($province->id); ?>"><?php echo e($province->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rating <span class="text-danger">*</span></label>
                            <div class="rating-input">
                                <?php for($i = 5; $i >= 1; $i--): ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating<?php echo e($i); ?>" value="<?php echo e($i); ?>" <?php echo e(old('rating') == $i ? 'checked' : ''); ?> required>
                                        <label class="form-check-label" for="rating<?php echo e($i); ?>"><?php echo e($i); ?> <i class="bi bi-star-fill text-warning"></i></label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Komentar <span class="text-danger">*</span></label>
                            <textarea name="komentar" class="form-control <?php $__errorArgs = ['komentar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3" required><?php echo e(old('komentar')); ?></textarea>
                            <?php $__errorArgs = ['komentar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if($relatedProducts->count() > 0): ?>
    <div class="row mt-4">
        <div class="col-12">
            <h5>Produk Serupa</h5>
            <div class="row">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 mb-3">
                        <div class="card product-card h-100 shadow-sm">
                            <a href="<?php echo e(route('catalog.show', $related->slug)); ?>">
                                <?php if($related->foto_utama): ?>
                                    <?php if(str_starts_with($related->foto_utama, 'http')): ?>
                                        <img src="<?php echo e($related->foto_utama); ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('storage/' . $related->foto_utama)); ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    <?php endif; ?>
                                <?php endif; ?>
                            </a>
                            <div class="card-body">
                                <a href="<?php echo e(route('catalog.show', $related->slug)); ?>" class="text-decoration-none text-dark">
                                    <h6 class="card-title text-truncate"><?php echo e($related->nama_produk); ?></h6>
                                </a>
                                <p class="text-primary fw-bold mb-0"><?php echo e($related->formatted_harga); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/benjamin/Documents/BeliDongBos/resources/views/catalog/show.blade.php ENDPATH**/ ?>