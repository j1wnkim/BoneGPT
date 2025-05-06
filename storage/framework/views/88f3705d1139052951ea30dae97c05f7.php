<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2>Skeletal Biology Team</h2>
        <div class="row">
            <?php $__currentLoopData = $teamMembers['skeletal_biology']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo e($member['name']); ?></h3>
                            <p class="card-text"><strong>Institution:</strong> <?php echo e($member['institution']); ?></p>
                            <p class="card-text"><strong>Department:</strong> <?php echo e($member['department']); ?></p>
                            <p class="card-text"><strong>Location:</strong> <?php echo e($member['location']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <h2>Computer Science, Software and Infrastructure Team</h2>
        <div class="row">
            <?php $__currentLoopData = $teamMembers['computer_science']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo e($member['name']); ?></h3>
                            <p class="card-text"><strong>Institution:</strong> <?php echo e($member['institution']); ?></p>
                            <p class="card-text"><strong>Department:</strong> <?php echo e($member['department']); ?></p>
                            <p class="card-text"><strong>Location:</strong> <?php echo e($member['location']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/about/teampage.blade.php ENDPATH**/ ?>