<?php namespace Membership\User;

use ValidatorInterface, Validator;

class UserValidator implements ValidatorInterface {

	/**
	 * Filter inputs.
	 *
	 * @return array
	 */
	public static function filter( array $inputs )
	{
		return static::stripTags(\array_get_keys($inputs, array(
			'username', 'first_name', 'father_name', 'grand_father_name', 'email', 'password', 
			'age_days', 'day_of_birth', 'place_of_birth', 'telephone_no', 'sex', 'from_arrabah',
            'branch_name'
		)));
	}

	private static function stripTags( $inputs )
	{
		array_walk($inputs, function( &$input )
		{
			$input = strip_tags($input);
		});

		return $inputs;
	}

	/**
	 * Validate inputs.
	 *
	 * @return Validator
	 */
	public static function validate( array $inputs )
	{
		return Validator::make($inputs, array(

			'username'          => 'required|unique:users|min:6',
			'first_name'        => 'required',
			'father_name'       => 'required',
            'grand_father_name' => 'required',
            'branch_name'       => 'required',
			'email'             => 'required|email|unique:users',
			'sex'               => 'required|in:male,female',
			'from_arrabah'      => 'required|in:1,0',
			'password'          => 'required',
			'age_days'          => 'required|integer',
			'day_of_birth'      => 'required|date',
			'place_of_birth'    => 'required',
			'telephone_no'      => 'required',

		),array(

			'username.required'          => 'يجب إدخال أسم المستخدم.',
			'username.unique'            => 'هذا الأسم مستخدم من قبل.',
			'username.min'               => 'أسم المستخدم يجب ان يكون على الأقل 6 أحرف.',
			'first_name.required'        => 'يجب إدخال الأسم الاول.',
			'father_name.required'       => 'يجب إدخال اسم الاب.',
			'grand_father_name.required' => 'يجب إدخال اسم الجد.',
            'branch_name.required'       => 'يجب إدخال اسم الفرع',
			'email.required'             => 'يجب إدخال الإيميل.',
			'email.email'                => 'هذا الإيميل غير صحيح.',
			'email.unique'               => 'هذا الإيميل مستخدم من قبل.',
			'sex.required'               => 'يجب إختيار الجنس.',
			'sex.in'                     => 'يجب إختيار الجنس.',
			'from_arrabah.required'      => 'يجب الإجابة على سؤال هل انت من اهالى عرابه.',
			'from_arrabah.in'            => 'يجب الإجابة على سؤال هل انت من اهالى عرابه.',
			'password.required'          => 'يجب إدخال كلمة السر.',
			'age_days.required'          => 'يجب إدخال العمر.',
			'age_days.integer'           => 'يجب إدخال العمر.',
			'day_of_birth.required'      => 'يجب إدخال تاريخ الميلاد.',
			'day_of_birth.date'          => 'يجب إدخال تاريخ الميلاد.',
			'place_of_birth.required'    => 'يجب إدخال مكان الميلاد.',
			'telephone_no.required'      => 'يجب إدخال رقم التليفون.'

		));
	}

}