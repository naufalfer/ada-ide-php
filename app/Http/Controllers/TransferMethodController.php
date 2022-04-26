<?php

namespace App\Http\Controllers;

use App\Models\TransferMethod;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TransferMethodResource;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;


class TransferMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfer_method = TransferMethod::all();
        $response = [
            'message' => 'Data All Transfer Method',
            'data' => $transfer_method,
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
            "bank_name" => 'required|string|max:32',
            "account_no" => 'required|string|max:32',
            "account_name" => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $transfer_method = TransferMethod::create($request->all());

            $response = [
                'message' => 'Berhasil disimpan',
                'data' => $transfer_method,
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
    public function show($id_transfer_method)
    {
        $transfer_method = TransferMethod::where('id_transfer_method', $id_transfer_method)->firstOrFail();
        if ($transfer_method) {
            return response()->json([
                "success" => true,
                "message" => "Data transfer method ditemukan",
                "data" => $transfer_method,
            ]);
        } else {
        return $this->sendError('Data transfer method dengan id tersebut tidak ditemukan');
        }
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
    public function update(Request $request, $id_transfer_method)
    {
        $validator = Validator::make($request->all(), [
            "bank_name" => 'required|string|max:32',
            "account_no" => 'required|string|max:32',
            "account_name" => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $transfer_method = TransferMethod::find($id_transfer_method);
            $transfer_method->update($request->all());

            $response = [
                'message' => 'Berhasil disimpan',
                'data' => $transfer_method,
            ];

            return response()->json($response, HttpFoundationResponse::HTTP_CREATED);
            } catch (QueryException $e) {
                return response()->json([
                    'message' => "Gagal " . $e->errorInfo,
                ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_transfer_method)
    {
        $transfer_method = TransferMethod::where('id_transfer_method', $id_transfer_method)->firstOrFail();
        if (is_null($transfer_method)) {
            return $this->sendError('Data transfer method tidak ditemukan');
        }
        $deletedRows = TransferMethod::where('id_transfer_method', $id_transfer_method)->delete();
        return response()->json([
            "success" => true,
            "message" => "Data transfer method berhasil dihapus",
            "data" => $deletedRows,
        ]);
    }
}
