<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Create a new Item.
     *
     * @var \Illuminate\Http\Response
     */
    public function createItem(Request $request)
    {

        try {

            if(is_null($request->input('name')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Name to the Item.', 500);

            if(is_null($request->input('description')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Description to the Item.', 500);

            if(is_null($request->input('cuantity')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Cuantity to the Item.', 500);

            if(is_null($request->input('store_name')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Store to the Item.', 500);

            if(is_null($request->input('category_name')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Category to the Item.', 500);

            $store_id = StoreController::getStoreId($request->input('store_name'));
            $category_id = CategoryController::getCategoryId($request->input('category_name'));

            if(!$store_id || !$category_id)
                return RequestController::returnFail('Internal Server error.', 'The Item does not have a Store or a Category.', 500);

            $item = Item::where('store', '=', $store_id)
                        ->where('category', '=', $category_id)
                        ->where('name', '=', $request->input('name'))
                        ->where('description', '=', $request->input('description'))
                        ->first();

            if(!is_null($item))
                return RequestController::returnSuccess($request->input('name'), 'The Item already exist.');

            Item::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'cuantity' => $request->input('cuantity'),
                'category' =>  $category_id,
                'store' => $store_id,
            ]);

            return RequestController::returnSuccess($request->input('name'), 'The Item was added successfully.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The Item could not be created.', 500);

        }

    }

    /**
     * Edit an Item.
     *
     * @var \Illuminate\Http\Response
     */
    public function editItem(Request $request)
    {

        try {

            if(is_null($request->input('id')))
                return RequestController::returnFail('Internal Server error.', 'Must provide an ID of the Item.', 500);

            if(is_null($request->input('name')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Name to the Item.', 500);

            if(is_null($request->input('description')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Description to the Item.', 500);

            if(is_null($request->input('cuantity')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Cuantity to the Item.', 500);

            if(is_null($request->input('store_name')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Store to the Item.', 500);

            if(is_null($request->input('category_name')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Category to the Item.', 500);

            $store_id = StoreController::getStoreId($request->input('store_name'));
            $category_id = CategoryController::getCategoryId($request->input('category_name'));

            if(!$store_id || !$category_id)
                return RequestController::returnFail('Internal Server error.', 'The Item does not have a Store or a Category.', 500);

            $item = Item::where('id', '=', $request->input('id'))->first();

            if(is_null($item))
                return RequestController::returnSuccess('No Item', 'The Item already exist.');

            $item->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'cuantity' => $request->input('cuantity'),
                'category' =>  $category_id,
                'store' => $store_id,
            ]);

            return RequestController::returnSuccess($request->input('name'), 'The Item was modified successfully.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The Item could not be modified.', 500);

        }

    }

    /**
     * Delete an Item.
     *
     * @var \Illuminate\Http\Response
     */
    public function deleteItem(Request $request)
    {

        try {

            if(is_null($request->input('id')))
                return RequestController::returnFail('Internal Server error.', 'Must provide an ID of the Item.', 500);

            $item = Item::where('id', '=', $request->input('id'))->first();

            if(is_null($item))
                return RequestController::returnSuccess('No Item', 'The Item does not exist.');

            $item->delete();

            return RequestController::returnSuccess($item->name, 'The Item was deleted successfully.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The Item could not be deleted.', 500);

        }

    }

    /**
     * Get Item or Items. // FALTA AÑADIR FILTROS
     *
     * @var \Illuminate\Http\Response
     */
    public function getItems(Request $request, $store_name)
    {

        try {

            $store_id = StoreController::getStoreId($store_name);

            return RequestController::returnSuccess(Item::where('store', '=', $store_id)->get(), 'Data given.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'Data could not be given.', 500);

        }

    }

}
