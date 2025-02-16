<?php
namespace App\Observers;

use App\Models\Article;
use App\Models\ArticleRevision;

class ArticleObserver
{
    public function updating(Article $article)
    {
        ArticleRevision::create([
            'article_id' => $article->id,
            'title' => $article->title,
            'description' => $article->description,
            'body' => $article->body,
            'user_id' => auth()->id(), // ✅ Set user_id when saving revision
        ]);

    }
}