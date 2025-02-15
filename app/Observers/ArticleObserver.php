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
            'title' => $article->getOriginal('title'),
            'description' => $article->getOriginal('description'),
            'body' => $article->getOriginal('body'),
        ]);
    }
}
