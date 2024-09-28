<?php include('partials/header.php'); ?>

<?php 
$productQuery = "SELECT count(*) as total from products";
$resultProduct = $conn->query($productQuery);
$totalProducts = 0; 
if ($resultProduct) {
    $rowProduct = $resultProduct->fetch_assoc(); 
    $totalProducts = $rowProduct['total']; 
}


$categoriesQuery = "SELECT count(*) as total from categories";
$resultCategories = $conn->query($categoriesQuery);
$totalCategories = 0; 
if ($resultCategories) {
    $rowCategories = $resultCategories->fetch_assoc(); 
    $totalCategories = $rowCategories['total']; 
}

$customersQuery = "SELECT count(*) as total from users where type = 'C'";
$resultCustomers = $conn->query($customersQuery);
$totalCustomers = 0; 
if ($resultCustomers) {
    $rowCustomers = $resultCustomers->fetch_assoc(); 
    $totalCustomers = $rowCustomers['total']; 
}

$requestQuery = "SELECT count(*) as total from customer_requests";
$resultRequests = $conn->query($requestQuery);
$totalRequests = 0; 
if ($resultRequests) {
    $rowRequests = $resultRequests->fetch_assoc(); 
    $totalRequests = $rowRequests['total']; 
}

?>
    <script src="assets/lib/chart/chart.min.js"></script>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-4">
                <a href="products.php">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-shopping-cart fa-2x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2"><b>Products</b></p>
                            <h6 class="mb-0"><?php echo $totalProducts; ?></h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4">
                <a href="categories.php">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-list fa-2x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2"><b>Categories</b></p>
                            <h6 class="mb-0"><?php echo $totalCategories; ?></h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4">
                <a href="customers.php">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-users fa-2x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2"><b>Customers</b></p>
                            <h6 class="mb-0"><?php echo $totalCustomers; ?></h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3 d-none">
                <a href="requests.php">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-clipboard-list fa-2x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2"><b>Requests</b></p>
                            <h6 class="mb-0"><?php echo $totalRequests; ?></h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Monthly Customers</h6>
                    </div>
                    <canvas id="bar-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
            
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Recent Customers</h6>
                <a href="customers.php" class="btn btn-info"><b>See All</b></a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Address</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
					    $query = "SELECT * from users where type = 'C' order by id desc LIMIT 10";
					    $result = $conn->query($query);
					    $sno = '';
					    if ($result->num_rows > 0) {
					    	while($row = $result->fetch_assoc()) {
					    		$sno++;
					    ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['mobile']; ?></td>
                        <td><?php echo $row['address_one']; ?></td>
                        <td>
                            <div class="main-toggle main-toggle-success <?php if($row['status'] == 'A'){ ?> on <?php }?>" style="border-radius: 22px;" data-id="<?php echo $row['id']; ?>">
								<span style="border-radius: 22px;"></span>
								<input type="hidden" id="statusId_<?php echo $row['id']; ?>" value="<?php echo $row['status']; ?>">
							</div>
                        </td>
                        <td>
                        	<a class="btn btn-sm btn-danger" onclick="deleteCustomer(<?php echo $row['id']; ?>)"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'functions/dashboard/get_monthly_customers.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var labels = [];
                    var data = [];

                    response.forEach(function(item) {
                        labels.push(item.month); 
                        data.push(item.total_customers); 
                    });

                    var ctx4 = $("#bar-chart").get(0).getContext("2d");
                    var myChart4 = new Chart(ctx4, {
                        type: "bar",
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Monthly Customers",
                                backgroundColor: [
                                    "rgba(0, 156, 255, .7)",
                                    "rgba(0, 156, 255, .6)",
                                    "rgba(0, 156, 255, .5)",
                                    "rgba(0, 156, 255, .4)",
                                    "rgba(0, 156, 255, .3)"
                                ],
                                data: data
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Customers'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Month'
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data: ", error);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'functions/dashboard/get_monthly_requests.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var labels = [];
                    var data = [];

                    response.forEach(function(item) {
                        labels.push(item.month); 
                        data.push(item.total_requests); 
                    });

                    var ctx3 = $("#line-chart").get(0).getContext("2d");
                    var myChart3 = new Chart(ctx3, {
                        type: "line",
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Monthly Requests",
                                fill: false,
                                borderColor: "rgba(0, 156, 255, .7)",
                                backgroundColor: "rgba(0, 156, 255, .3)",
                                data: data
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Requests'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Month'
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data: ", error);
                }
            });
        });
    </script>

    <script>

    //function to toggle the switch
	$('.main-toggle').on('click', function() {
		$(this).toggleClass('on');

		var id = $(this).data('id');

	    var hiddenInput = $('#statusId_' + id);

	    if ($(this).hasClass('on')) {
	        hiddenInput.val('A'); 
	        updateStatus('I',id)
	    } else {
	        hiddenInput.val('I'); 
	        updateStatus('A',id)
	    }
	})

	//fucntion to update the status of coffee
	function updateStatus(status,id){
		$.ajax({
			type: 'POST',
			url: 'functions/customers/update-status.php',
			data: {
				status:status,
				id:id
			},
			success: function(result){
				if(result == '1'){
					console.log("status updated");
				}else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong! Please contact the admin.',
                    });
				}
			},
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request. Please try again.',
                });
            }
	  	});
	}

    function deleteCustomer(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'functions/customers/delete.php',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result == '1') {
                            Swal.fire({
                                icon: 'success',    
                                title: 'Deleted',
                                text: 'Customer deleted successfully.',
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong! Please try again.',
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while processing your request. Please try again.',
                        });
                    }
                });
            }
        });
    }


    </script>
<?php include('partials/footer.php'); ?>