<?php $__env->startSection('title', 'Pendaftaran Berhasil'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card shadow">
                <div class="card-body p-5">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    <h3 class="mt-3">Pendaftaran Berhasil!</h3>
                    <p class="text-muted">
                        Terima kasih telah mendaftar sebagai penjual di BeliDongBos.
                    </p>
                    <p>
                        Kami akan memverifikasi data Anda dan mengirimkan email pemberitahuan 
                        beserta link aktivasi setelah akun Anda disetujui.
                    </p>
                    <hr>
                    <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary">
                        <i class="bi bi-house"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/benjamin/Documents/BeliDongBos/resources/views/seller/register-success.blade.php ENDPATH**/ ?>