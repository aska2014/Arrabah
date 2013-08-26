<?php

use Voting\Question\Question;
use Voting\Answer\Answer;

class QuestionAnswerSeeder extends Seeder {

	public function run()
	{
		DB::table('questions')->delete();
		DB::table('answers')->delete();

		$question = Question::create(array(

			'title' => 'ما رأيك فى تصميم موقع عرابة'

		));

		$question->answers()->save(new Answer(array(
			'title' => 'ممتاز'
		)));

		$question->answers()->save(new Answer(array(
			'title' => 'جيد جداً'
		)));

		$question->answers()->save(new Answer(array(
			'title' => 'متوسط'
		)));



		$question = Question::create(array(

			'title' => 'سؤال أخر'

		));

		$question->answers()->save(new Answer(array(
			'title' => 'شيسبشيسب'
		)));

		$question->answers()->save(new Answer(array(
			'title' => 'ؤرئءرئءؤ'
		)));

		$question->answers()->save(new Answer(array(
			'title' => 'قثلب'
		)));

		$this->command->info('Questions and answers seeded');
	}

}