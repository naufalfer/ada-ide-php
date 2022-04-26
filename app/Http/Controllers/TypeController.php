<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TypeResource;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = Type::all();
        $response = [
            'message' => 'Data All Type',
            'data' => $type,
        ];
        return response()->json($response, HttpFoundationResponse::HTTP_OK);
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
            "project_name" => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $type = Type::create($request->all());

            $response = [
                'message' => 'Berhasil disimpan',
                'data' => $type,
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
    public function show($id_type)
    {
        $type = Type::where('id_type', $id_type)->firstOrFail();
        if ($type) {
            return response()->json([
                "success" => true,
                "message" => "Data type ditemukan",
                "data" => $type,
            ]);
        } else {
        return $this->sendError('Data type dengan id tersebut tidak ditemukan');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_type)
    {
        $validator = Validator::make($request->all(), [
            "project_name" => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $type = Type::find($id_type);
            $type->update($request->all());

            $response = [
                'message' => 'Data type berhasil diubah',
                'data' => $type,
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
    public function destroy($id_type)
    {
        $type = Type::where('id_type', $id_type)->firstOrFail();
        if (is_null($type)) {
            return $this->sendError('Data type tidak ditemukan');
        }
        $deletedRows = Type::where('id_type', $id_type)->delete();
        return response()->json([
            "success" => true,
            "message" => "Data type berhasil dihapus",
            "data" => $deletedRows,
        ]);
    }
}
