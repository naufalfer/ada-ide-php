<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::all();
        $response = [
            'message' => 'Data All List Project',
            'data' => $project,
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
            "project_name" => 'required|string|max:64',
            "id_type" => 'required|numeric',
            "start_date" => 'required',
            "end_date" => 'required',
            "target_fund" => 'required|numeric|max:9223372036854775807',
            "current_fund" => 'required|numeric|max:9223372036854775807',
            "photo" => 'required|mimes:png,jpg,jpeg,gif|max:2305',
            "description" => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $file = $request->file('photo');
            $path = $file->store('public/files');
            $name = $file->getClientOriginalName();

            $project = new Project();
            $project->project_name = $request->project_name;
            $project->id_type= $request->id_type;
            $project->start_date= $request->start_date;
            $project->end_date= $request->end_date;
            $project->target_fund= $request->target_fund;
            $project->current_fund= $request->current_fund;
            $project->description= $request->description;
            $project->photo= $path;
            $project->save();

            $response = [
                'message' => 'Data project berhasil disimpan',
                'data' => $project,
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
    public function show($id_project)
    {
        $project = Project::where('id_project', $id_project)->firstOrFail();
        if ($project) {
            return response()->json([
                "success" => true,
                "message" => "Data project ditemukan",
                "data" => $project,
            ]);
        } else {
        return $this->sendError('Data project dengan id tersebut tidak ditemukan');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_project)
    {
        $validator = Validator::make($request->all(), [
            "project_name" => 'required|string|max:64',
            "id_type" => 'required|numeric',
            "start_date" => 'required',
            "end_date" => 'required',
            "target_fund" => 'required|numeric|max:9223372036854775807',
            "current_fund" => 'required|numeric|max:9223372036854775807',
            "description" => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $file = $request->file('photo');
            $project = Project::find($id_project);

            if ($file){
                $path = $file->store('public/files');
                $name = $file->getClientOriginalName();
            } else {
                $path = $project->photo;
            }

            $project->project_name = $request->project_name;
            $project->id_type= $request->id_type;
            $project->start_date= $request->start_date;
            $project->end_date= $request->end_date;
            $project->target_fund= $request->target_fund;
            $project->current_fund= $request->current_fund;
            $project->photo= $path;
            $project->description= $request->description;
            $project->update();

            $response = [
                'message' => 'Data project berhasil disimpan',
                'data' => $project,
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
    public function destroy($id_project)
    {
        $project = Project::where('id_project', $id_project)->firstOrFail();
        if (is_null($project)) {
            return $this->sendError('Data project tidak ditemukan');
        }
        $deletedRows = Project::where('id_project', $id_project)->delete();
        return response()->json([
            "success" => true,
            "message" => "Data project berhasil dihapus",
            "data" => $deletedRows,
        ]);
    }
}
