<?php

use Social\Message\MessageValidator;
use Social\Message\Message;

use Membership\User\User;
use Membership\User\Algorithm as UserAlgorithm;

class MessageController extends BaseController {


	public function __construct()
	{
        $this->beforeFilter('csrf', array('on' => 'post'));
	}


	public function inbox()
	{
		// Get all received messages
		$tempMessages = Auth::user()->receivedMessages();

		// Save messages in another variable
		$messages = $tempMessages->paginate( 10 );

		// Make all messages seen
		Message::makeSeen( $tempMessages );

		return View::make('messages.index')->with('messages', $messages);
	}

	public function sent()
	{
		$messages = Auth::user()->sentMessages();

		return View::make('messages.index')->with('messages', $messages->paginate( 10 ));
	}

	public function compose()
	{
		$acceptedUsers = UserAlgorithm::except(UserAlgorithm::query(), Auth::user())->get();

		return View::make('messages.new', compact('acceptedUsers'));
	}

	public function composeToUser( $id )
	{
		return $this->compose()->with('sendToUserId', $id);
	}

	public function save()
	{
		$inputs    = MessageValidator::filter(Input::get('Message'));

		$validator = MessageValidator::validate( $inputs );

		if($validator->fails())

			return Redirect::route('compose')->withInput()->with('errors', $validator->messages()->all(':message'));

		if(! $to = User::find(Input::get('Message.user')))

			return Redirect::route('compose')->withInput()->with('errors', 'يجب إختيار العضو.');


		// Create new message and send it to the inputed user.
		with(new Message( $inputs ))->send(Auth::user(), $to);

		return Redirect::route('compose')->with('success', 'لقد تم إرسال الرسالة بنجاح.');
	}

	public function show( $id )
	{
		$message = Message::findOrFail( $id );

		return View::make('messages.one', compact('message'));
	}
}