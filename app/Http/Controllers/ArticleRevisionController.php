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
        return response()->json($article->revisions, Response::HTTP_OK);
    }

    public function show(Article $article, ArticleRevision $revision)
    {
        return response()->json($revision, Response::HTTP_OK);
    }

    public function update(UpdateRevisionRequest $request,Article $article, ArticleRevision $revision)
    {
        $updatedRevision = $request->updateRevision($revision);
        return response()->json($updatedRevision, Response::HTTP_OK);
    }
}