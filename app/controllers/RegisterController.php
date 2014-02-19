<?php

use Website\Place\Place;
use Address\City\City;
use Gallery\Version\Version;

use Membership\Family\Family;
use Membership\User\User;
use Membership\User\UserValidator;
use Membership\Family\FamilyValidator;


class RegisterController extends BaseController{

	protected $errors = array();

	/**
	 * Register view.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$postRegister = URL::action('RegisterController@postIndex');

		$cities = City::root();

		$families = Family::getAccepted();

        $random = array(rand(1, 10), rand(1, 10));

        Session::put('random_1', $random[0]);
        Session::put('random_2', $random[1]);

		return View::make('register.index', compact('postRegister', 'cities', 'families', 'random'));
	}

	/**
	 * Registering user.
	 *
	 * @return Response
	 */
	public function postIndex()
	{
		// Get Register inputs
		$userInputs = Input::get('Register', array());

		// Step1: First we check result for spamCheck
		$this->spamCheck(Input::get('Register.spam-check'));

		// Step2: Check for correct age
		$this->checkCorrectAge( $userInputs );

		// Step3: Check for correct family
		$this->checkFamily(Input::get('Family'));

		// Step4: validate image
		$this->validateImage(Input::file('Register[image]'));

		// Step5: Check for correct address and get city
		$city = $this->checkAndGetCity(Input::get('Address'));

		// Step6: Filter and validate userInputs
		$this->validate( $userInputs );

		// Failed in one or more validation steps 
		if(! empty($this->errors)) {

			return Redirect::action('RegisterController@getIndex')->withInput()->with('errors', $this->errors);
		}
		// He passed all validation steps, Whew!
		else {

			// Create new user
			$user = new User( $userInputs );

			// Set the password for this user.
			$user->password = Auth::hash( $userInputs['password'] );

			// Create user in this family
			$this->getFamily(Input::get('Family'))->users()->save($user);

			// Attach user to this city
			$city->users()->save( $user );

			// Upload profile image
			$this->uploadProfile( $user, Input::file('Register[image]')->getRealPath() );

			// Send registeration mail to user
			$this->sendMail( $user );

            return $this->afterRegistration($user);
		}
	}

    /**
     * @param User $user
     */
    protected function afterRegistration(User $user)
    {
        $id = array(
            'key' => 'YIHUKJDAJX2r$#ewscs',
            'value' => Crypt::encrypt($user->id)
        );

        return View::make('register.join_arrabah', compact('id'));
    }

    /**
     * @return mixed
     */
    public function postJoinArrabah()
    {
        $id = Crypt::decrypt(Input::get('YIHUKJDAJX2r$#ewscs'));

        $user = User::find($id);
        $user->from_arrabah = Input::get('Register.from_arrabah') == 'true' ? 1 : 0;
        $user->save();

        // Create messenger to send to user
        with(new Messenger('لقد قمت بالتسجيل بنجاح', 'برجاء تفقد الإيميل الخاص بك.'))->flash();

        // Redirect to message to user page.
        return Redirect::route('message-to-user');
    }
	
	/**
	 * Retrive family.
	 *
	 * @param  array $inputs
	 * @return Family
	 */
	private function getFamily( $inputs )
	{

		// Either get it by id or name
		if(($family = Family::find($inputs['id'])) || ($family = Family::getByName($inputs['name'])))

			return $family;

		// Else then create a new family and return it
		else

			return Family::create(array('name' => $inputs['name']));
	}	

	/**
	 * Upload profile image.
	 *
	 * @param  User   $user
	 * @param  string $source
	 * @return void
	 */
	private function uploadProfile( User $user, $source )
	{
		// Configuration.
		$config = Config::get('images.user.profile');

		// Image uploader used to upload this image.
		$user->uploadProfile(AlbumsManager::getVersions($config, $source, array('user' => $user->id)));
	}

