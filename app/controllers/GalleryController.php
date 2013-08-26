<?php

use Membership\User\User;

use Gallery\Gallery\Gallery;
use Gallery\Gallery\Algorithm as GAlgorithm;

use Gallery\Image\Image;
use Gallery\Version\Version;

use Gallery\Gallery\GalleryValidator;
use Gallery\Image\ImageValidator;

class GalleryController extends BaseController {


	public function __construct()
	{
        $this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function all()
	{
		$galleries = GAlgorithm::hasImages(GAlgorithm::make('accepted'));

		if($galleries->isEmpty()) {
			
			with(new Messenger('مكتبة الصور خالية', 'لم يتم إضافة اى مكتبة صور بعد.'))->flash();

			return Redirect::route('message-to-user');
		}

		return View::make('galleries.galleries2', compact('galleries'));
	}


	public function requestGalleryInfo( $id, $type )
	{
		$gallery = Gallery::find( $id );

		$failed = Response::json(array('error' => true, 'body' => 'No more galleries'));

		if(! $gallery) return $failed;

		if($type == 'next') $gallery = GAlgorithm::accepted($gallery->next())->first();
		else                $gallery = GAlgorithm::accepted($gallery->previous())->first();

		if(!$gallery || !$user = $gallery->getUser()) return $failed;

		$gallery->failIfNotAccepted();

		$urls       = array();
		$imagesVars = array();

		foreach ($gallery->getExistImages( 8 ) as $image)
		{
			$urls['url'] = $image->getUrl( 145, 145 );
			$urls['link'] = URL::image($image);

			$imagesVars[] = $urls;
		}

		return Response::json(array( 
		
			'success' => true,

			'currentId' => $gallery->id,

			'gallery' => array('title' => $gallery->title, 'description' => $gallery->description),

			'user'    => array('twoName' => $user->getTwoName()),

			'images'  => $imagesVars,

			'noMore'  => $type == 'next' ? !$gallery->hasNext() : !$gallery->hasPrevious()

		));
	}


	public function showImage( $id )
	{
		$image = Image::findOrFail( $id );

		$image->failIfNotAccepted();

		return View::make('galleries.image', compact('image'));
	}


	public function replaceImage()
	{
		$file = Input::file('Profile[image]');

		if(! AlbumsManager::validate($file))

			return Redirect::back()->with('errors', 'يجب إختيار صورة صحيحة.');

		// User profile path
		$config = Config::get('images.user.profile');

		// Update versions of the authenticated user.
		Auth::user()->profileImage->replace(AlbumsManager::getVersions($config, $file->getRealPath(), array('user' => Auth::user()->id)));

		return Redirect::route('profile', Auth::user()->id);
	}

	public function deleteImage( $id )
	{
		// Delete image
		$image = Image::findOrFail( $id );

		// If image is attached to gallery and this gallery is attached to user
		// then check if this user is the same as the authenticated user then
		// now you give him the right to delete the image
		if($image->getUser()->same(Auth::user()))
		{
			$image->delete();
		}

		// Redirect to before the show-image page
		return Redirect::to(Tracker::before('show-image'));
	}

	public function galleriesShow( $id )
	{
		$firstGallery = Gallery::findOrFail( $id );

		$firstGallery->failIfNotAccepted();
		
		return View::make('galleries.galleries', compact('firstGallery'));
	}

	public function show( $id )
	{
		$gallery = Gallery::findOrFail( $id );

		$gallery->failIfNotAccepted();

		$images = $gallery->images()->paginate( 12 );

		$profileUser = $gallery->getUser();
		
		return View::make('galleries.one', compact('gallery', 'images', 'profileUser'));
	}

	public function showByUser( $id = 0 )
	{
		$profileUser = $id ? User::findOrFail($id) : Auth::user();

		$galleries   = GAlgorithm::accepted($profileUser->galleries())->get();

		return View::make('galleries.all', compact('profileUser', 'galleries'));
	}


	public function addImage( $galleryId )
	{
		// Get gallery
		$gallery  = Gallery::findOrFail( $galleryId );

		// Define redirect route..
		$redirect = Redirect::action('GalleryController@show', $gallery->id);



		// Validation: Check if gallery is owned by user
		if(! $gallery->getUser()->same(Auth::user())) {

			return BrainyResponse::backWithErrors('ليس لديك سماحية لإضافة صورة هنا.');
		}
		
		// Add images to this gallery
		$this->addImages($gallery, Input::file('gallery-images'));

		return BrainyResponse::backWithSuccess('لقد تم إضافة الصور بنجاح وبإنتظار موافقة الإدارة عليها.');
	}


	public function addGallery()
	{
		$inputs = GalleryValidator::filter( Input::get('Gallery') );

		$validator = GalleryValidator::validate( $inputs );

		if($validator->fails())

			return BrainyResponse::backWithErrors($validator->messages()->all(':message'));

		$gallery = Auth::accepted()->galleries()->create($inputs);

		$gallery->accept();

		$this->addImages($gallery, Input::file('gallery-images'));

		return BrainyResponse::backWithSuccess('لقم تم إضافة معرض الصور بنجاح وبإنتظار موافقة الإدارة على الصور.');
	}



	private function addImages( Gallery $gallery, $inputImages )
	{
		$config = Config::get('images.gallery.image');

		foreach ((array) $inputImages as $inputImage)
		{
			if(! AlbumsManager::validate( $inputImage )) continue;

			$image = $gallery->images()->create(array(

				'title' => $gallery->title,
				'description' => $gallery->description

			));

			$versions = AlbumsManager::getVersions($config, $inputImage->getRealPath(), array(

				'gallery' => $gallery->id,
				'image'   => $image->id
			));

			$image->upload( $versions );
		}
	}
}