<?php if( !app()->environment('production') ): ?>
<div class="py-2 text-bg-warning text-center w-100">
    <strong>Warning:</strong> You are in the <strong><?php echo e(app()->environment()); ?></strong> environment.
</div>
<?php endif; ?><?php /**PATH /var/www/resources/views/components/environment-banner.blade.php ENDPATH**/ ?>