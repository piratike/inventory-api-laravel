<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RequestController;
use App\Models\Category;

class CategoryController extends RequestController
{
    /**
     * Create a new Category.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function createCategory(Request $request)
    {

        try {

            if(is_null($request->input('category_name')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a category name.', 500);

            $category_name = $request->input('category_name');
            $category = Category::where('name', '=', $category_name)->first();

            if(!is_null($category))
                return RequestController::returnSuccess($category_name, 'The Category already exist.');

            Category::create([
                'name' => $category_name
            ]);

            return RequestController::returnSuccess($category_name, 'The Category was added successfully.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The Category could not be created.', 500);

        }

    }

    /**
     * Edit a Category.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function editCategory(Request $request, $category_id)
    {

        try {

            if(is_null($request->input('new_category_name')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a new category name.', 500);

            $new_category_name = $request->input('new_category_name');
            $category = Category::where('id', '=', $category_id)->first();

            if(is_null($category))
                return RequestController::returnSuccess($category_id, 'The Category does not exist.');

            $category->update(['name' => $new_category_name]);

            return RequestController::returnSuccess($new_category_name, 'The Category was updated successfully.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The Category could not be updated.', 500);

        }

    }

    /**
     * Delete a Category.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function deleteCategory(Request $request, $category_id)
    {

        try {

            if(is_null($request->input('category_name')))
                return RequestController::returnFail('Internal Server error.', 'Must provide a category name.', 500);

            $category = Category::where('id', '=', $category_id)->first();

            if(is_null($category))
                return RequestController::returnSuccess($category_id, 'The Category does not exist.');

            $category->delete();

            return RequestController::returnSuccess($category_id, 'The Category was deleted successfully.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The Category could not be deleted.', 500);

        }

    }

    /**
     * Get all Categorys.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getCategories(Request $request)
    {

        try {

            return RequestController::returnSuccess(Category::all(), 'Data given.');

        } catch (Exception $e) {

            return RequestController::returnFail('Internal Server error.', 'The data could not be sent.', 500);

        }

    }

    /**
     * Get Category ID.
     *
     * @param integer $category_name
     */
    public static function getCategoryId($category_name)
    {

        try {

            $id = Category::where('name', '=', $category_name)->first();

            if(is_null($id))
                return False;

            return $id->id;

        } catch (Exception $e) {

            return False;

        }

    }

}
