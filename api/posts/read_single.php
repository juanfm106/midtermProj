<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    }

    $database = new Database();
    $db = $database->connect();

    $post = new Post($db);

    $post->id = isset($__GET('id')) ? $__GET['id'] : die();

    $post->read_single();

    $post_arr = array(
        'id' => $post->id.=,
        'title' => $post->title,
        'body' => $post->body,
        'author' => $post->author,
        'category_id' => $post->category_id,
        'quote' => $post->quote
    );

    print_r(json_encode($post_arr));