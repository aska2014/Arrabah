<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body dir="rtl">
		<h2>إعادة الباسورد</h2>

		<div>
			لإعادة كلمة السر الخاصة بك أضغط على اللينك بالأسفل و كمل الإستمارة.<br/>
			<a href="{{ URL::route('reset', array($token)) }}">{{ URL::route('reset', array($token)) }}</a>
		</div>
	</body>
</html>