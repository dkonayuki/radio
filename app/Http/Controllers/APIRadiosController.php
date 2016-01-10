<?php

namespace App\Http\Controllers;

use App\Program;
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
            'data' => $radios->toArray()
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
        $radio = Radio::findOrFail($id);

        return Response::json([
            'data' => $radio->toArray()
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

    public function programs($radio_id, $program_id = null)
    {
        $programs = array();
        try {
            if($program_id === null) {
                $programs = Program::where('radio_id', $radio_id)
                    ->get()->toArray();
            } else {
                $programs = Program::findOrFail($program_id)->toArray();
            }
        } catch (\Exception $ex) {}
        return Response::json([
            'data' => $programs
        ], 200);
    }
}
