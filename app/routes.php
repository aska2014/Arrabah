<?php

use News\Rss\Rss;
use Website\Page\Page;
use Website\Place\Place;
use Website\Contact\ContactValidator;

use Social\Event\Event;

use Voting\Question\Question;
use Voting\Answer\Answer;
use Voting\Vote\Vote;

use Address\City\City;

use Membership\User\User;
use Membership\User\Algorithm as UserAlgorithm;

use Gallery\Image\Algorithm as ImageAlgorithm;

use Website\Tracker\Tracker as Tracking;


Route::get('/', array('as' => 'home', function()
{
	$homeWelcome  = Place::getByIdentifier('home_welcome');

	$movingImages = ImageAlgorithm::make('attachedToGallery', 'random')->take( 10 )->get();

	$latestEvent  = Event::getAccepted(Event::latest())->first();
	$question     = Auth::user() ? Question::notVotedBy(Auth::user())->first() : Question::latest( 1 )->first();
	$arrabahUsers = UserAlgorithm::make('arrabah', 'accepted')->get();

	return View::make('home.index', compact('homeWelcome', 'movingImages', 'latestEvent', 'question', 'arrabahUsers'));
}));


Route::get('/introduction.html', array('as' => 'introduction', function()
{
    return View::make('introduction.index');
}));


Route::myController(array(

    'search.members' => array('search-members.html', 'SearchController@members'),
    'search.jobs' => array('search-jobs.html', 'SearchController@jobs'),
));


Route::post('/join-arrabah.html', array('as' => 'join-arrabah.post', 'uses' => 'RegisterController@postJoinArrabah'));


Route::group(array('before' => 'normalUser'), function()
{
    Route::post('add-comment', array('as' => 'comment.create', 'uses' => 'CommentController@create'));

	Route::myController(array(

		'update-online'    => array('update-online/{route}', 'OnlineController@updateOnline'),
		'get-online-users' => array('get-online-users/{route}', 'OnlineController@getOnlineUsers'),

	));


	Route::get('profile/{id?}', array('as' => 'profile', function( $id = 0 )
	{
		$user = $id ? User::findorFail($id) : Auth::user();

		$user->failIfNotAccepted();

		return View::make('profile.index')->with('profileUser', $user);
	}))->where('id', '[0-9]+');


    Route::myController(array(
        'profile.edit' => array('edit-profile.html', 'EditProfileController@getIndex,postIndex')
    ));

	Route::get('logout.html', array('as' => 'logout', function()
	{
		Auth::logout();

		return Redirect::route('home');
	}));

	Route::post('vote.html', array('as' => 'vote', 'uses' => 'VotingController@vote'));


	Route::myController(array(

		'user-gallery' => array('user{id?}-gallery.html', 'GalleryController@showByUser'),
		'add-gallery'  => array('add-new-gallery.html'  , 'GalleryController@addGallery', 'post'),
		'gallery'      => array('gallery-{id}.html'     , 'GalleryController@show'),
		'add-image'    => array('add-new-image-in-gallery{id}.html' , 'GalleryController@addImage',  'post'),
		'show-image'   => array('show-image{id}.html', 'GalleryController@showImage'),
		'galleries'    => array('all-galleries.html', 'GalleryController@all'),
		'show-galleries'    => array('show-galleries-{id}.html', 'GalleryController@galleriesShow'),
		'request-gallery' => array('request-gallery-info/{id}/{type}', 'GalleryController@requestGalleryInfo'),
		'delete-image' => array('delete-image-{id}.html', 'GalleryController@deleteImage'),
		'replace-image' => array('replace-image.html', 'GalleryController@replaceImage', 'post'),

	));


	Route::myController(array(

		'inbox' => array('inbox-messages.html', 'MessageController@inbox'), 
		'sent'  => array('sent-messages.html', 'MessageController@sent'), 
		'compose' => array('compose-messages.html', 'MessageController@compose,save'),
		'message' => array('message-{id}.html', 'MessageController@show'),
		'send-message-to' => array('compose-message-to-{id}.html', 'MessageController@composeToUser'),

	));

	Route::get('contact-us.html', array('as' => 'contact-us', function()
	{
		return View::make('contact.index');
	}));


	Route::post('contact-us.html', function()
	{
		$inputs = ContactValidator::filter(Input::get('Contact'));

		$validator = ContactValidator::validate( $inputs );

		if($validator->fails()) {

			return Redirect::back()->withInput()->with('errors', $validator->messages()->all(':message'));
		}

		Auth::user()->contacts()->create($inputs);

		return Redirect::back()->with('success', 'لقد تم إرسال رسالتك بنجاح.');
	});



	Route::myController(array(

		'chat'                  => array('chat.html'       , 'ChatController@getIndex'),
		'request-chat-messages' => array('requestchat.ajax', 'ChatController@requestAllMessages'),
		'send-chat'             => array('sentchat.ajax'   , 'ChatController@sendChatMessage', 'post'),

	));
});





