<?php

$with_breadcrumbs = isset($with_breadcrumbs) ? $with_breadcrumbs : true;
$meta_title = isset($meta_title) ? $meta_title : wp_title('', false);

?><!doctype html>
<html @php(language_attributes())>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ trim($meta_title) }}</title>
	@php(wp_head())
</head>

<body @php(body_class())>

@include('blocks.site-header')

<div class="site-body">
	<div class="site-body__inner">

		@if($with_breadcrumbs)
			<div class="l-content">
				@include('blocks.breadcrumbs')
			</div>
		@endif

		<main class="l-content">
			@yield('content')
		</main>

	</div>
</div>

@include('blocks.site-footer')
@php(wp_footer())

</body>
</html>
