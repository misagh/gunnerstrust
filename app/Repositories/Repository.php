<?php

namespace App\Repositories;

use App\Services\ArticleImageFinder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository {

    const PAGINATION_LIMIT = 20;

    /**
     * @var Model
     */
    protected $model;

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findBy($field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    public function findByOrFail($field, $value)
    {
        if ($result = $this->findBy($field, $value))
        {
            return $result;
        }

        abort(404);
    }

    public function create($data)
    {
        $data = array_only($data, $this->getColumns($this->model));

        return $this->model->create($data);
    }

    public function update(Model $model, $data)
    {
        $data = array_only($data, $this->getColumns($this->model));

        return $model->update($data);
    }

    public function updateOrCreate($attrs, $values)
    {
        return $this->model->updateOrCreate($attrs, $values);
    }

    public function getSimplePaginated()
    {
        return $this->model->paginate(static::PAGINATION_LIMIT);
    }

    public function getAllRecords()
    {
        return $this->model->get()->all();
    }

    public function getColumns()
    {
        return $this->model->getConnection()
                           ->getSchemaBuilder()
                           ->getColumnListing($this->model->getTable());
    }

    public function getSlug($string)
    {
        $slug = str_replace(['،', '"', ':', '-', ',', '!', '.', '|', '#', '%', '&', '*', '(', ')', '=', '_', '+', '/', '[', ']'], '', $string);
        $slug = remove_extra_space($slug);
        $slug = str_replace(' ', '-', $slug);
        $slug_last = $this->model->where('slug', 'LIKE', $slug . '%')->orderByDesc('id')->first();

        $index = null;

        if (! empty($slug_last))
        {
            $slug_index = last(explode('-', $slug_last->slug));

            $index = is_numeric($slug_index) ? $slug_index + 1 : 1;
        }

        return $slug . ($index ? '-' . $index : '');
    }

    public function processBodyText($body)
    {
        $body = clean($body);

        preg_match_all('/src="data([^\"]*)"/i', $body, $matches);

        if ($images = @$matches[1])
        {
            foreach ($images as $key => $image)
            {
                $image = 'data' . $image;

                [$mime, $content] = explode(';', $image);
                [, $content] = explode(',', $content);
                $content = base64_decode($content);

                $mime = explode(':', $mime)[1];
                $ext = explode('/', $mime)[1];
                $file_name = sha1(time() . $key) . '.' . $ext;
                $path = storage_path('app/uploads/' . $file_name);

                file_put_contents($path, $content);

                (new ArticleImageFinder)->optimize($path, 728, null);

                $body = str_replace($image, asset('img/uploads/' . $file_name), $body);
            }
        }

        return $body;
    }
}
