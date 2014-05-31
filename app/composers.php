<?php

use Membership\User\Algorithm;
use Social\Event\Event;
use Social\Message\Message;

use Website\Place\Place;
use Website\Page\Page;
use Website\Link\Link;

use Gallery\Image\Algorithm as ImageAlgorithm;


View::share('authUser', Auth::accepted());
View::share('allLinks', Link::all());


View::composer(array('master.header', 'master.footer'), function( $view )
{
	$view->aboutPage = Page::getAboutPage();

	$view->newMessages = Auth::user() ? Message::countNotSeenMessages(Auth::user()) : 0;

	$view->headerSocials = array('facebook', 'twitter', 'linkedin', 'youtube');

    $view->userCount = Algorithm::accepted(Algorithm::query())->count();

    Asset::addPlugin('cookie');
});

View::composer('master.rightpanel', function( $view )
{
	$view->sliderEvents = Event::getAccepted(Event::latest( 4 ))->get();
	$view->movingImages = ImageAlgorithm::make('attachedToGallery', 'random')->take( 10 )->get();
});



View::composer('home.index', function( $view )
{
	Asset::addPlugins(array('form', 'blackwhite'));
});


View::composer('premium.banner', function( $view )
{
	$view->premiumPlace = Place::getByIdentifier('be_premium');
});




View::composer(array('profile.edit','register.index', 'jobs.apply'), function( $view )
{
	Asset::addPage('form');
	
	Asset::addPlugins(array('picker', 'select2'));
});

View::composer(array('login.index', 'login.reminder', 'login.reset', 'search.members', 'search.jobs', 'register.join_arrabah'), function( $view )
{
	Asset::addPage('form');
});




View::composer('contact.index', function( $view )
{
	Asset::addPage('form');

	Asset::addPlugins(array('select2'));
});



View::composer('profile.index', function( $view )
{
});




View::composer(array('events.index', 'jobs.index'), function( $view )
{
	Asset::addPage('form');

	Asset::addPlugins(array('picker', 'form'));
});

View::composer(array('events.one'), function($view)
{
	Asset::addPage('galleries');
	Asset::addPlugin('isotope');
});








View::composer(array('galleries.one', 'galleries.all'), function( $view )
{
	Asset::addPage('form');
	Asset::addPlugin('form');
});

View::composer(array('galleries.galleries'), function( $view )
{
	Asset::addPage('galleries');
	Asset::addPlugin('isotope');
});


View::composer(array('galleries.galleries2'), function( $view )
{
});




View::composer(array('chat.index'), function( $view )
{
	Asset::addPage('chat');
	Asset::addPlugin('select2');
});






View::composer(array('messages.new'), function( $view )
{
	Asset::addPage('form');
	Asset::addPlugin('select2');
});


View::composer(array('messages.index', 'messages.one'), function( $view )
{
});






View::composer(array('families.index', 'families.members', 'families.members2', 'families.members3'), function( $view )
{
	Asset::addPlugin('select2');
});

