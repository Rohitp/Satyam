<?php

header('Content-Type: application/json');
include("dump.php");
include("db_func.php");

// mO-62VxpLe0C hitchhikers
//238 the godfather
$id = $_REQUEST['id'];

$api_key = "";

$search_url = "http://api.themoviedb.org/3/movie/$id?api_key=$api_key&id=$id";
$base_url = "http://image.tmdb.org/t/p/w500";

$results = callUrl($search_url);
$movie = json_decode($results, true);

if(!isset($movie['tagline'])) {
  $movie['tagline'] = "";
}
$movies_array = array(
  "id" => $movie["id"], "title" => $movie["title"], "tagline" => $movie['tagline'],
  "budget" => $movie["budget"], "revenue" => $movie["revenue"], "imdb" => $movie["imdb_id"],
  "genre" => $movie["genres"], "release" => $movie["release_date"], "description" => $movie["overview"],
  "poster" => $base_url.$movie["poster_path"], "rating" => $movie["vote_average"], "backdrop" => $base_url.$movie["backdrop_path"]);

// do_dump($movies_array);

echo json_encode($movies_array);









?>
