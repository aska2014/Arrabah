@extends('master.layout1')

@section('body')

<div class="white-box events">
	<h2 class="title title-font"><div class="jobs-icon"></div>{{ $jobTitle }}</h2>

	@if(isset($profileUser) && $profileUser)
		@include('profile.submenu')
	@endif

	<div class="form-big box-form">

		@if(isset($profileUser) && $authUser->same( $profileUser ))
		<form action="{{ URL::route('jobs') }}" method="POST" enctype="multipart/form-data">
			<div class="form-section-all">
				<h3 class="form-title">أضف وظيفة جديدة <div class="plus-icon"> إظهار </div></h3>

				<div class="section-hidden padding-section">

                    <div class="form-row">
                        <div class="key">عنوان الوظيفة*</div><div class="value"><input type="text" class="txt" name="Job[title]" value="{{ Input::old('Job.title') }}" /></div>
                    </div>
                    <div class="clr"></div>
                    <div class="form-row">
                        <div class="key">مكان الوظيفة*</div><div class="value"><input type="text" class="txt" name="Job[place]" value="{{ Input::old('Job.place') }}" /></div>
                    </div>
					<div class="clr"></div>
                    <div class="form-row">
                        <div class="key">تفاصيل الوظيفة*</div><div class="value"><textarea name="Job[description]" class="txtarea">{{ Input::old('Job.description') }}</textarea></div>
                    </div>
                    <div class="clr"></div>
                    <div class="form-row">
                        <div class="key">الخبرات المطلوبة</div><div class="value"><textarea name="Job[professions]" class="txtarea">{{ Input::old('Job.professions') }}</textarea></div>
                    </div>
                    <div class="clr"></div>
					<div class="form-row">
						<div class="key">إرفاق صورة</div><div class="value"><input type="file" name="Job[image]" /></div>
						<div class="info">يمكنك تركها خالية</div>
					</div>
					<div class="clr"></div>

					<div class="buttons">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="submit" class="sbmt" value="" />
					</div>

					<div class="clr"></div>
				</div>
			</div>
		</form>
		@endif

		<div class="clr"></div>
	</div>


	@if(isset($profileUser) && $authUser->same( $profileUser ))
	<div class="clr"></div>
	<hr />
	<div class="clr"></div>
	@endif
	

	@if($jobs->isEmpty())

	<div class="empty-message">لا يوجد اى وظائف فى هذه الصفحة بعد.</div>

	@endif


	@foreach($jobs as $job)
	<div class="event">
		<div class="info">
			<h3><a href="{{ URL::job($job) }}">{{ $job->title }}</a></h3>
			<p>
				{{ Str::limit($job->description, 200) }}
			</p>
		</div>
		<div class="img">
			@if($job->image)
				<img src="{{ $job->image->getUrl( 113, 94 ) }}" width="113" />
			@endif
		</div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
	@endforeach
</div><!-- END of white-box -->


<div class="pages">
	<ul>
		{{ $jobs->links() }}
	</ul>
</div>

@stop