<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRevision;
use Illuminate\Http\Request;
use App\Http\Requests\Revisions\UpdateRevisionRequest;
use Symfony\Component\HttpFoundation\Response;

class ArticleRevisionController extends Controller
{
    public function index(Article $article)
    {
        $revisions = $article->revisions;
        return view('articles.revisions', compact('article', 'revisions'));

    }

    public function show(Article $article, ArticleRevision $revision)
    {
        return view('articles.revision_detail', compact('article', 'revision'));
    }

    public function update(UpdateRevisionRequest $request, Article $article, ArticleRevision $revision)
    {
        $request->updateRevision($revision);
        return redirect()->route('revisions.index', $article->id)->with('success', 'Article reverted successfully!');
    }


}
