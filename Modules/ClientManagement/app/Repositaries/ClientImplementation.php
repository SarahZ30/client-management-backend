<?php

namespace Modules\ClientManagement\app\Repositaries;

use Modules\ClientManagement\app\Models\Client;

class ClientImplementation implements ClientInterface
{
    // store a new client in the database
    public function storeClient($validatedData)
    {
        // create client reference
        $client = new Client();

        // details entered by the user
        $client->name = $validatedData['name'];
        $client->email = $validatedData['email'];
        $client->phone = $validatedData['phone'];
        $client->company = $validatedData['company'];
        $client->address = $validatedData['address'];
        $client->no_of_employees = $validatedData['no_of_employees'] ?? null;
        $client->project_budget = $validatedData['project_budget'];

        // service charge according to the project budget
        $client->service_charge = $this->calculateServiceCharge($client->project_budget);

        // discount value according to the company size
        $client->discount_value = $this->calculateDiscountValue(
            $client->project_budget,
            $client->no_of_employees
        );

        // final project value the client has to pay
        $client->final_project_value = $this->calculateFinalProjectValue(
            $client->project_budget,
            $client->service_charge,
            $client->discount_value
        );

        // save data
        $client->save();

        return $client;
    }

    // get all data from the table
    public function getAllData()
    {
        $clients = Client::select(
            'id',
            'name',
            'email',
            'phone',
            'company',
            'address',
            'no_of_employees',
            'project_budget',
            'service_charge',
            'discount_value',
            'final_project_value'
        )->get();

        return $clients;
    }

    // update data in the database
    public function updateClient($validatedData)
    {
        // get exist client
        $client = Client::find($validatedData['id']);

        // only phone, address and project budget can be edited
        $client->phone = $validatedData['phone'];
        $client->address = $validatedData['address'];
        $client->project_budget = $validatedData['project_budget'];

        // project budget is changed, so the values must be calculated again
        $client->service_charge = $this->calculateServiceCharge($client->project_budget);

        $client->discount_value = $this->calculateDiscountValue(
            $client->project_budget,
            $client->no_of_employees
        );

        $client->final_project_value = $this->calculateFinalProjectValue(
            $client->project_budget,
            $client->service_charge,
            $client->discount_value
        );

        // save data
        $client->save();

        return $client;
    }

    // delete data in the database
    public function deleteClient($validatedData)
    {
        // get exist client
        $client = Client::find($validatedData['id']);

        // delete client
        $client->delete();

        return $client;
    }

    // search clients by phone number
    public function searchByPhone($validatedData)
    {
        // if searched phone number is empty return all the clients
        if (empty($validatedData['phone'])) {
            return $this->getAllData();
        }

        // if searched phone number is not empty return the matching clients
        $clients = Client::select(
            'id',
            'name',
            'email',
            'phone',
            'company',
            'address',
            'no_of_employees',
            'project_budget',
            'service_charge',
            'discount_value',
            'final_project_value'
        )->where('phone', 'like', '%' . $validatedData['phone'] . '%')->get();

        return $clients;
    }

    // calculate the service charge using the project budget
    private function calculateServiceCharge($project_budget)
    {
        // budget is one million or more
        if ($project_budget >= 1000000) {
            return $project_budget * 0.10;
        }
        // budget is between five hundred thousand and one million
        else if ($project_budget >= 500000) {
            return $project_budget * 0.05;
        }
        // budget is less than five hundred thousand
        else {
            return $project_budget * 0.02;
        }
    }

    // calculate the discount value using the number of employees
    private function calculateDiscountValue($project_budget, $no_of_employees)
    {
        // number of employees is not given, so there is no discount
        if ($no_of_employees == null) {
            return 0;
        }
        // company has more than one hundred employees
        else if ($no_of_employees > 100) {
            return $project_budget * 0.05;
        }
        // company has less than one hundred employees
        else if ($no_of_employees < 100) {
            return $project_budget * 0.02;
        }
        // company has exactly one hundred employees, so there is no discount
        else {
            return 0;
        }
    }

    // calculate the final project value
    private function calculateFinalProjectValue($project_budget, $service_charge, $discount_value)
    {
        return $project_budget + $service_charge - $discount_value;
    }
}
