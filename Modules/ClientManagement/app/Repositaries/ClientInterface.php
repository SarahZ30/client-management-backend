<?php

namespace Modules\ClientManagement\app\Repositaries;

interface ClientInterface
{
    // store a new client in the database
    public function storeClient($validatedData);

    // get all data from the table
    public function getAllData();

    // update data in the database
    public function updateClient($validatedData);

    // delete data in the database
    public function deleteClient($validatedData);

    // search clients by phone number
    public function searchByPhone($validatedData);
}