	/**
	 * Validation step1.
	 *
	 * @param  array $input
	 * @return void
	 */
	private function spamCheck( $input )
	{
        if((Session::get('random_1') + Session::get('random_2')) != $input)
        {
			$this->errors[] = 'إجابة سؤال التأكيد غير صحيحة.';
        }

        Session::forget('random_1');
        Session::forget('random_2');


//		if( !Captcha::validate( $input )) {
//
//			$this->errors[] = 'إجابة سؤال التأكيد غير صحيحة.';
//		}
	}

	/**
	 * Validation step2.
	 *
	 * @param  array $inputs
	 * @return void
	 */
	private function checkCorrectAge( &$inputs )
	{
		// Check if user chosed age
		if(! isset($inputs['age']))

			$this->errors[] = 'عليك بإختيار العمر.';

		else {
			// Set date of inputs
			$inputs['day_of_birth'] = EasyDate::sql($inputs['day_of_birth']);

			// Calculate age from date
			$age = EasyDate::calculateAge(new Datetime($inputs['day_of_birth']));

			// Check if the answer he have chose for age is correct
			if($age->y < 18 && $inputs['age'] != 'below') {

				$this->errors[] = 'عمرك ليس متطابق مع الإختيار الذى قمت بإختياره.';

			}else if($age->y > 18 && $inputs['age'] != 'above') {

				$this->errors[] = 'عمرك ليس متطابق مع الإختيار الذى قمت بإختياره.';
			}

			// Set age_days
			$inputs['age_days'] = $age->days;
		}
	}

	/**
	 * Validation step3.
	 *
	 * @param  array $inputs
	 * @return Family|null
	 */
	private function checkFamily( $inputs )
	{
		$family = Family::find($inputs['id']);

		if(!$family && !$inputs['name'])
		{
			$this->errors[] = 'يجب إختيار العائلة او إدخال عائلة جديدة.';
		}
	}

	/**
	 * Validating iamge
	 *
	 * @return void
	 */
	private function validateImage( $image )
	{
		if(! AlbumsManager::validate( $image ))
			
			$this->errors[] = 'يجب إختيار صورة صحيحة.';
	}

	/**
	 * Validation step4.
	 *
	 * @param  array $inputs
	 * @return null|City
	 */
	private function checkAndGetCity( $inputs )
	{
		$country = City::find(isset($inputs['country'])? $inputs['country'] : 0);
		$city    = City::find(isset($inputs['city'])? $inputs['city'] : 0);
		$region  = City::find(isset($inputs['region'])?$inputs['region']: 0);

		if(! $country || !$city)
		
			$this->errors[] = 'يجب إختيار العنوان (الدولة والمدينة).';

		else
	
			return $region ? $region : $city;
	}

	/**
	 * Validation step5.
	 *
	 * @param  array $inputs
	 * @return void
	 */
	private function validate( & $inputs )
	{
		if(isset($inputs['from_arrabah'])) {

			$inputs['from_arrabah'] = $inputs['from_arrabah'] == 'true' ? 1 : 0;
		}else {

            $inputs['from_arrabah'] = 0;
        }

		$inputs = UserValidator::filter( $inputs );

		$validator = UserValidator::validate( $inputs );
		
		// If validation fails then redirect with errors
		if($validator->fails()) {

			$this->errors = array_merge($validator->messages()->all(':message'), $this->errors);
		}
	}


	/**
	 * Send email to user
	 *
	 * @param  User $user
	 * @return void
	 */
	private function sendMail( $user )
	{
		$place = Place::getByIdentifier('register_email');

		if($place->hasAttached())
		{
			$data = array('content' => $place->placeable);

			$userEmail = $user->email;
			$userName  = $user->getTwoName();

			$callback = function($message) use($userEmail, $userName)
			{
			    $message->to($userEmail, $userName)->subject('رسالة من إدارة موقع عرابة.');
			};

			Mail::send('emails.auth.register', $data, $callback);
		}
	}

}