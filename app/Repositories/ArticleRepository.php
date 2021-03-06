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
        $data['user_id'] = $data['user_id'] ?? auth()->id();
        $data['body'] = $this->processBodyText($data['body']);
        $data['summary'] = $this->processSummaryText($data);

        $article = $this->create($data);

        $this->insertTags($article, @$data['tags']);

        return $article;
    }

    public function updateArticle($data)
    {
        if ($data['source'] !== $this->model->source || (! empty($data['cover']) && $data['cover'] !== $this->model->cover))
        {
            $data['cover'] = (new ArticleImageFinder)->find($data['source'], $data['cover'], true);
        }

        empty($data['cover']) AND $data['cover'] = $this->model->cover;

        $data['body'] = $this->processBodyText($data['body']);
        $data['summary'] = $this->processSummaryText($data);

        $this->update($this->model, $data);

        $this->updateTags($this->model, @$data['tags']);

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

    public function getUnpinnedArticles($limit)
    {
        return $this->model->where('pinned', 0)
                           ->orderByDesc('id')
                           ->limit($limit)
                           ->get();
    }

    public function getLatestArticles($limit = null)
    {
        return $this->model->orderByDesc('id')
                           ->paginate($limit ?: static::PAGINATION_LIMIT);
    }

    public function getLatestRandomArticles()
    {
        return $this->model->where('created_at', '>', today()->subDays(3))
                           ->inRandomOrder()
                           ->limit(2)
                           ->get();
    }

    private function insertTags(Article $article, $tags_string)
    {
        if (! empty($tags_string))
        {
            $tags = $this->getTags($tags_string);

            return $article->tags()->saveMany($tags);
        }
    }

    private function updateTags(Article $article, $tags_string)
    {
        if (! empty($tags_string))
        {
            $tags = $this->getTags($tags_string);

            return $article->tags()->sync(collect($tags)->pluck('id'));
        }
    }

    private function getTags($tags_string)
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
