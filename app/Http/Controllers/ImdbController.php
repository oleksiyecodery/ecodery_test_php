<?php

namespace App\Http\Controllers;

use App\User;

class ImdbController extends Controller
{
    public function showTop($page = 0)
    {
        $data = json_decode(
            file_get_contents('https://raw.githubusercontent.com/Omertron/api-imdb/master/JSON/chart-top.json'),
            true
        );

        $movies = $data['data']['list']['list'];

        $perPage = env('IMDB_PER_PAGE');
        return response()->json(array_slice($movies, $page * $perPage, $perPage));
    }
}