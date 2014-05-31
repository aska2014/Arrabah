<?php

use Social\Comment\Comment;
use Social\Comment\CommentValidator;

class CommentController extends BaseController {

    protected $errors = array();

    public function create()
    {
        $user = $this->validateUser();

        $inputs = $this->validate(array('description' => Input::get('Comment.description')));

        $comment = new Comment($inputs);

        $model = $this->createModel();

        // If there are some errors
        if(! empty($this->errors)) {

            if(BrainyResponse::ajax()) return Response::json(array('message' => 'errors', 'body' => $this->errors));
            else                	   return Redirect::back()->with('errors', $this->errors);
        }

        $comment->user_id = $user->id;

        $model->comments()->save($comment);

        $successBody = 'لقد تم إضافة التعليق بنجاح';

        if(BrainyResponse::ajax()) return Response::json(array('message' => 'success', 'body' => $successBody));
        else                	   return Redirect::back()->with('success', $successBody);
    }


    private function createModel()
    {
        $class = Crypt::decrypt(Input::get('Comment.c_type'));
        $id    = Crypt::decrypt(Input::get('Comment.c_id'));

        if(class_exists($class)) {

            return $class::find($id);
        }

        $this->errors[] = 'حدث خطا اثناء حفظ التعليق.';
    }



    private function validate(array $inputs)
    {
        $inputs = CommentValidator::filter($inputs);

        $validator = CommentValidator::validate($inputs);

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
} 