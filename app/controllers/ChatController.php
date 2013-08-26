<?php

use Membership\Family\Family;

use Membership\User\User;
use Membership\User\Algorithm as UserAlgorithm;

use Social\Chat\Chat;
use Social\Chat\Algorithm as ChatAlgorithm;
use Social\Chat\ChatValidator;

use Website\Tracker\Tracker as Tracking;

class ChatController extends BaseController {

	public function getIndex()
	{
		Tracking::add(Auth::user(), Route::currentRouteName());

		$allUsers     = UserAlgorithm::onlineUsers(User::query(), Route::currentRouteName(), Auth::user())->get();

		$families     = Family::all();

		return View::make('chat.index', compact('families', 'allUsers'));
	}


	public function requestAllMessages()
	{
		// If he requested all tabs messages then he is online
		// then update online
		Tracking::add(Auth::user(), 'chat');

		// Get predicted inputs.
		$types          = Input::get('types', array());
		$ids            = Input::get('ids', array());
		$lastMessageIds = Input::get('lastMessageIds', array());

		$messages = array();
		$chatUsersIds = array();
		for ($i = 0; $i < count($types); $i++)
		{
			$messages[$types[$i]. '-' .$ids[$i]] = $this->getMessagesArray( $types[$i], $ids[$i], $lastMessageIds[$i] );

			if($types[$i] == 'member') {

				$chatUsersIds[] = $ids[$i];
			}
		}

		// Check if new tabs are needed to be opened
		$newTabs = ChatAlgorithm::newTabs(Chat::query(), Auth::user()->id, $chatUsersIds)->with('user')->get();

		foreach ($newTabs as $newTab)
		{
			$type = 'member';
			$id   = $newTab->user->id;

			$messages['newTabs'][] = array(

				'name' => $newTab->user->getTwoName2(),
				'type' => 'member',
				'id'   => $newTab->user->id
			);

			$messages[$type . '-' . $id] = $this->getMessagesArray( $type, $id, 0 );
		}

		return Response::json($messages);
	}

	private function getMessagesArray( $type, $id, $lastMessageId )
	{
		// Check for the type and get the query specified by this type.
		switch ($type) {
			case 'member':
				$chatQuery = ChatAlgorithm::betweenUsers(Chat::query(), $id, Auth::user()->id);
				break;

			case 'family':
				$chatQuery = ChatAlgorithm::betweenFamily(Chat::query(), $id);
				break;
			
			default:
				$chatQuery = ChatAlgorithm::betweenAll(Chat::query());
				break;
		}

		// Get where id greater than last message id and order descending.
		$chats = ChatAlgorithm::idGreaterThanAndOrder($chatQuery, $lastMessageId)->with('user')->take(30)->get();


		// Loop thourgh all chats and save the corresponding message.
		$response = array();
		$response['messages'] = array();

		$maxId = $lastMessageId;

		foreach ($chats as $chat)
		{
			$maxId = $chat->id > $maxId ? $chat->id : $maxId;

			$response['messages'][] = array(
				'name'   => $chat->user->getTwoName2(),
				'image'  => $chat->user->profileImage->getUrl(60, 60),
				'body'   => $chat->description,
				'id'     => $chat->id,
				'url'    => URL::profile($chat->user)
			);
		}

		$response['lastMessageId'] = $maxId;

		return $response;
	}


	public function requestMessages()
	{
		// Get predicted inputs.
		$type          = Input::get('type', '');
		$id            = Input::get('id', 0);
		$lastMessageId = intval(Input::get('lastMessageId', 0));

		return Response::json($this->getMessagesArray($type, $id, $lastMessageId));
	}


	public function sendChatMessage()
	{
		$inputs = ChatValidator::filter(Input::all());

		// Validate Chat message
		$validator = ChatValidator::validate($inputs);

		if($validator->fails())

			return Response::json(array('message' => 'error', 'body' => $validator->messages()->all(':message')));

		// Get id from the input
		$id = Input::get('id', 0);

		// Get authenticated user.
		$user = Auth::user();

		// Fail user if not accepted.
		$user->failIfNotAccepted();

		// Create a new chat message object.
		$chat = $user->ownedChats()->create(array('description' => $inputs['description']));

		// Check type and attach it to the model corresponding to it.
		switch (Input::get('type')) {
			case 'member':
				User::find($id)->chats()->save($chat);
				break;

			case 'family':
				Family::find($id)->chats()->save($chat);
				break;
		}

		return Response::json(array('message' => 'success', 'messageId' => $chat->id));
	}
}