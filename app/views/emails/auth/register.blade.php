<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body dir="rtl">
		<h2>{{ $content->title }}</h2>

		<div>
			{{ $content->description }}

			@if($page = $content->getPage())
			{{ URL::page($page) }}
			@endif
		</div>
	</body>
</html>