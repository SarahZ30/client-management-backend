<?php

namespace Modules\ClientManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Modules\ClientManagement\app\Http\Requests\AddClientRequest;
use Modules\ClientManagement\app\Http\Requests\UpdateClientRequest;
use Modules\ClientManagement\app\Repositaries\ClientInterface;

class ClientManagementController extends Controller
{
    protected $repositaryinterface;

    public function __construct(ClientInterface $interface)
    {
        $this->repositaryinterface = $interface;
    }

    // store a new client in the database
    public function storeClient(AddClientRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $response = $this->repositaryinterface->storeClient($validatedData);

            // return response in json
            return response()->json(
                [
                    'data' => $response,
                    'message' => 'SuccessFully Created'
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // get all data from the table
    public function getAllData()
    {
        try {
            $response = $this->repositaryinterface->getAllData();

            // return response in json
            return response()->json(
                [
                    'data' => $response,
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // update data in the database
    public function updateClient(UpdateClientRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $response = $this->repositaryinterface->updateClient($validatedData);

            // return response in json
            return response()->json(
                [
                    'data' => $response,
                    'message' => 'SuccessFully Updated'
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // delete data in the database
    public function deleteClient(Request $request)
    {
        // validate data from the request
        $validatedData = $request->validate([
            'id' => 'required|exists:clients,id'
        ]);

        try {
            $response = $this->repositaryinterface->deleteClient($validatedData);

            // return response in json
            return response()->json(
                [
                    'data' => $response,
                    'message' => 'SuccessFully Deleted'
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // search clients by phone number
    public function searchByPhone(Request $request)
    {
        // validate data from the request
        $validatedData = $request->validate([
            'phone' => 'nullable'
        ]);

        try {
            $response = $this->repositaryinterface->searchByPhone($validatedData);

            // return response in json
            return response()->json(
                [
                    'data' => $response,
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
