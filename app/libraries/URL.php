<?php

use Illuminate\Support\Facades\URL as LaravelURL;

use Website\Page\Page;

use Social\Event\Event;
use Social\Job\Job;
use Social\Message\Message;

use Membership\MemberInterface;
use Membership\User\User;
use Membership\Admin\Admin;
use Membership\Family\Family;

use Gallery\Gallery\Gallery;
use Gallery\Image\Image;


class URL extends LaravelURL {

	public static function encodeTitle( $title, $max )
	{
		return Str::slug(Str::words($title, $max));
	}

	public static function message( Message $message )
	{
		return static::route('message', $message->id);
	}

	public static function page( Page $page )
	{
		$title = static::encodeTitle($page->english_title, 3);

		return static::route('page', array($title, $page->id));
	}

	public static function deleteImage( Image $image )
	{
		return static::route('delete-image', $image->id);
	}

	public static function image( Image $image )
	{
		return static::route('show-image', $image->id);
	}

	public static function family( Family $family )
	{
		return static::route('family-members', $family->id);
	}

	public static function event( Event $event )
	{
		return static::route('event', $event->id);
	}

	public static function job( Job $job )
	{
		return static::route('job', $job->id);
	}




	public static function showGalleries( Gallery $gallery )
	{
		return static::route('show-galleries', $gallery->id);
	}

	public static function requestGallery( Gallery $gallery )
	{
		return static::route('request-gallery', $gallery->id);
	}
	
	public static function addImage( Gallery $gallery )
	{
		return static::route('add-image', $gallery->id);
	}

	public static function gallery( Gallery $gallery )
	{
		return static::route('gallery', $gallery->id);
	}





	public static function userGallery( MemberInterface $user )
	{
		if($user instanceof User) return static::route('user-gallery', $user->id);
		else                      return static::route('admin-profile');
	}

	public static function sendMessageTo( MemberInterface $user )
	{
		if($user instanceof User) return static::route('send-message-to', $user->id);
		else                      return static::route('contact-us');
	}

    public static function profile( MemberInterface $user )
    {
        if($user instanceof User) return static::route('profile', $user->id);
        else                      return static::route('admin-profile');
    }

	public static function userEvents( MemberInterface $user )
	{
		if($user instanceof User) return static::route('user-events', $user->id);
		else                      return static::route('admin-profile');
	}

	public static function userJobs( MemberInterface $user )
	{
		if($user instanceof User) return static::route('user-jobs', $user->id);
		else                      return static::route('admin-profile');
	}

}