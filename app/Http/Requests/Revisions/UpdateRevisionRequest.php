<?php
namespace App\Http\Requests\Revisions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ArticleRevision;

class UpdateRevisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:500',
            'body' => 'sometimes|string',
        ];
    }

    public function updateRevision(ArticleRevision $revision)
    {
        return DB::transaction(function () use ($revision) {
            $revision->update([
                'title' => $this->input('title', $revision->title),
                'description' => $this->input('description', $revision->description),
                'body' => $this->input('body', $revision->body),
            ]);

            return $revision->refresh();
        });
    }
}
