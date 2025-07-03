<?php
require_once __DIR__."/../dao/ExamDao.php";

class ExamService {
    protected $dao;

    public function __construct(){
        $this->dao = new ExamDao();
    }

    // Get all customers
    public function get_customers(){
        return $this->dao->get_customers();
    }

    // Get all meals for a customer
    public function get_customer_meals($customer_id){
        return $this->dao->get_customer_meals($customer_id);
    }

    // Add a customer to the database
    public function add_customer($customer){
        return $this->dao->add_customer($customer);
    }

    // Return paginated foods report
    public function foods_report($page = 1, $per_page = 10){
        $offset = ($page - 1) * $per_page;
        $foods = $this->dao->get_foods_report($offset, $per_page);
        $total = $this->dao->get_foods_count();
        return [
            'foods' => $foods,
            'total' => $total,
            'page' => $page,
            'per_page' => $per_page
        ];
    }
}
?>
