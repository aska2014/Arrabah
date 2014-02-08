<?php

use Membership\User\Algorithm as UserAlgorithm;
use Social\Job\Job;

class SearchController extends BaseController {

    /**
     * @return mixed
     */
    public function members()
    {
        if(isset($_GET['first_name'])) return $this->searchMembers();

        return View::make('search.members');
    }

    private function searchMembers()
    {
        $familyUsers = $this->filterUsers(

            UserAlgorithm::name(UserAlgorithm::query(),
                Input::get('first_name'),
                Input::get('father_name'),
                Input::get('family_name'))

        )->paginate( 12 );


        $membersTitle = 'بحث عن عضو بإسم :';

        $membersTitle .= ' ' . (Input::get('first_name') ?: '_____');
        $membersTitle .= ' ' . (Input::get('father_name') ?: '_____');
        $membersTitle .= ' ' . (Input::get('family_name') ?: '_____');

        return View::make('families.members', compact('familyUsers', 'membersTitle'));
    }

    private function filterUsers( $query )
    {
        if(Input::get('age') == 'above-18') {

            $query = UserAlgorithm::above18( $query );
        }
        elseif(Input::get('age') == 'below-18') {

            $query = UserAlgorithm::below18( $query );
        }

        return UserAlgorithm::accepted($query);
    }




    public function jobs()
    {
        if(isset($_GET['job_name'])) return $this->searchJobs();

        return View::make('search.jobs');
    }


    protected function searchJobs()
    {
        $jobs = Job::byTitle(Job::getAccepted(Job::latest()), Input::get('job_name'))->paginate(10);

        $title = 'البحث عن وظائف بإسم: '  . Input::get('job_name');

        return View::make('jobs.index')->with('jobs', $jobs)
            ->with('jobTitle', $title);
    }






}