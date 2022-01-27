<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuantityType;
use Illuminate\Support\Facades\Validator;

class QtyController extends Controller
{
    /**
     * Edit QuantityType
     */
    public function edit(Request $request){
        Validator::make($request->all(),[
            'qty_type' => ['required', 
                                'unique:qty_type,name,' . $request->qty_id,
                                function ($attribute, $value, $fail) use($request) {

                                    $exists = QuantityType::where('name', "ILIKE", $value)
                                                        ->where('id', '!=', $request->qty_id)
                                                        ->first();

                                    if ($exists) {
                                        $fail('The '.$attribute.' is already taken.');
                                    }
                                },],
            'qty_value' => ['required', 
                                 'unique:qty_type,value,' . $request->qty_id,
                                 function ($attribute, $value, $fail) use($request) {

                                    $exists = QuantityType::where('value', "ILIKE", $value)
                                            ->where('id', '!=', $request->qty_id)
                                            ->first();
        
                                    if ($exists) {
                                        $fail('The '.$attribute.' is already taken.');
                                    }
                                },],
            'qty_id' => ['required'],
        ])->validate();

        QuantityType::where('id', $request->qty_id)
                ->update([
                    'name' => $request->qty_type,
                    'value' => $request->qty_value,
                ]);

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Qty Edited!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Qty Edited Successfully.');
    }


     /**
     * Add a category
     */
    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'qty_name' => ['required', 
                                'unique:qty_type,name',
                                function ($attribute, $value, $fail) {

                                    $exists = QuantityType::where('name', "ILIKE", $value)->first();
        
                                    if ($exists) {
                                        $fail('The '.$attribute.' is already taken.');
                                    }
                                },],
            'value' => ['required',
                        'unique:qty_type',
                        function ($attribute, $value, $fail) {

                            $exists = QuantityType::where('value', "ILIKE", $value)->first();

                            if ($exists) {
                                $fail('The '.$attribute.' is already taken.');
                            }
                        },
                ],
        ])->validate();

        QuantityType::create([
            'name' => $request->qty_name,
            'value' => $request->value,
        ]);

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Qty Type Added!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Qty Type Added Successfully.');
    }

    /**
     * Delete a Category
     * 
     */
    public function delete($id, Request $request){
        Validator::make($request->all(), [
            'password' => ['required','current_password'],
        ])->validate();

        QuantityType::destroy($id);

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Quantity Type Deleted!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Quantity Type Successfully.');
    }
}
