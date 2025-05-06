<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>ROSSA | <?php echo $__env->yieldContent('title', 'Rodent Open Science Skeletal Archive'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?>
	@livewireStyles
</head>
<body>
	<?php if (isset($component)) { $__componentOriginal9b2ca4611dccdba84b7f1cce4afec7c8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9b2ca4611dccdba84b7f1cce4afec7c8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.environment-banner','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('environment-banner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9b2ca4611dccdba84b7f1cce4afec7c8)): ?>
<?php $attributes = $__attributesOriginal9b2ca4611dccdba84b7f1cce4afec7c8; ?>
<?php unset($__attributesOriginal9b2ca4611dccdba84b7f1cce4afec7c8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9b2ca4611dccdba84b7f1cce4afec7c8)): ?>
<?php $component = $__componentOriginal9b2ca4611dccdba84b7f1cce4afec7c8; ?>
<?php unset($__componentOriginal9b2ca4611dccdba84b7f1cce4afec7c8); ?>
<?php endif; ?>

    <header>
        <?php echo $__env->make('components.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('components.study-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </header>

    <main>
		<div class="container">
			<?php if(session()->has('success')): ?>
				<div class="alert alert-success">
					<?php echo e(session('success')); ?>

				</div>
			<?php endif; ?>

			<?php if(session()->has('status')): ?>
				<div class="alert alert-success">
					<?php echo e(session('status')); ?>

				</div>
			<?php endif; ?>

			<?php if($errors->any()): ?>
				<div class="alert alert-danger">
					<ul class="mb-0">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
		
        <?php echo $__env->yieldContent('content'); ?>
    </main>
	<footer class="bg-dark text-white mt-4 py-3">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h5>ROSSA</h5>
					<p>Rodent Open Science Skeletal Archive</p>
				</div>
				<div class="col-md-6 text-md-end">
					<ul class="list-unstyled">
						<li><a href="<?php echo e(route('about.terms-of-use')); ?>" class="text-white">Terms of Use</a></li>
						<li><a href="<?php echo e(route('contact')); ?>" class="text-white">Contact Us</a></li>
					</ul>
				</div>
			</div>
			<div class="text-center mt-3">
				<p class="mb-0">&copy; <?php echo e(date('Y')); ?></p>
			</div>
		</div>
	</footer>
	@livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('js/vendor/htmx.min.js')); ?>"></script>
</body>
</html><?php /**PATH /home/sdp/laravel-app/resources/views/layout.blade.php ENDPATH**/ ?>