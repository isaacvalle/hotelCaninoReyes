<?php
/**
 * Created by PhpStorm.
 * User: jmtapiag
 * Date: 06/02/2019
 * Time: 06:20 PM
 */

namespace App\Helpers;

use App\Models\Response;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;

use App\Models\User;

class UserValidator
{
    private $response;
    private $userRepository;

    public function __construct(Response $response, UserRepository $userRepository)
    {
        $this->response = $response;
        $this->userRepository = $userRepository;
    }

    /**
     * This function verify if the user in the request exists.
     *
     *
     * @param  int $user_id
     * @return \App\Models\Response $response
     */
    public function exists( $user_id ) {

        Log::info('Validating if id: '.$user_id.' user exists.');

        if (User::find($user_id)) {
           $this->response->setOk(true);
        } else {
            $this->response->setOk(false);
            $this->response->setMessage('User received does not exists.');
            $this->response->setStatusCode(404);
        }

        return $this->response;
    }

    /**
     * Function to validate the process to create a new User.
     *
     * @param $user_id
     * @return Response
     */
    public function create($user_id)
    {
        Log::info('Validator - Performing validation to create a User.');

        $user = User::find($user_id);

        if($user->hasRole('admin')) {
            Log::info('Validator - User who is sending the request has admin role.');
            $this->response->setOk(true);
        } else {
            Log::info('Validator - User who is sending the request has not admin role.');
            $this->response->setOk(false);
            $this->response->setMessage('Could not create this user. Details: User who is sending the request has not admin role.');
            $this->response->setStatusCode(401);
        }

        return $this->response;
    }

    public function index($user_id)
    {
        Log::info('Validator - Performing validation to index users.');

        $user = $this->userRepository->get_by_id($user_id)->getData();
        if($user->hasRole('admin')) {
            Log::info('Validator - User who is sending the request has admin role.');
            $this->response->setOk(true);
        } else {
            Log::info('Validator - User who is sending the request has not admin role.');
            $this->response->setOk(false);
            $this->response->setMessage('Could not index users. Details: User who is sending the request has not admin role.');
            $this->response->setStatusCode(401);
        }

        return $this->response;
    }
}