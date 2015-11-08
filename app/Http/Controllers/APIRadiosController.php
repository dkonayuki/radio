<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\Radio;
use App\Helpers\Transformers\RadioTransformer;

class APIRadiosController extends Controller
{

    protected $radioTransformer;

    function __construct() {
        $this->radioTransformer = new RadioTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $radios = Radio::all();

        return Response::json([
            'data' => $this->radioTransformer->transformCollection($radios->all())
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $radio = Radio::find($id);

        if (!$radio) {
            return Response::json([
                'error' => 'Radio does not exist'
            ], 404);
        }

        return Response::json([
            'data' => $this->radioTransformer->transform($radio)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
