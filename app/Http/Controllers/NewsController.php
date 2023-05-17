<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\News;
class NewsController extends Controller
{
    public function index()
    {
        $newss = News::all();
 
        return response()->json([
            'success' => true,
            'data' => $newss
        ]);
    }
 
    public function show($id)
    {
        $news = News::find($id);
 
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found '
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $news->toArray()
        ], 400);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
 
        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;
 
        if ($news->save())
            return response()->json([
                'success' => true,
                'data' => $news->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'News not added'
            ], 500);
    }
 
    public function update(Request $request, $id)
    {
        $news = auth()->user()->newss()->find($id);
 
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 400);
        }
 
        $updated = $news->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'News can not be updated'
            ], 500);
    }
 
    public function destroy($id)
    {
        $news = News::find($id);
 
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 400);
        }
 
        if ($news->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'News can not be deleted'
            ], 500);
        }
    }
}