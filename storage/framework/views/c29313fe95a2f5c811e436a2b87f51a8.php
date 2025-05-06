<?php $__env->startSection('content'); ?>
<div class="py-5">
    <div class="container">
        <h1>Welcome to the ROSSA Data Submission Form</h1>

		<div class="mb-4">
			<p>
				Instructions: Based on your login, we will identify if you have any previous studies submitted. The table below shows the study status, study ID, and study title for each study. For studies that are "in progress", we offer the option to continue filling out the study form. You can also create a new study.
			</p>

            <?php if( !Auth::check() ): ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Login</a>
            <?php else: ?>
                <form action="<?php echo e(route('study.store')); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-primary">Create Study</button>
                </form>
            <?php endif; ?>
		</div>

		<h2>Your Studies</h2>

        <?php if( !Auth::check() ): ?>
            <div class="alert alert-info">
                Please login to view your studies.
            </div>
        <?php elseif($studies && $studies->count() > 0): ?> 
            <table class="table">
                <thead>
                    <tr>
                        <th>Study Identifier</th>
                        <th>Study Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $studies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $study): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($study->identifier); ?></td>
                            <td><?php echo e($study->title ?? '-'); ?></td>
                            <td><?php echo e($study->status); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('study.study-information', ['study' => $study->id])); ?>" 
                                    class="btn btn-warning btn-sm">
                                        Continue Study
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">
                No studies found. Click "Create New Study" to get started.
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sdp/laravel-app/resources/views/data-submission.blade.php ENDPATH**/ ?>