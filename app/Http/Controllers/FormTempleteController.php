<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FormField;
use Illuminate\Support\Str;
use App\Models\FormTemplete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormTempleteController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return view( 'layouts.form.index' );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $categories = Category::where( 'user_id', auth()->id() )->get();
        return view( 'layouts.form.create', compact( 'categories' ) );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request ) {
        if ( $request->ajax() ) {

            $validatior = Validator::make( $request->all(), [
                'name'             => 'required|string|max:255',
                'category'         => 'required|exists:categories,id',
                'fields.*.label'   => 'required|string|max:255',
                'fields.*.type'    => 'required|string|in:text,textarea,number,select,checkbox,radio,file,date,time,datetime',
                'fields.*.options' => 'nullable|string', // Options are only required for select, checkbox, radio
            ] );
            if ( $validatior->fails() ) {
                return response()->json( ['errors' => $validatior->errors()] );
            }

            try {
                DB::beginTransaction();

                $form = FormTemplete::create( [
                    'name'        => $request->name,
                    'slug'        => Str::slug( $request->name ),
                    'category_id' => $request->category,
                    'description' => $request->description,
                ] );

                // Loop through each field and save them
                foreach ( $request->fields as $fieldCollection ) {
                    $options = null;
                    if ( in_array( $fieldCollection['type'], ['select', 'checkbox', 'radio'] ) && isset( $fieldCollection['options'] ) ) {
                        $options = json_encode( explode( ',', $fieldCollection['options'] ) );
                    }

                    FormField::create( [
                        'form_templete_id' => $form->id,
                        'label'            => $fieldCollection['label'],
                        'type'       => $fieldCollection['type'],
                        'placeholder'      => $fieldCollection['placeholder'] ?? null,
                        'is_required'         => isset( $fieldCollection['required'] ) ? 1 : 0,
                        'options'          => $options,
                    ] );
                }

                DB::commit();
                $request->session()->flash( 'success', 'Form created successfully' );
                return response()->json( ['success' => 'Form created successfully'] );
            } catch ( \Exception $e ) {

                DB::rollback();
                $request->session()->flash( 'success', 'Form created successfully' );
                return response()->json( ['errors' => $e->getMessage()] );
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( string $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( string $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {
        //
    }
}
