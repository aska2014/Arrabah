<?php

use Social\Job\Job;
use Social\Job\JobValidator;

use Gallery\Version\Version;

use Membership\User\User;

class JobController extends BaseController {


	public function __construct()
	{
        $this->beforeFilter('csrf', array('on' => 'post'));
	}


    public function apply( $id )
    {
        $job = Job::findOrFail( $id );

        $job->failIfNotAccepted();

        return View::make('jobs.apply')->with('job', $job);
    }


	public function index()
	{
		return View::make('jobs.index')->with('jobs', Job::getAccepted(Job::latest())->paginate(10))
									   ->with('jobTitle', 'الوظائف');
	}


	public function show( $id )
	{
		$job = Job::findOrFail( $id );

		$job->failIfNotAccepted();

		return View::make('jobs.one')->with('job', $job);
	}

	public function user( $id )
	{
		$user = User::findOrFail( $id );

		$user->failIfNotAccepted();

		return View::make('jobs.index')->with('jobs', Job::getAccepted(Job::latestByUser($user))->paginate( 10 ))
										 ->with('jobTitle', $user->getTwoName())
										 ->with('profileUser', $user);
	}

	public function create()
	{
		$inputs = JobValidator::filter(Input::get('Job'));

		$validator = JobValidator::validate($inputs);

		if($validator->fails()) {

			return Redirect::back()->withInput()->with('errors', $validator->messages()->all(':message'));
		}

		if(! $user = Auth::user()) {

			return Redirect::back()->withInput()->with('errors', 'ليس لديك سماحية.');
		}

		$user->failIfNotAccepted();

		// Create job
		$job = $user->jobs()->create($inputs);

		// Upload image for job
		$this->uploadImage($job, Input::file('Job[image]'));

		// Redirect to message to user page.
		return Redirect::back()->with('success', 'لقد تم إضافة وظيفة بنجاح. وبإنتظار موافقة الإدارة عليها فى أقرب وقت.');
	}

	private function uploadImage( $job, $inputImage )
	{
		if(AlbumsManager::validate( $inputImage )) {

			// Configuration.
			$config = Config::get('images.job.main');

			// Image uploader used to upload this image.
			$job->uploadImage(AlbumsManager::getVersions($config, $inputImage->getRealPath(), array('job' => $job->id)));

		}
	}
}