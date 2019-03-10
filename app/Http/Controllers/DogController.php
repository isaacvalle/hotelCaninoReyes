<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDog;
use App\Http\Requests\UpdateDog;
use App\Service\DogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
/**
 * @description  This class is the API entry point, this handle all services
 *               related to 'dogs' like insert a new dog, index dogs or
 *               get a specific one by id, delete one dog by id and update it 
 *               as well. All requests are validated before perform some action.
 *
 * @author Ing. Manuel Tapia - @manuel_30749
 * @since  2018/12
 */
class DogController extends Controller
{
    /** @var $dogService */
    private $dogService;

    /**
     * DogController constructor.
     * @param DogService $dogService
     */
    public function __construct(DogService $dogService)
    {
        $this->dogService = $dogService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        //to paginate the results
        //$dog = Dog::paginate(9);

        Log::info('Controller - dog index endpoint has been called.');
        $response = $this->dogService->index($request->user()->id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDog $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDog $request)
    {
        Log::info('Controller - dog store endpoint has been called.');
        $response = $this->dogService->store($request->all(), $request->user()->id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $dog_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $dog_id)
    {
        Log::info('Controller - dog store endpoint has been called.');
        $response = $this->dogService->show($request->user()->id, $dog_id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDog $request
     * @param $dog_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDog $request, $dog_id)
    {

        Log::info('Controller - dog update endpoint has been called.');
        $response = $this->dogService->update($request->all(), $dog_id, $request->user()->id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $dog_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($dog_id)
    {
        Log::info('Controller - dog destroy endpoint has been called.');
        Log::debug('dog id to delete: '.$dog_id);

        $response = $this->dogService->delete($dog_id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());
    }
}
