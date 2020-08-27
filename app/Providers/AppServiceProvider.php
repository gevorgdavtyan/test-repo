<?php

namespace App\Providers;

use App\Support\TagsUtility;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // Custom validation for video tags
        Validator::extend('tags', function ($attribute, $value, $parameters, $validator) {
            $rules = [
                'tag' => 'required|max:50|regex:/^[A-Za-z0-9 -]*$/',
            ];
            $tags = TagsUtility::convert_tags_string_to_array($value);
            if ($tags) {
                foreach ($tags as $tag) {
                    $data = ['tag' => $tag];
                    $validator = Validator::make($data, $rules);
                    if ($validator->fails()) {
                        return false;
                    }
                }
            }
            return true;
        }, 'The :attribute should be in right format');
    }
}
