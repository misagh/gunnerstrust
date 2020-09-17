<?php

namespace App\Repositories;

use App\Update;

class UpdateRepository extends Repository {

    public function __construct(Update $update = null)
    {
        $this->model = $update ?: new Update();
    }

    public function insertUpdate($data)
    {
        $data['user_id'] = $data['user_id'] ?? auth()->id();

        $data = $this->processBodyText($data);

        $update = $this->create($data);

        $this->syncCategories($update, @$data['categories']);
        $this->insertTags($update, @$data['tags']);

        return $update;
    }

    public function updateUpdate($data)
    {
        $data = $this->processBodyText($data);

        $this->update($this->model, $data);

        $this->syncCategories($this->model, @$data['categories']);
        $this->updateTags($this->model, @$data['tags']);

        return $this->model;
    }

    public function getLatestUpdates()
    {
        return $this->model->with(['user', 'categories'])
                           ->with(['comments' => function ($query)
                           {
                               $query->orderBy('id', 'desc')->limit(1);
                           }])
                           ->withCount('comments')
                           ->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    private function syncCategories(Update $update, $categories)
    {
        if (! empty($categories))
        {
            return $update->categories()->sync(array_map('intval', $categories));
        }
    }

    private function insertTags(Update $update, $tags_string)
    {
        if (! empty($tags_string))
        {
            $tags = $this->getTags($tags_string);

            return $update->tags()->saveMany($tags);
        }
    }

    private function updateTags(Update $update, $tags_string)
    {
        if (! empty($tags_string))
        {
            $tags = $this->getTags($tags_string);

            return $update->tags()->sync(collect($tags)->pluck('id'));
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

    public function processBodyText($data)
    {
        $url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~iu';
        $hashtag = '/#(\w+)/u';

        $data['body'] = nl2br($data['body']);
        $data['body'] = preg_replace($url, '<a href="$0" target="_blank">$0</a>', $data['body']);
        $data['body'] = preg_replace($hashtag, '<a href="' . route('tags.index') . '/$1" target="_blank">#$1</a>', $data['body']);

        preg_match_all($hashtag, $data['body'], $tags);

        if ($tag_list = @$tags[1])
        {
            $data['tags'] = implode(',', $tag_list);
        }

        return $data;
    }
}
