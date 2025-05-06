<select <?php echo e($attributes->class([
    'form-select',
    'is-invalid' => $errors->has($attributes->get('name')),
])); ?>>
    <?php echo e($slot); ?>

</select><?php /**PATH /var/www/resources/views/components/forms/select.blade.php ENDPATH**/ ?>