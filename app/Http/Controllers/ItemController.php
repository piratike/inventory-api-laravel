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
    public function editItem(Request $request, $item_id)
    {

        try {

            if(is_null($request->input('name')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Name to the Item.', 500);

            if(is_null($request->input('description')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Description to the Item.', 500);

            if(is_null($request->input('cuantity')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Cuantity to the Item.', 500);

            if(is_null($request->input('store_id')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Store to the Item.', 500);

            if(is_null($request->input('category_id')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a Category to the Item.', 500);

            $store_id = StoreController::getStoreId($request->input('store_id'));
            $category_id = CategoryController::getCategoryId($request->input('category_id'));

            if(!$store_id || !$category_id)
                return RequestController::returnFail('Internal Server error.', 'The Item does not have a valid Store or Category.', 500);

            $item = Item::where('id', '=', $item_id)->first();

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
    public function deleteItem(Request $request, $item_id)
    {

        try {

            $item = Item::where('id', '=', $item_id)->first();

            if(is_null($item))
                return RequestController::returnSuccess('No Item', 'The Item does not exist.');

            $item->delete();

            return RequestController::returnSuccess($item->name, 'The Item was deleted successfully.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The Item could not be deleted.', 500);

        }

    }

    /**
     * Get Item or Items.
     *
     * @var \Illuminate\Http\Response
     */
    public function getItems(Request $request)
    {

        try {

            $queries = [];

            if(!is_null($request->input('store_name')))
                array_push($queries, ['store', '=', StoreController::getStoreId($request->input('store_name'))]);

            if(!is_null($request->input('category_name')))
                array_push($queries, ['category', '=', CategoryController::getCategoryId($request->input('category_name'))]);

            if(!is_null($request->input('min_cuantity')))
                array_push($queries, ['cuantity', '>=', $request->input('min_cuantity')]);

            if(!is_null($request->input('max_cuantity')))
                array_push($queries, ['cuantity', '<=', $request->input('max_cuantity')]);

            if(!is_null($request->input('description_like')))
                array_push($queries, ['description', 'like', "%{$request->input('description_like')}%"]);

            if(!is_null($request->input('name_like')))
                array_push($queries, ['name', 'like', "%{$request->input('name_like')}%"]);

            return RequestController::returnSuccess(Item::where($queries)->get(), 'Data given.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'Data could not be given.', 500);

        }

    }

}
