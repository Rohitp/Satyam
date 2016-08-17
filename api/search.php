<?php

header('Content-Type: application/json');
include("dump.php");
include("db_func.php");

$q = $_REQUEST['query'];

$api_key = "";

$search_url = "http://api.themoviedb.org/3/search/movie?api_key=$api_key&query=$q";

$results = callUrl($search_url);
$results_json = json_decode($results, true);
//http://image.tmdb.org/t/p/w500/d4KNaTrltq6bpkFS01pYtyXa09m.jpg

$base_url = "http://image.tmdb.org/t/p/w500";
$movies_array = array();
foreach($results_json['results'] as $movie) {
  $movies_array[] = array("id" => $movie["id"], "title" => $movie["title"], "release" => $movie["release_date"], "description" => $movie["overview"], "poster" => $base_url.$movie["poster_path"], "rating" => $movie["vote_average"], "backdrop" => $base_url.$movie["backdrop_path"]);
}

// do_dump($movies_array);
// do_dump($results_json);

echo json_encode($movies_array);









?>
