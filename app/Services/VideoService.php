<?php

namespace App\Services;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;

class VideoService extends Model
{

    /**
     * @param $request
     * @param null $id
     * @return array
     */
    public function store_or_update($request, $id = null)
    {
        $method = ($id) ? 'PUT' : 'POST';
        if ($request->isMethod($method)) {
            if ($id) {
                $video = Video::find($id);
                if (!$video) {
                    return [
                        'error' => true,
                        'message' => 'Video not found.'
                    ];
                }
                $message_r = 'Video successfully edited.';
            } else {
                $message_r = 'Video successfully added.';
            }

            $rules = [
                'name' => 'required|max:50',
                'description' => 'required',
                'tags' => 'required|tags',  // custom validation "tags" in app/Providers/AppServiceProvider.php
            ];
            $request->validate($rules);

            if (!$id) {
                $video = new Video();
            }
            $video->name = $request->input('name');
            $video->description = $request->input('description');
            $video->save();
            $video->saveTags($request->input('tags'));

            return [
                'error' => false,
                'message' => $message_r
            ];
        }
    }

    /**
     * @param $params
     * @return mixed
     */
    public function searchVideosByNameStartAndEnd($params)
    {
        $search_name_starting = trim((string)$params['name_starting']);
        $search_name_ending = trim((string)$params['name_ending']);

        return Video::orWhere('name', 'like', $search_name_starting . '%')
            ->orWhere('name', 'like', '%' . $search_name_ending)->simplePaginate($this->paginate)
            ->appends($params);
    }
}