Route::group(array('before' => 'guest'), function()
{
	Route::myController(array(
		'register' => array('register.html', 'RegisterController@getIndex,postIndex')
	));

	Route::myController(array(
		'login' => array('login.html', 'LoginController@getIndex,postIndex')
	));
});



Route::get('page/{title}-{id}.html', array('as' => 'page', function( $title, $id )
{
	$page = Page::findorFail( $id );

	return View::make('page.index', compact('page'));

}))->where('title', '.*')->where('id', '[0-9]+');


Route::get('request-cities/{id}', array('as' => 'request-cities', function( $id )
{
	return City::find( $id )->children();
}));


Route::myController(array(

	'jobs' => array('jobs.html', 'JobController@index,create'),
	'user-jobs' => array('jobs-{id}.html', 'JobController@user'),
	'job' => array('job-{id}.html', 'JobController@show'),
//    'apply-job' => array('apply-job-{id}.html', 'JobController@apply')

));

Route::myController(array(

	'events'      => array('events.html', 'EventController@index,create'),
	'user-events' => array('events-{id}.html', 'EventController@user'),
	'event'       => array('event-{id}.html', 'EventController@show'),

));


Route::myController(array(

	'families'        => array('families.html', 'MemberShowController@families'),
	'family-members'  => array('family-members-{id}.html', 'MemberShowController@family'),
	'search-members'  => array('search-members.html', 'MemberShowController@search'),
	'normal-members'  => array('normal-members.html', 'MemberShowController@normalUsers'),
	'premium-members' => array('premium-members.html', 'MemberShowController@premiumUsers'),
	'arrabah-members' => array('arrabah-members.html', 'MemberShowController@arrabahUsers'),

));


Route::get('message-to-user.html', array('as' => 'message-to-user', function( )
{
	if(! Messenger::get())

		return Redirect::route('home');

	return View::make('message.user', array('messenger' => Messenger::get()));
}));


Route::get('admin-profile.html', array('as' => 'admin-profile', function()
{
	if($aboutPage = Page::getAboutPage())

		return Redirect::route('page', array($aboutPage->english_title, $aboutPage->id));
}));



Route::get('request-captcha/{rand}', array('as' => 'request-captcha', function( $ranc )
{
	$captcha = new Captcha(130, 60, 5);

	$captcha->generateImage();

	$captcha->saveSession();

}))->where('rand', '.*');









/*
|--------------------------------------------------------------------------
| Reset password system.
|--------------------------------------------------------------------------
|
| First you go the reminder view which he will only enter his email and post
| it to be emailed to him a reset link... the reset link will have a form with
| the new password for which he have to enter and then redirect back to login
| form for him to try to login with the password again.
|
*/

Route::get('password/remind', array('as' => 'reminder', function()
{
	Tracker::dontSave();
	return View::make('login.reminder');
}));

Route::post('password/remind', function()
{
    $email = trim(Input::get('Reset.email'));

    if(! $user = User::getByEmail($email))

    	return Redirect::back()->with('errors', 'هذا الإيميل غير موجود لدينا.');

    $data['token'] = $user->getToken();

	Mail::send('emails.auth.reminder', $data, function($message) use ($email)
	{
	    $message->to($email)->subject('موقع عرابة: إستعادة كلمة السر.');
	});

	with(new Messenger('تفقد الإيميل الخاص بك.', 'برجاء تفقد الإيميل الخاص بك لإكمال عملية إسترجاع كلمة السر.'))->flash();

	return Redirect::route('message-to-user');
});

Route::get('password/reset/{token}', function($token)
{
	Tracker::dontSave();
    return View::make('login.reset')->with('token', $token);

})->where('token', '.*');


Route::post('password/reset/{token}', array('as' => 'reset', function( $token )
{
	// First we check posted token and the url token.
	if(Input::get('Reset.token') != $token)

		return Redirect::route('login')->with('errors', 'لقد حدث خطأ ما.');

	// We check if repassword is equal to the password
	if(Input::get('Reset.password') != Input::get('Reset.repassword'))

		return Redirect::back()->with('errors', 'كلمة السر ليس متطابقة.');

	// Get user by email.
	$user = User::getByEmail(Input::get('Reset.email'));

	// First we validate this token
	if(! $user->validateToken( $token ))

		return Redirect::route('login')->with('errors', 'لقد حدث خطأ ما.');

	// Now we are ready to change the user password.
	$user->password = Hash::make(Input::get('Reset.password'));
	$user->save();

    return Redirect::route('login')->with('success', 'لقد تم تغيير كلمة السر بنجاح.');
}))->where('token', '.*');

/*--------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------*/

Route::get('/my-name-is-kareem/', function() {
    Artisan::call('migrate');
});