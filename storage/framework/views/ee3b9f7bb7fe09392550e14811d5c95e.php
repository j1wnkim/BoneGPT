<?php $__env->startSection('content'); ?>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1>Forgot Password</h1>
                        <form method="POST" action="<?php echo e(route('forgot-password')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="form-group mb-3">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required autofocus>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        
                    </div>
                </div>

                <p class="small text-center">
                    <a href="<?php echo e(route('login')); ?>">Login</a>
                    &bull;
                    <a href="<?php echo e(route('register')); ?>">Register New Account</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>