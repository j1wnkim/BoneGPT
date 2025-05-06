<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ROSSA | @yield('title', 'Rodent Open Science Skeletal Archive')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	@vite(['resources/css/app.css','resources/js/app.js'])
	@livewireStyles
</head>
<body>
	<x-environment-banner />

    <header>
        @include('components.nav')
        @include('components.study-nav')
    </header>

    <main>
		<div class="container">
			@if(session()->has('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif

			@if(session()->has('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
			@endif

			@if($errors->any())
				<div class="alert alert-danger">
					<ul class="mb-0">
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
		</div>
		
        @yield('content')
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
						<li><a href="{{ route('about.terms-of-use') }}" class="text-white">Terms of Use</a></li>
						<li><a href="{{ route('contact') }}" class="text-white">Contact Us</a></li>
					</ul>
				</div>
			</div>
			<div class="text-center mt-3">
				<p class="mb-0">&copy; {{ date('Y') }}</p>
			</div>
		</div>
	</footer>
	@livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/vendor/htmx.min.js') }}"></script>
</body>
</html>