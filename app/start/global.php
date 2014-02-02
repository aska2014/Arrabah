<?php

use Symfony\Component\HttpKernel\Exception\HttpException;

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/libraries',

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
    $data = array(
        'errorTitle' => $exception->getMessage(),
        'errorDescription' => 'In file:' . $exception->getFile() . ', In line:'.$exception->getLine(),
        'errorPage' => Request::url()
    );

    Mail::send('emails.error', $data, function($message)
    {
        $message->to('kareem3d.a@gmail.com', 'Kareem Mohamed')->subject('Error from arrabah');
    });
});

/*
|--------------------------------------------------------------------------
| HTTP Exception handler
|--------------------------------------------------------------------------
|
| This will handle not authenticated exceptions that occur in the application.
|
*/

App::error(function(HttpException $exception)
{
	$errors = 'يجب عليكم التسجيل اولاً او الدخول لحسابك الشخصى.';

	if(Request::ajax()) 

		return Response::json(array(
		
			'message' => 'error', 
			'body' => $errors

		));

	return Redirect::action('LoginController@getIndex')->with('errors', $errors);
});

/*
|--------------------------------------------------------------------------
| HTTP Exception handler
|--------------------------------------------------------------------------
|
| This will handle not authenticated exceptions that occur in the application.
|
*/

App::error(function(NotAcceptedException $exception)
{
	with(new Messenger('خطأ', 'لم يتم القبول من الإدارة بعد'))->flash();

	return Redirect::route('message-to-user');
});



App::error(function(\Illuminate\Database\Eloquent\ModelNotFoundException $exception)
{
    return Redirect::route('home');
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
    return Response::view('errors.maintenance', array(), 503);
});

/*
|--------------------------------------------------------------------------
| Handling not found pages
|--------------------------------------------------------------------------
| 
| Handling any not found requests...
|
*/

App::missing(function($exception)
{
    return Response::view('errors.missing', array(), 404);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';


if(! App::runningInConsole())
{

	/*
	|--------------------------------------------------------------------------
	| Require The Composers file
	|--------------------------------------------------------------------------
	|
	| Composers file contain all view composers which should contain assets each
	| view needs, ... etc
	|
	*/

	require app_path().'/composers.php';

	/*
	|--------------------------------------------------------------------------
	| Require Helpers file
	|--------------------------------------------------------------------------
	|
	| Get function helpers file.
	|
	*/

	require app_path().'/libraries/helpers.php';

	/*
	|--------------------------------------------------------------------------
	| Require Observers file
	|--------------------------------------------------------------------------
	|
	| Get models observers.
	|
	*/

	require app_path().'/observers.php';


	/*
	|--------------------------------------------------------------------------
	| Set base url for the path helper
	|--------------------------------------------------------------------------
	|
	| Get function helpers file.
	|
	*/

	Path::setBase(URL::to(''), public_path());
		
}