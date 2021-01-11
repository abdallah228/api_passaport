<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;
use App\Http\Resources\ArticleResource;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{

    //middleware
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       $article =  Article::paginate(5);
       if(!$article)
       {
           return $this->notExist();
       }
        return ArticleResource::collection($article);
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
    public function store(ArticleRequest $request)
    {
        //
       /* // i use request file for validation
        $request->validate([
            'title'=>'required|min:3',
            'body'=>'required|min:5',
            'user_id'=>'required|numeric',
        ]);
        */
      //  return auth()->user();
      $request->merge(['user_id'=>auth()->user()->id]);
        $article = Article::create($request->all());
        return response()->json(['data'=> new ArticleResource($article),'status'=>200, 'messages'=>'article added succesfuly'],200);
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
        $article = Article::find($id);
        if(!$article)
        {
            return $this->notExist();
        }
        else{
        return response()->json(['data'=> new ArticleResource($article),'status'=>true,'status_code'=>200, 'messages'=>'the single article'],200);

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
    public function update(ArticleRequest $request, $id)
    {
        //validate
       // $article = Article::find('id');
        $article = auth()->user()->articles()->find($id);// it should user is the author for article
        if(!$article)
        {
            return $this->notExist();
        }
        else
        $article->update($request->all());
        return response()->json(['data'=> new ArticleResource($article),'status'=>true,'status_code'=>200, 'messages'=>'article updated succesfuly'],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
      //  $article = Article::find($id);
      $article = auth()->user()->articles()->find($id);// it should user is the author for article
        if(!$article)
        {
            return $this->notExist();
        }
        
        if($article->delete())
        {
            return response()->json(['data'=>[],'status'=>true,'status_code'=>200 , 'message'=>'article deleted succesfuly'],200);
        }
        else{
            return $this->error_response();

        }
    }

    public function logout()
    {
      //  auth()->user()->token()->revoke();//revoke
        auth()->user()->token()->delete();//delete token
    }


//private functions
    private function notExist()
    {
        $data = ['data'=>[],
        'status'=>false,
        'status_code'=>404,
        'message'=>'article not found'];
        return response()->json($data,404);
    }
    private function error_response()
    {
        $data = ['data'=>[],
        'status'=>false,
        'status_code'=>500,
        'message'=>'something went wrong'];
        return response()->json($data,500);
    }
  
}
