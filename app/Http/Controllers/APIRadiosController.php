<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\Radio;

class APIRadiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $radios = Radio::all();

        return Response::json([
            'data' => $this->transformCollection($radios)
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
            'data' => $this->transform($radio)
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

    private function transformCollection($radios) {
        return array_map([$this, 'transform'], $radios->toArray());
    }

    private function transform($radio) {
        return [
            'id'            => $radio['id'],
            'name'          => $radio['name'],
            'description'   => $radio['description'],
            'logo_url'      => $radio['logo_url'],
            'stream_url'    => $radio['stream_url'],
            'website'       => $radio['website'],
            'status'        => $radio['status']
        ];

    }
}
