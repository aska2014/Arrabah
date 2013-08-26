<?php

use Gallery\Image\Image;
use Gallery\Gallery\Gallery;

use Social\Job\Job;
use Social\Event\Event;

use Website\Contact\Contact;



Image::created(function($image)
{
	// Stop creating if no authenticated user.
	if(! Auth::accepted()) return false;

	// Attach to the authenticated user.
	$image->user()->associate(Auth::user())->save();

	// Create history for this image if and only if it's attached
	// to gallery
	if($image->attachedToGallery())

		// Save the creation in history.
		$image->histories()->create(array(

			'title'       => 'New image created.',

		))->user()->associate(Auth::user())->save();
});



Gallery::created(function($gallery)
{
	// Stop creating if no authenticated user.
	if(! Auth::accepted()) return false;

	// Attach to the authenticated user.
	$gallery->user()->associate(Auth::user())->save();

	// Save the creation in history.
	$gallery->histories()->create(array(

		'title'       => 'New gallery created',

	))->user()->associate(Auth::user())->save();
});



Job::created(function($job)
{
	// Stop creating if no authenticated user.
	if(! Auth::accepted()) return false;

	// Attach to the authenticated user.
	$job->user()->associate(Auth::user())->save();

	// Save the creation in history.
	$job->histories()->create(array(

		'title'       => 'New job created.',

	))->user()->associate(Auth::user())->save();

});



Event::created(function($event)
{
	// Stop creating if no authenticated user.
	if(! Auth::accepted()) return false;

	// Attach to the authenticated user.
	$event->user()->associate(Auth::user())->save();

	// Save the creation in history.
	$event->histories()->create(array(

		'title'       => 'New event created',

	))->user()->associate(Auth::user())->save();
});






Contact::created(function($contact)
{
	// Stop creating if no authenticated user.
	if(! Auth::accepted()) return false;

	// Attach to the authenticated user.
	$contact->user()->associate(Auth::user());

	// Save the creation in history.
	$contact->histories()->create(array(

		'title'       => 'New message sent from contact us page',

	))->user()->associate(Auth::user())->save();
});

