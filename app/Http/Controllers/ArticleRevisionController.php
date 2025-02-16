<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRevision;
use Illuminate\Http\Request;
use App\Http\Requests\Revisions\RevertRevisionRequest;
use Symfony\Component\HttpFoundation\Response;

class ArticleRevisionController extends Controller
{
    public function index(Article $article)
    {
        return response()->json($article->revisions, Response::HTTP_OK);
    }

    public function show(Article $article, ArticleRevision $revision)
    {
        return response()->json($revision, Response::HTTP_OK);
    }

    public function revert(RevertRevisionRequest $request,Article $article, ArticleRevision $revision)
    {
       
        $updatedRevision = $request->revertRevision($revision);
        return response()->json($updatedRevision, Response::HTTP_OK);

    }
    // public function index(Article $article)
    // {
    //     $revisions = $article->revisions;
    //     return view('articles.revisions', compact('article', 'revisions'));

    // }

    // public function show(Article $article, ArticleRevision $revision)
    // {
    //     return view('articles.revision_detail', compact('article', 'revision'));
    // }

    // public function update(UpdateRevisionRequest $request, Article $article, ArticleRevision $revision)
    // {
    //     $request->updateRevision($revision);
    //     return redirect()->route('revisions.index', $article->id)->with('success', 'Article reverted successfully!');
    // }
}