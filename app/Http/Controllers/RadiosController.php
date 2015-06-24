<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Radio;

use Input;
use Redirect;
use Log;

class RadiosController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    protected $rules = [
        'name' => ['required'],
        'stream_url' => ['required']
    ];
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (Input::has('query')) {
            $query = Input::get('query');
            $radios = Radio::where('name', 'LIKE', "%$query%")->get();
        } else {
            $radios = Radio::all();
        }

        return view('radios.index', compact('radios', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('radios.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        //Log::info('Request: ' . print_r($request));
        //Log::info('Input: ' . print_r(Input::all()));
         
        $input = Input::all();
        $radio = Radio::create($input);

        return Redirect::route('radios.index')->with('message', 'Radio ' . $radio->name . ' created');
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

        return view('radios.show', ['radio' => $radio]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $radio = Radio::findOrFail($id);

        return view('radios.edit', ['radio' => $radio]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, $this->rules);
         
        $input = Input::all();
        $radio = Radio::findOrFail($id);
        $radio->update($input);

        return Redirect::route('radios.show', $id)->with('message', 'Radio ' . $radio->name . ' edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $radio = Radio::findOrFail($id);

        $radio->delete();
        return Redirect::route('radios.index')->with('message', 'Radio deleted');
    }
}
