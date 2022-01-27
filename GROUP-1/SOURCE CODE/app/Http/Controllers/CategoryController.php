<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Edit Category
     */
    public function edit(Request $request){
        Validator::make($request->all(),[
            'category_name' => ['required', 
                                'unique:categories,name,' . $request->category_id,
                                function ($attribute, $value, $fail) use($request) {

                                    $exists = Category::where('name', "ILIKE", $value)
                                                        ->where('id', '!=', $request->category_id)
                                                        ->first();
                                    

                                    if ($exists) {
                                        $fail('The '.$attribute.' is already taken.');
                                    }
                                },],
            'category_value' => ['required', 
                                 'unique:categories,value,' . $request->category_id,
                                 function ($attribute, $value, $fail) use($request) {

                                    $exists = Category::where('value', "ILIKE", $value)
                                    ->where('id', '!=', $request->category_id)
                                    ->first();
        
                                    if ($exists) {
                                        $fail('The '.$attribute.' is already taken.');
                                    }
                                },],
            'category_id' => ['required'],
        ])->validate();

        Category::where('id', $request->category_id)
                ->update([
                    'name' => $request->category_name,
                    'value' => $request->category_value,
                ]);

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Category Edited!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Category Edited Successfully.');
    }

    /**
     * Delete a Category
     */
    public function delete($id, Request $request){
        Validator::make($request->all(), [
            'password' => ['required','current_password'],
        ])->validate();

        Category::destroy($id);

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Category Deleted!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Category Deleted Successfully.');
    }

    /**
     * Add a category
     */
    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'category_name' => ['required', 
                                'unique:categories,name',
                                function ($attribute, $value, $fail) {

                                    $exists = Category::where('name', "ILIKE", $value)->first();
        
                                    if ($exists) {
                                        $fail('The '.$attribute.' is already taken.');
                                    }
                                },],
            'value' => ['required',
                        'unique:categories',
                        function ($attribute, $value, $fail) {

                            $exists = Category::where('value', "ILIKE", $value)->first();

                            if ($exists) {
                                $fail('The '.$attribute.' is already taken.');
                            }
                        },
                ],
        ])->validate();

        Category::create([
            'name' => $request->category_name,
            'value' => $request->value,
        ]);

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Category Added!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Category Added Successfully.');
    }
}
