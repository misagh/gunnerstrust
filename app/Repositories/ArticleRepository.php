<?php

namespace App\Repositories;

use App\Article;
use App\Services\ArticleImageFinder;

class ArticleRepository extends Repository {

    public function __construct(Article $article = null)
    {
        $this->model = $article ?: new Article();
    }

    public function insertArticle($data)
    {
        $data['cover'] = (new ArticleImageFinder)->find($data['source'], $data['cover']);
        $data['slug'] = $this->getSlug($data['title']);
        $data['user_id'] = auth()->id();
        $data['body'] = clean($data['body']);

        $article = $this->create($data);

        $this->insertTags($article, $data['tags']);

        return $article;
    }

    public function updateArticle($data)
    {
        if ($data['source'] !== $this->model->source || (! empty($data['cover']) && $data['cover'] !== $this->model->cover))
        {
            $data['cover'] = (new ArticleImageFinder)->find($data['source'], $data['cover'], true);
        }

        empty($data['cover']) AND $data['cover'] = $this->model->cover;
        $data['body'] = clean($data['body']);

        $this->update($this->model, $data);

        $this->updateTags($this->model, $data['tags']);

        return $this->model;
    }

    public function updatePins()
    {
        return $this->model->where('pinned', '>', 0)->update(['pinned' => 0]);
    }

    public function getPinnedArticles()
    {
        return $this->model->where('pinned', '>', 0)
                           ->orderBy('pinned')
                           ->get();
    }

    public function getUnpinnedArticles()
    {
        return $this->model->where('pinned', 0)
                           ->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    public function getLatestArticles()
    {
        return $this->model->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    private function insertTags(Article $article, $tags_string)
    {
        $tags = $this->getTags($article, $tags_string);

        return $article->tags()->saveMany($tags);
    }

    private function updateTags(Article $article, $tags_string)
    {
        $tags = $this->getTags($article, $tags_string);

        return $article->tags()->sync(collect($tags)->pluck('id'));
    }

    private function getTags(Article $article, $tags_string)
    {
        $tags = [];

        foreach (explode(',', $tags_string) as $tag)
        {
            $tag = trim($tag);

            empty($tag) OR $tags[] = (new TagRepository)->insertTag($tag);
        }

        return $tags;
    }
}
