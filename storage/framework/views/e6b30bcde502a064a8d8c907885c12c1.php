<?php if( !app()->environment('production') ): ?>
<div class="py-2 text-bg-warning text-center w-100">
    <strong>Warning:</strong> You are in the <strong><?php echo e(app()->environment()); ?></strong> environment.
</div>
<?php endif; ?><?php /**PATH /home/sdp/laravel-app/resources/views/components/environment-banner.blade.php ENDPATH**/ ?>