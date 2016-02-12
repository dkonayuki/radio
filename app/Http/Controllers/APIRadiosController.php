<?php

namespace App\Http\Controllers;

use App\Program;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Input;
use App\Radio;
use App\Helpers\Transformers\RadioTransformer;

class APIRadiosController extends ApiController
{

    protected $radioTransformer;

    function __construct() {
        $this->radioTransformer = new RadioTransformer;

        #not working
        #$this->beforeFilter('auth.basic');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $limit = Input::get('limit') ?: 3;
        $radios = Radio::paginate($limit);

        #data dump 
        #dd(get_class_methods($radios));

        return $this->respond([
            'data' => $this->radioTransformer->transformCollection($radios->all()),
            'paginator' => [
                'total_count' => $radios->total(),
                'total_pages' => ceil($radios->total() / $radios->perPage()),
                'current_page' => $radios->currentPage(),
                'limit' => $radios->perPage()
            ]
        ]);
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
    public function store() {
        echo "store\n";
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
            return $this->respondNotFound('Radio does not exist.');
        }

        return $this->respond([
            'data' => $this->radioTransformer->transform($radio)
        ]);
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
