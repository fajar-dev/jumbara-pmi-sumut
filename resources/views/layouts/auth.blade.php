
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>JUMBARA V PMI SUMUT - {{ $title }}</title>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
		<link rel="shortcut icon" href="{{ asset('icon/pavicon.png') }}" />
    @include('layouts._partials.app.head')
    @yield('style')

	</head>

	<body id="kt_app_body">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">

        @yield('content')

				<div class="position-relative d-flex flex-lg-row-fluid w-lg-50 order-1 order-lg-2 bgi-size-cover bgi-position-center" style="background-image: url('{{ asset('app/media/auth/bg.jpg') }}');">
    
					<!-- Overlay bg-danger transparan -->
					<div class="position-absolute top-0 start-0 w-100 h-100 bg-danger opacity-50"></div>
					
					<div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100 position-relative">
							<div class="mb-0 mb-lg-12">
									<img alt="Logo" src="{{ Storage::url($setting->logo) }}" class="h-60px h-lg-600px"/>
							</div>                
							<img class="d-none d-lg-block mx-auto w-200px bg-white p-5 mb-10 mb-lg-20" src="{{ asset('icon/logo.png') }}" alt=""/>                 
					</div>
			</div>
			
			
			</div>
		</div>

    @include('layouts._partials.app.foot')
    <!--begin::Vendors Javascript(used for this page only)-->
    @yield('script')

	</body>
	<!--end::Body-->
</html>