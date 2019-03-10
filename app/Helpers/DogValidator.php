<?php
/**
 * Created by PhpStorm.
 * User: jmtapiag
 * Date: 06/02/2019
 * Time: 05:59 PM
 */

namespace App\Helpers;

use App\Models\Dog;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Response;
use App\Repositories\DogRepository;
use App\Service\UserService;
use Illuminate\Support\Facades\Log;

class DogValidator
{
    /** @var Response */
    private $response;

    /** @var UserService */
    private $userService;

    /** @var DogRepository */
    private $dogRepository;

    /**
     * DogValidator constructor.
     * @param Response $response
     * @param UserService $userService
     * @param DogRepository $dogRepository
     * @param ReservationValidator $reservationValidator
     */
    public function __construct(
        Response $response,
        UserService $userService,
        DogRepository $dogRepository
    ) {
        $this->response = $response;
        $this->userService = $userService;
        $this->dogRepository = $dogRepository;
    }

    /**
     * This function verify if the dog in the request exists.
     *
     *
     * @param $dog_id
     * @return \App\Models\Response $response
     */
    public function exists( $dog_id ) {

        Log::info('Validating if id: '.$dog_id.' dog exists.');

        if (Dog::find( $dog_id )) {
            $this->response->setOk(true);
        } else {
            $this->response->setOk(false);
            $this->response->setMessage('Could not create this reservation. Details: Dog received does not exists.');
            $this->response->setStatusCode(404);
        }

        return $this->response;
    }

    /**
     * This function verify if the dog in the request belongs to the user.
     *
     * @param  $user_id
     * @param  $dog_id
     * @return bool
     */
    public static function dog_belongs_user( $user_id, $dog_id ) {

        Log::info('Validating if id: '.$dog_id.' dog belongs to id: '.$user_id.' user.');

        $user_dogs = User::find($user_id);

        return $user_dogs->dogs->contains($dog_id) ? true : false;
    }

    /**
     * Get the dog size id.
     *
     * @param $dog_id
     * @return int
     */
    public function get_size_id( $dog_id ) {
        Log::info('Getting the id size from dog id: '.$dog_id);

        $dog = Dog::with('size:id,name')->find($dog_id);

        return !$dog ? $dog->size->id : null;
    }

    /**
     * Function to update a Dog
     *
     * @param $dog_id
     * @param $user_id
     * @return Response
     */
    public function update( $dog_id, $user_id )
    {
        Log::info('Validator - Validating request to update dog...');
        $exists = $this->exists($dog_id);
        if(!$exists->getOk()) {
            return $exists;
        }

        if($this->dog_has_active_reservation($dog_id)->getOk()) {
            $this->response->setOk(false);
            $this->response->setMessage('This dog can not be updated because has an active reservation.');
            $this->response->setStatusCode(401);

            return $this->response;
        }

        if ($this->dogRepository->get_by_id($dog_id)->getData()->user_id != $user_id){
            $user = $this->userService->get_by_id($user_id)->getData();
            if (!$user->hasRole('admin')) {
                $this->response->setMessage('This dog does not belong to this user');
                $this->response->setStatusCode(401);
                $this->response->setOk(false);
            } else {
                $this->response->setOk(true);
            }
        }

        return $this->response;
    }

    /**
     * Function to delete a Dog just for Admin role
     *
     * @param $dog_id
     * @return Response
     */
    public function delete($dog_id)
    {
        Log::info('Validator - Validating request to delete dog...');

        $exists = $this->exists($dog_id);
        if(!$exists->getOk()) {
            return $exists;
        }

        if($this->dog_has_active_reservation($dog_id)->getOk()) {
            $this->response->setOk(false);
            $this->response->setMessage('This dog can not be deleted because has an active reservation.');
            $this->response->setStatusCode(401);

            return $this->response;
        }

        $this->response->setOk(true);
        return $this->response;
    }

    /*
     * To check if dog has an active reservation.
     */
    private function dog_has_active_reservation($dog_id)
    {
        Log::info('Dog Validator - Checking if dog has an active reservation.');

        $reservations = Reservation::where('dog_id', '=', $dog_id)->
                                     where('status_id', '<=', 6)->
                                     orWhere('status_id', '=', 9)->get();
        Log::debug('Dog has active: '.$reservations);

        if(sizeof($reservations) > 0){
            Log::info('Dog Validator - This dog has an active reservation.');
            $this->response->setOk(true);
        } else {
            Log::info('Dog Validator - This dog has not an active reservation.');
            $this->response->setOk(false);
        }

        return  $this->response;
    }
}