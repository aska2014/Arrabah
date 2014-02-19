<?php

use Address\City\City;

class EditProfileController extends BaseController {

    protected $errors = array();

    public function getIndex()
    {
        $profileUser = Auth::user();

        $profileUser->failIfNotAccepted();

        $cities = City::root();

        $userCity = $profileUser->city->getCity()->id;

        $userCountry = $profileUser->city->getCountry()->id;

        return View::make('profile.edit', compact('profileUser', 'cities', 'userCity', 'userCountry'));
    }

    public function postIndex()
    {
        $profileUser = Auth::user();

        $profileUser->failIfNotAccepted();

        // Step5: Check for correct address and get city
        $city = $this->checkAndGetCity(Input::get('Address'));

        // Failed in one or more validation steps
        if(! empty($this->errors)) {

            return Redirect::action('EditProfileController@getIndex')->with('errors', $this->errors);
        }

        $profileUser->city_id = $city->id;
        $profileUser->place_of_birth = Input::get('Profile.place_of_birth');
        $profileUser->telephone_no = Input::get('Profile.telephone_no');

        $profileUser->save();

        return Redirect::route('profile');
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
}