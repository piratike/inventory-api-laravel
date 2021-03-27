<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RequestController;
use App\Models\Store;

class StoreController extends RequestController
{
    /**
     * Create a new Store.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function createStore(Request $request, $store_name)
    {

        try {

            $store = Store::where('name', '=', $store_name)->first();

            if(!is_null($store))
                return RequestController::returnSuccess($store_name, 'The Store already exist.');

            Store::create([
                'name' => $store_name
            ]);

            return RequestController::returnSuccess($store_name, 'The Store was added successfully.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The Store could not be created.', 500);

        }

    }

    /**
     * Edit a Store.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function editStore(Request $request, $store_name, $new_store_name)
    {

        try {

            $store = Store::where('name', '=', $store_name)->first();

            if(is_null($store))
                return RequestController::returnSuccess($store_name, 'The Store does not exist.');

            $store->update(['name' => $new_store_name]);

            return RequestController::returnSuccess($new_store_name, 'The Store was updated successfully.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The Store could not be updated.', 500);

        }

    }

    /**
     * Delete a Store.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function deleteStore(Request $request, $store_name)
    {

        try {

            $store = Store::where('name', '=', $store_name)->first();

            if(is_null($store))
                return RequestController::returnSuccess($store_name, 'The Store does not exist.');

            $store->delete();

            return RequestController::returnSuccess($store_name, 'The Store was deleted successfully.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The Store could not be deleted.', 500);

        }

    }

    /**
     * Get all Stores.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getStores(Request $request)
    {

        try {

            return RequestController::returnSuccess(Store::all(), 'Data given.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The data could not be sent.', 500);

        }

    }

    /**
     * Get Store ID.
     *
     * @param integer $store_name
     */
    public static function getStoreId($store_name)
    {

        try {

            $id = Store::where('name', '=', $store_name)->first();

            if(is_null($id))
                return False;

            return $id->id;

        } catch (Exception $e) {

            return False;

        }

    }

}
