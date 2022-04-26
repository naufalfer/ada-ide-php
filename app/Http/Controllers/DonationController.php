<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donation = Donation::all();
        $response = [
            'message' => 'Data All Donation',
            'data' => $donation,
        ];
        return response()->json($response, HttpFoundationResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id_project" => 'required|numeric',
            "nominal" => 'required|numeric',
            "name" => 'required|string|max:32',
            "nowhatsapp" => 'required|string|max:13',
            "description" => 'required|string|max:255',
            "is_anonim" => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $file = $request->file('photo');

            if ($file){
                $path = $file->store('public/files/donation');
                $name = $file->getClientOriginalName();
            } else {
                $path = '';
            }

            $donation = new Donation();
            $donation->id_project = $request->id_project;
            $donation->nominal= $request->nominal;
            $donation->name= $request->name;
            $donation->nowhatsapp= $request->nowhatsapp;
            $donation->description= $request->description;
            $donation->is_anonim= $request->is_anonim;
            $donation->photo= $path;
            $donation->save();

            $response = [
                'message' => 'Data donasi berhasil disimpan',
                'data' => $donation,
            ];

            return response()->json($response, HttpFoundationResponse::HTTP_CREATED);
            } catch (QueryException $e) {
                return response()->json([
                    'message' => "Gagal " . $e->errorInfo,
                ]);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_donation)
    {
        $donation = Donation::where('id_donation', $id_donation)->firstOrFail();
        if (is_null($donation)) {
            return $this->sendError('Data donasi tidak ditemukan');
        }
        $deletedRows = Donation::where('id_donation', $id_donation)->delete();
        return response()->json([
            "success" => true,
            "message" => "Data donasi berhasil dihapus",
            "data" => $deletedRows,
        ]);
    }
}
