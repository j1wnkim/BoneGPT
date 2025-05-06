<?php $__env->startSection('content'); ?>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1>Login</h1>
                        <form method="POST" action="<?php echo e(route('login.authenticate')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group mb-3">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required autofocus>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        
                    </div>
                </div>

                <p class="small text-center">
                    <a href="<?php echo e(route('register')); ?>">Register a New Account</a>
                    &bull;
                    <a href="<?php echo e(route('forgot-password')); ?>">Forgot Password</a>
                    <a class="nav-link" href="<?php echo e(route('logout')); ?>">Logout</a>
                <div class="text-center mt-3">
                    <a href="<?php echo e(route('cas.login')); ?>" class="btn btn-primary">UConn Login</a>
                </div>
                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/auth/login.blade.php ENDPATH**/ ?>