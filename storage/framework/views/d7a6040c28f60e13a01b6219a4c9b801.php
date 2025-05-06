<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ms-auto">
				<?php if(session()->has('netId')): ?>
    				<span class="navbar-text">Welcome, <?php echo e(session('netId')); ?></span>
    				<li class="nav-item">
        				<a href="<?php echo e(route('logout')); ?>" class="nav-link">Logout</a>
    				</li>
				<?php else: ?>
    				<li class="nav-item">
        				<a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
    				</li>
    				<li class="nav-item">
        				<a class="nav-link" href="<?php echo e(route('register')); ?>">Create Account</a>
   					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>

<nav class="navbar navbar-light bg-white pb-2">
	<div class="container d-flex justify-content-between align-items-center">
		<a class="navbar-brand" href="/">
			<img src="<?php echo e(asset('images/ROSSA-logo3.png')); ?>" alt="ROSSA Logo" class="img-fluid" style="max-height: 60px;">
		</a>
		<ul class="nav">
			<li class="nav-item">
				<a class="nav-link <?php echo e(request()->is('/') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(request()->is('data-submission') || request()->is('study*') ? 'active' : ''); ?>" href="<?php echo e(route('data-submission')); ?>">Data Submission</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle <?php echo e(request()->is('core-facility*') ? 'active' : ''); ?>" href="#" id="coreFacilityDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					Core Facility Registry
				</a>
				<ul class="dropdown-menu" aria-labelledby="coreFacilityDropdown">
					<li>
						<a class="dropdown-item" href="<?php echo e(route('core-facility.index')); ?>">View Facilities</a>
					</li>
					<li>
						<a class="dropdown-item" href="<?php echo e(route('core-facility.create')); ?>">Register New Facility</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(request()->is('team') ? 'active' : ''); ?>" href="<?php echo e(route('team')); ?>">Team Members</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(request()->is('terms-of-use') ? 'active' : ''); ?>" href="<?php echo e(url('/terms-of-use')); ?>">Terms of Use</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(request()->is('contact') ? 'active' : ''); ?>" href="<?php echo e(route('contact')); ?>">Contact Us</a>
			</li>
		</ul>

	</div>
</nav>
<?php /**PATH /var/www/resources/views/components/nav.blade.php ENDPATH**/ ?>