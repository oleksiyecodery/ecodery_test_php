<?php

namespace App\Http\Controllers;

use Cache;

class ImdbController extends Controller
{
    public function showTop($page = 0)
    {
        if (Cache::has('imdb_' . $page)) {
            return Cache::get('imdb_' . $page);
        }

        $data = json_decode(
            file_get_contents('https://raw.githubusercontent.com/Omertron/api-imdb/master/JSON/chart-top.json'),
            true
        );

        $movies = $data['data']['list']['list'];

        $perPage = env('IMDB_PER_PAGE');
        $response = response()->json([
            'page' => $page,
            'maxPage' => ceil(count($movies) / $perPage),
            'movies' => array_slice($movies, $page * $perPage, $perPage),
        ]);

        Cache::forever('imdb_' . $page, $response);

        return $response;
    }
}