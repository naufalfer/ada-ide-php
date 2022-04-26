<?php

namespace App\Http\Controllers;

use App\Models\News;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::all();
        $response = [
            'message' => 'Data All News',
            'data' => $news,
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
            "news_date" => 'required|date',
            "title" => 'required|string|max:255',
            "description" => 'required|string|max:255',
            "photo" => 'required|mimes:png,jpg,jpeg,gif|max:2305',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $file = $request->file('photo');
            $path = $file->store('public/files/news');
            $name = $file->getClientOriginalName();

            $news = new News();
            $news->id_project = $request->id_project;
            $news->news_date= $request->news_date;
            $news->title= $request->title;
            $news->description= $request->description;
            $news->photo= $path;
            $news->save();

            $response = [
                'message' => 'Data berita berhasil disimpan',
                'data' => $news,
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
    public function show($id_news)
    {
        $news = News::where('id_news', $id_news)->firstOrFail();
        if ($news) {
            return response()->json([
                "success" => true,
                "message" => "Data berita ditemukan",
                "data" => $news,
            ]);
        } else {
        return $this->sendError('Data berita dengan id tersebut tidak ditemukan');
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
    public function update(Request $request, $id_news)
    {
        $validator = Validator::make($request->all(), [
            "id_project" => 'required|numeric',
            "news_date" => 'required|date',
            "title" => 'required|string|max:255',
            "description" => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $file = $request->file('photo');
            $news = News::find($id_news);

            if ($file){
                $path = $file->store('public/files/news');
                $name = $file->getClientOriginalName();
            } else {
                $path = $news->photo;
            }

            $news->id_project = $request->id_project;
            $news->news_date= $request->news_date;
            $news->title= $request->title;
            $news->description= $request->description;
            $news->photo= $path;
            $news->update();

            $response = [
                'message' => 'Data berita berhasil disimpan',
                'data' => $news,
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
    public function destroy($id_news)
    {
        $news = News::where('id_news', $id_news)->firstOrFail();
        if (is_null($news)) {
            return $this->sendError('Data news tidak ditemukan');
        }
        $deletedRows = News::where('id_news', $id_news)->delete();
        return response()->json([
            "success" => true,
            "message" => "Data news berhasil dihapus",
            "data" => $deletedRows,
        ]);
    }
}
