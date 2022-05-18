<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ArticleCollection;
use App\Http\Resources\V1\ArticleResource;
use App\Models\Article;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ArticleCollection(Article::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'     => ['required','max:20','unique:articles,title'],
            'body'      =>['required','min:5']
        ]);

        $article = Article::create([
            'title'     => $request->input('title'),
            'slug'      => Str::slug( $request->input('title')),
            'body'      => $request->input('body'),
            'author_id' => auth()->id() ?? 1
        ]);

        return (new ArticleResource($article))
                ->response()
                ->getStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return(new ArticleResource($article))
                ->response()
                ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $this->validate($request,[
            'title'     => ['sometimes','max:20',Rule::unique('articles')->ignore($article->title(),'title')],
            'body'      =>['required','min:5']
        ]);

        $article->update([
            'title'     => $request->input('title'),
            'slug'      => Str::slug( $request->input('title')),
            'body'      => $request->input('body'),
            'author_id' => auth()->id() ?? 1
        ]);

        return (new ArticleResource($article))
        ->response()
        ->setStatusCode(200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json(null,204);
    }
}
