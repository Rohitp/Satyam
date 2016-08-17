<?php
header('Content-Type: application/json');

include("dump.php");
include("db_func.php");

// mO-62VxpLe0C

$id = $_REQUEST['id'];


$api_key = "74f2525774f1156eb39d747e4a3e0251";

$search_url = "http://api.themoviedb.org/3/movie/$id/similar?api_key=$api_key&id=$id";
$base_url = "http://image.tmdb.org/t/p/w500";

$results = callUrl($search_url);
$results_json = json_decode($results, true);
$movies_array = array();

$i = 0;
foreach($results_json['results'] as $movie) {
    if($i > 5) {
      break;
    }
    $movies_array[] = array("id" => $movie["id"], "title" => $movie["title"], "release" => $movie["release_date"], "description" => $movie["overview"], "poster" => $base_url.$movie["poster_path"], "rating" => $movie["vote_average"], "backdrop" => $base_url.$movie["backdrop_path"]);
    $i++;
}
// do_dump($results_json);

echo json_encode(array("books" => $movies_array));










?>
