<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-5HZF8FW');</script>
		<!-- End Google Tag Manager -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<title>@yield('title','Little Edo ร้านอาหารญี่ปุ่น ภูเก็ต สุกี้ สุกียากี้ ชาบู และซูชิ')</title>
		<meta name="description" content="@yield('meta_description','Little Edo ลิตเติ้ลเอโดะ ร้านอาหารญี่ปุ่นสไตล์ฟิวชั่น ที่คัดสรรวัตถุดิบชั้นเยี่ยม มาปรุงทั้งในแบบคลาสสิกและสร้างสรรค์ ที่หนึ่งเรื่องสุกียากี้ ชาบู ใช้เนื้อวากิวลายธรรมชาติ 100% หมูคุโรบุตะ สายพันธุ์ญี่ปุ่นแท้')">

		<meta name="keywords" content="@yield('meta_keywords','อาหารญี่ปุ่น ในภูเก็ต, ร้านอาหารญี่ปุ่น ภูเก็ต, Little Edo, ลิตเติ้ลเอโดะ,ร้านอาหารญี่ปุ่นสไตล์ฟิวชั่น, สุกี้ ภูเก็ต, สุกียากี้ ภูเก็ต, ชาบู ภูเก็ต, ซูชิ ภูเก็ต, แซลมอน ภูเก็ต, เนื้อวากิวลายธรรมชาติ, หมูคุโรบุตะ, ปูทาระบะ,อูนิ ภูเก็ต,ซาชิมิปลาสด,สปาเก็ตตี้,คานิมิโสะ')">

		<meta name="author" content="https://www.littleedo.com/">
		<meta name="application-name" content="https://www.littleedo.com/">
		<meta name="copyright" content="https://www.littleedo.com/">

		<link rel="canonical" href="https://www.littleedo.com/"/>


		<meta property="og:description" content="@yield('meta_description','Little Edo ลิตเติ้ลเอโดะ ร้านอาหารญี่ปุ่นสไตล์ฟิวชั่น ที่คัดสรรวัตถุดิบชั้นเยี่ยม มาปรุงทั้งในแบบคลาสสิกและสร้างสรรค์ ที่หนึ่งเรื่องสุกียากี้ ชาบู ใช้เนื้อวากิวลายธรรมชาติ 100% หมูคุโรบุตะ สายพันธุ์ญี่ปุ่นแท้')" />
		<meta property="og:title" content="@yield('title','Little Edo ร้านอาหารญี่ปุ่น ภูเก็ต สุกี้ สุกียากี้ ชาบู และซูชิ')" /> 
		<meta property="og:url" content="https://www.littleedo.com/" />
		<meta property="og:site_name" content="Little Edo ร้านอาหารญี่ปุ่น ภูเก็ต สุกี้ สุกียากี้ ชาบู และซูชิ" />
		<meta property="og:type" content="product" /> 
		<meta property="og:image" content="https://www.littleedo.com/image_upload/image_slide_website/7e5467a47bac88de48bd7f9c4be3b7c2_o.png" />

		<style>
			@import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200&display=swap');
		</style>
		<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
		
		@include("/frontend/layouts/css/css")

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-4R5F7PPZDF"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-4R5F7PPZDF');
		</script>
	</head>
	<body class="goto-here">
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5HZF8FW"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
				<!-- End Google Tag Manager (noscript) -->
        @include("/frontend/layouts/navbar/navbar")
        @yield("content")
		@include("/frontend/layouts/footer/footer")
		@include("/frontend/layouts/js/js")
	</body>
</html>