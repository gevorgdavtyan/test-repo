<?php

namespace App\Models;

use App\Support\TagsUtility;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'name', 'description', 'tags'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'videos_tags',
            'video_id',
            'tag_id');
    }

    /**
     * @return string
     */
    public function tagsNames()
    {
        return implode(',', $this->tags()->pluck('name')->toArray());
    }

    /**
     * @param $tagsText
     * @return array
     */
    public function saveTags($tagsText)
    {
        $tagIds = [];
        $tagsArray = TagsUtility::convert_tags_string_to_array(strtolower($tagsText));
        foreach ($tagsArray as $item) {
            $tag = Tag::where('name', $item)->first();
            if (!$tag) {
                $tag = new Tag();
                $tag->name = $item;
                $tag->save();
            }
            $tagIds[] = $tag->id;
        }
        return $this->tags()->sync($tagIds);
    }

}
