<?php

use LaravelDuo\LaravelDuo;

class HomeController extends BaseController {

    private $_laravelDuo;

    function __construct(LaravelDuo $laravelDuo)
    {
        $this->_laravelDuo = $laravelDuo;
    }

    /**
     * Stage One - The Login form
     */
    public function getIndex()
    {
        return View::make('pages.login');
    }

    /**
     * Stage Two - The Duo Auth form
     */
    public function postSignin()
    {
        $user = array(
            'email' => Input::get('email'),
            'password' => Input::get('password')
        );

        /**
         * Validate the user details, but don't log the user in
         */
        if(Auth::validate($user))
        {
            $U    = Input::get('email');

            $duoinfo = array(
                'HOST' => $this->_laravelDuo->get_host(),
                'POST' => URL::to('/') . '/duologin',
                'USER' => $U,
                'SIG'  => $this->_laravelDuo->signRequest($this->_laravelDuo->get_ikey(), $this->_laravelDuo->get_skey(), $this->_laravelDuo->get_akey(), $U)
            );

            return View::make('pages.duologin')->with(compact('duoinfo'));
        }
        else
        {
            return Redirect::to('/')->with('message', 'Your username and/or password was incorrect')->withInput();
        }

    }

    /**
     * Stage Three - After Duo Auth Form
     */
    public function postDuologin()
    {
        /**
         * Sent back from Duo
         */
        $response = $_POST['sig_response'];

        $U = $this->_laravelDuo->verifyResponse($this->_laravelDuo->get_ikey(), $this->_laravelDuo->get_skey(), $this->_laravelDuo->get_akey(), $response);

        /**
         * Duo response returns USER field from Stage Two
         */
        if($U){

            /**
             * Get the id of the authenticated user from their email address
             */
            $id = User::getIdFromEmail($U);

            /**
             * Log the user in by their ID
             */
            Auth::loginUsingId($id);

            /**
             * Check Auth worked, redirect to homepage if so
             */
            if(Auth::check())
            {
                return Redirect::to('/')->with('message', 'You have successfully logged in');
            }
        }

        /**
         * Otherwise, Auth failed, redirect to homepage with message
         */
        return Redirect::to('/')->with('message', 'Unable to authenticate you.');

    }

    /**
     * Log user out
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/')->with('message', 'You have successfully logged out');
    }


}