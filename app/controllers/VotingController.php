<?php

use Voting\Question\Question;
use Voting\Answer\Answer;
use Voting\Vote\Vote;

class VotingController extends BaseController {


	public function __construct()
	{
        $this->beforeFilter('csrf', array('on' => 'post'));
	}


	public function vote()
	{
		$inputs = Input::get('Vote');

		$answer   = Answer::findOrFail( $inputs['answer'] );
		$question = Question::findOrFail( $inputs['question'] );
		$user     = Auth::user();

		$user->failIfNotAccepted();

		if(Vote::hasVoted( $user, $question )) 

			return BrainyResponse::backWithErrors(array('لقم قمت بالتصيت على هذا السؤال من قبل.'));

		$user->voteFor( $question, $answer );

		$jsonAnswers = array();
		foreach ($question->answers as $answer)
		{
			$jsonAnswers[] = array(
				'title' => $answer->title,
				'precentage' => $this->calculatePrecentage($answer, $question),
			);
		}

		if(Request::ajax())

			return Response::json(array('message' => 'success', 'answers' => $jsonAnswers));

		return BrainyResponse::backWithSuccess('لقد تم إرسال إجابتك.');
	}


	private function calculatePrecentage( Answer $answer, Question $question )
	{
		$questionVotes = Vote::count($question);
		$answerVotes   = Vote::count($answer);

		return $questionVotes > 0 ? ($answerVotes / $questionVotes) * 100 : 0;
	}
}