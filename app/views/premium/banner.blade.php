@if($premiumPlace)

@if($page = $premiumPlace->page)
<div class="premium-header" onclick="window.location.href='{{ URL::page($page) }}'">
@else
<div class="premium-header">
@endif
	@if($premiumPlace->hasAttached())
	<div class="conditions">{{ $premiumPlace->placeable->description }}</div>
	@endif
</div>



@endif