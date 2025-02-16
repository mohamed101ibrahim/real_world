<?php
namespace App\Http\Requests\Revisions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\ArticleRevision;

class RevertRevisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return []; // No validation rules needed for reverting
    }

    public function revertRevision(ArticleRevision $revision)
    {
        return DB::transaction(function () use ($revision) {
            $article = $revision->article;

            ArticleRevision::create([
                'article_id' => $article->id,
                'user_id' => auth()->id(),
                'title' => $article->title,
                'description' => $article->description,
                'body' => $article->body,
            ]);

            $article->update([
                'title' => $revision->title,
                'description' => $revision->description,
                'body' => $revision->body,
            ]);

            return $article->refresh();
        });
    }
}