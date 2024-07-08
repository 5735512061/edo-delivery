<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no"/>
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>ร้านอาหารญี่ปุ่น LITTLE EDO</title>
		<meta name="author" content="codepixer">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<style>
			@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap');
		</style>
		<script src="{{asset('backend/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
			WebFont.load({
				google: {"families":["Lato:300,400,700,900"]},
				custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../backend/css/fonts.min.css']},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>
		@include("/backend/layouts/css/css")
	</head>
	<body>
		<div class="wrapper">
			@include("/backend/layouts/navbar-top/navbar-seller")
			@include("/backend/layouts/navbar-left/navbar-seller")
			<div class="main-panel">
				<div class="content">
					@yield("content")
				</div>
			</div>
		</div>
		@include("/backend/layouts/js/js")
	</body>
</html>