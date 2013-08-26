<?php

use Gallery\Version\Version;
use Membership\User\User;

use Social\Event\Event;
use Social\EventTitle\EventTitle;
use Social\Event\EventValidator;

class EventController extends BaseController {


	protected $errors = array();

	public function __construct()
	{
        $this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function index()
	{
		return View::make('events.index')->with('events', Event::getAccepted(Event::latest())->paginate( 10 ))
										 ->with('eventTitle', 'مناسبات وأحداث');
	}

	public function show( $id )
	{
		$event = Event::findOrFail( $id );

		$event->failIfNotAccepted();

		return View::make('events.one')->with('event', $event);
	}

	public function user( $id )
	{
		$user = User::findOrFail( $id );

		$user->failIfNotAccepted();

		return View::make('events.index')->with('events', Event::getAccepted(Event::latestByUser($user))->paginate( 10 ))
										 ->with('eventTitle', $user->getTwoName())
										 ->with('profileUser', $user)
										 ->with('eventTitles', EventTitle::all());
	}

	public function create()
	{

		$user = $this->validateUser();

		$inputs = $this->validate(Input::get('Event', array()));

		$this->validateMainImage(Input::file('main-image'));

		// If there are some errors
		if(! empty($this->errors)) {

			if(BrainyResponse::ajax()) return Response::json(array('message' => 'errors', 'body' => $this->errors));	
			else                	   return Redirect::back()->with('errors', $this->errors);
		}

		// No errors occured in validation steps.
		// Now we can create new event
		$event = $this->saveEvent($inputs);

		// Upload main image to this event
		$this->uploadMainImage(Input::file('main-image'), $event);

		// Upload gallery to this event
		$this->uploadGallery(Input::file('gallery-images'), $event);


		$successBody = 'لقد تم إضافة مناسبة بنجاح. وبإنتظار قبولها من الإدارة فى أقرب وقت.';
		
		if(BrainyResponse::ajax()) return Response::json(array('message' => 'success', 'body' => $successBody));
		else                	   return Redirect::back()->with('success', $successBody);
	}



	private function validate(array $inputs)
	{
		$inputs = EventValidator::filter($inputs);

		$validator = EventValidator::validate($inputs);

		if($validator->fails()) {

			$this->errors = array_merge($validator->messages()->all(':message'), $this->errors);
		}

		return $inputs;
	}


	private function validateUser()
	{
		if(! $user = Auth::user())

			$this->errors[] = 'ليس لديك سماحية.';

		$user->failIfNotAccepted();

		return $user;
	}


	private function validateMainImage( $image )
	{
		if(! AlbumsManager::validate($image))

			$this->errors[] = 'يجب إدخال صورة صحيحة.';
	}



	private function saveEvent($inputs)
	{
		$inputs['date_of_event'] = EasyDate::sql($inputs['date_of_event']);

		// Create event
		return Event::create($inputs);
	}



	private function uploadMainImage( $image, $event )
	{
		$config = Config::get('images.event.main');

		$versions = AlbumsManager::getVersions($config, $image->getRealPath(), array('event' => $event->id));

		$event->uploadImage( $versions )->accept();
	}



	private function uploadGallery( $inputImages, $event )
	{
		$inputImages = (array) $inputImages;

		if(empty( $inputImages )) return;

		$config = Config::get('images.gallery.image');

		// Create new gallery
		$gallery = $event->gallery()->create(array(
			'title' => $event->title,
			'description' => $event->description
		));

		// Loop through all images and add them to gallery
		foreach ($inputImages as $inputImage)
		{
			if(! AlbumsManager::validate($inputImage)) continue;

			$image = $gallery->images()->create(array(

				'title'       => $gallery->title,
				'description' => $gallery->description

			));

			// Get versions for this configuration
			$versions = AlbumsManager::getVersions($config, $inputImage->getRealPath(), array(

				'gallery' => $gallery->id,
				'image'   => $image->id
			));

			// Create new image and upload versions
			$image->upload( $versions )->accept();
		}
	}
}