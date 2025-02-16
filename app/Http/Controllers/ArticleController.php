<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\DestroyRequest;
use App\Http\Requests\Article\FeedRequest;
use App\Http\Requests\Article\IndexRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\User;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    protected Article $article;
    protected ArticleService $articleService;
    protected User $user;

    public function __construct(Article $article, ArticleService $articleService, User $user)
    {
        $this->article = $article;
        $this->articleService = $articleService;
        $this->user = $user;
    }

    public function index(IndexRequest $request)/*: ArticleCollection*/
    {
        // return new ArticleCollection($this->article->getFiltered($request->validated()));
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    public function feed(FeedRequest $request)/*: ArticleCollection*/
    {
        return new ArticleCollection($this->article->getFiltered($request->validated()));
    }

    public function show(Article $article)/*: ArticleCollection*/
    {
        // return $this->articleResponse($article);
        $article->load('revisions', 'user');
        return view('articles.show', compact('article'));
    }

    public function store(StoreRequest $request)/*: ArticleCollection*/
    {
        $data = $request->validated();

        $article = auth()->user()->articles()->create($data['article']);

        $this->syncTags($article, $data['article']['tagList'] ?? []);

        return $this->articleResponse($article);
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }
    public function update(Article $article, UpdateRequest $request)
    {
        $data = $request->validated();
        $article->update($data);
        return redirect()->route('articles.index')
            ->with('success', 'Article updated successfully.');
    }


    public function destroy(Article $article, DestroyRequest $request): void
    {
        $article->delete();
    }

    public function favorite(Article $article): ArticleResource
    {
        $article->users()->attach(auth()->id());

        return $this->articleResponse($article);
    }

    public function unfavorite(Article $article): ArticleResource
    {
        $article->users()->detach(auth()->id());

        return $this->articleResponse($article);
    }

    /**
     * Sync tags with the article.
     */
    protected function syncTags(Article $article, array $tags = []): void
    {
        $this->articleService->syncTags($article, $tags);
    }

    /**
     * Return formatted article response.
     */
    protected function articleResponse(Article $article): ArticleResource
    {
        return new ArticleResource($article->load('user', 'users', 'tags', 'user.followers'));
    }
}
