<?php

Flight::route('GET /connection-check', function(){
    // This will print the message from ExamDao constructor
    new ExamDao();
});

Flight::route('GET /customers', function(){
    $customers = Flight::examService()->get_customers();
    Flight::json($customers);
});

Flight::route('GET /customer/meals/@customer_id', function($customer_id){
    $meals = Flight::examService()->get_customer_meals($customer_id);
    Flight::json($meals);
});

Flight::route('POST /customers/add', function() {
    $data = Flight::request()->data->getData();
    $customer = [
        'first_name' => $data['first_name'] ?? '',
        'last_name' => $data['last_name'] ?? '',
        'birth_date' => $data['birth_date'] ?? ''
    ];
    $added = Flight::examService()->add_customer($customer);
    Flight::json($added);
});

Flight::route('GET /foods/report', function(){
    $page = (int)(Flight::request()->query['page'] ?? 1);
    $per_page = (int)(Flight::request()->query['per_page'] ?? 10);
    $report = Flight::examService()->foods_report($page, $per_page);
    Flight::json($report);
});

?>
