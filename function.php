<?php
/**
 * @OA\Info(title="Пример доки к API", version="0.1")
 */

/**
 * @OA\Get(
 *     path="/api/resource.json",
 *     @OA\Response(response="200", description="Чтобы как-то начать ;)")
 * )
 */

function getCars ($connect)
{
    $cars = mysqli_query($connect, "SELECT * FROM `catalog`");
    $carsList = [];
    while ($car = mysqli_fetch_assoc($cars))
    {
        $carsList[] = $car;
    }
    echo json_encode($carsList);
}

function getCar ($connect, $category_id)
{
    $car = mysqli_query($connect, "SELECT * FROM `catalog` WHERE  `category_id` = '$category_id'");
    $carLists = [];
    if (mysqli_num_rows($car) === 0)
    {
        http_response_code(404);
        $res = [
            "status" => false,
            "message" => "Category not found"
        ];
        echo json_encode($res);
    }
    else
    {
        while ($cars = mysqli_fetch_assoc($car))
        {
            $carLists[] = $cars;
        }
        echo json_encode($carLists);
    }
}

function addCars ($connect, $data)
{
    $brand = $data['brand'];
    $model = $data['model'];
    $category_id = $data['category_id'];
    mysqli_query($connect, "INSERT INTO carcatalog.catalog(brand, model, category_id)
VALUES
('$brand', '$model', '$category_id')");

    http_response_code(201);

   $res = [
       "status" => true,
       "car_id" => mysqli_insert_id($connect)
   ];
   echo json_encode($res);
}

function deleteCar ($connect, $id)
{
    mysqli_query($connect, "DELETE FROM `catalog` WHERE  `id` = '$id'");

    http_response_code(201);

    $res = [
        "status" => true,
        "massage" => "Car is deleted"
    ];
    echo json_encode($res);
}

function addUsers ($connect, $data)
{
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];
    mysqli_query($connect, "INSERT INTO carcatalog.users(name, email, password)
VALUES
('$name', '$email', '$password')");

    http_response_code(201);

    $res = [
        "status" => true,
        "massage" => "User added successfully"
    ];
    echo json_encode($res);

}

function startSession($connect, $email, $password)
{
    $user = mysqli_query($connect, "SELECT * FROM `users` WHERE  `email` = '$email' AND `password` = '$password'");
    $userLists = [];
    if (mysqli_num_rows($user) === 0)
    {
        http_response_code(404);
        $res = [
            "status" => false,
            "message" => "User not found"
        ];
        echo json_encode($res);
    }
    elseif (mysqli_num_rows($user) !== 0)
    {
        session_start();
        http_response_code(200);
        $res = [
            "status" => true,
            "message" => "User found"
        ];
        echo json_encode($res);
    }

}