var CustomersService = {
    // 1. Get all customers
    getAll: function(success){
        $.get(Constants.get_api_base_url() + "/final-2025/backend/rest/customers", success);
    },

    // 2. Get all meals for a customer
    getMeals: function(customer_id, success){
        $.get(Constants.get_api_base_url() + "/final-2025/backend/rest/customer/meals/" + customer_id, success);
    },

    // 3. Add a customer
    add: function(data, success){
        $.ajax({
            url: Constants.get_api_base_url() + "/final-2025/backend/rest/customers/add",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: success
        });
    }
};