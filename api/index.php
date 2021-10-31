<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-type: json/application');




require 'connect.php';
require 'function.php';

$connect = mysqli_connect('localhost', 'root', '', 'carcatalog');
$method = $_SERVER['REQUEST_METHOD'];
$typ = $_SERVER['QUERY_STRING'];
$params = explode('/', $typ);


$typ = $params[0];
$category_id = $params[1];
$car_id = $params[2];
if ($method === 'GET')
{
    if ($typ === 'cars')
    {
        if (isset($category_id))
        {
            getCar($connect, $category_id);
        }
        else
        {
            getCars($connect);
        }
    }
    elseif ($typ === 'users')
    {
        startSession($connect, $category_id, $car_id);
    }
}
elseif ($method === 'POST')
{
    if($typ === 'cars')
    {
        addCars($connect, $_POST);
    }
    elseif ($typ === 'users')
    {
        addUsers($connect, $_POST);
    }
}
elseif ($method === 'DELETE')
{
    if ($typ === 'cars')
    {
        if (isset($car_id))
        {
            deletePost($connect, $car_id);
        }
    }
}




