<?php include('partials/header.php'); ?>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Requests</h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">S. No.</th>
                            <th scope="col">Request Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Message</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
					    $query = "SELECT customer_requests.id, customer_requests.request_id AS request_id, customer_requests.quantity AS quantity, users.name AS customer_name, users.mobile AS customer_mobile, products.name AS product_name, customer_requests.message, customer_requests.created_at FROM customer_requests JOIN users ON customer_requests.user_id = users.id JOIN products ON customer_requests.product_id = products.id ORDER by id DESC";

					    $result = $conn->query($query);
					    $sno = '';
					    if ($result->num_rows > 0) {
					    	while($row = $result->fetch_assoc()) {
					    		$sno++;
					    ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
                        <td><a href="javascript:void(0)" onclick="showDetails(<?php echo $row['id']; ?>)"><?php echo $row['request_id']; ?></a></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['customer_mobile']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        
                        <td>
                        	<a class="btn btn-sm btn-danger" onclick="deleteRequest(<?php echo $row['id']; ?>)"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
<!-- Bootstrap Modal -->
<div class="modal fade" id="requestDetailsModal" tabindex="-1" aria-labelledby="requestDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestDetailsModalLabel">Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Customer Details Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Customer Details</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Name:</strong> <span id="customerName"></span></p>
                                        <p><strong>Mobile:</strong> <span id="customerMobile"></span></p>
                                        <p><strong>Email:</strong> <span id="customerEmail"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Request Date:</strong> <span id="requestDate"></span></p>
                                        <p><strong>Address Line 1:</strong> <span id="customerAddressOne"></span></p>
                                        <p><strong>Address Line 2:</strong> <span id="customerAddressTwo"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product Details Section -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <strong>Product Details</strong>
                            </div>
                            <div class="card-body">
                                <p><strong>Product Name:</strong> <span id="productName"></span></p>
                                <p><strong>Quantity:</strong> <span id="productQuantity"></span></p>
                                <p><strong>Price:</strong> <span id="productPrice"></span></p>
                                <p><strong>Short Description:</strong> <span id="productShortDescription"></span></p>
                                <p><strong>Long Description:</strong> <span id="productLongDescription"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <strong>Product Image</strong>
                            </div>
                            <div class="card-body d-flex justify-content-center align-items-center" style="height: 250px;">
                                <img id="productImage" src="" alt="Product Image" class="img-fluid" style="max-height: 200px; max-width: 100%; border: 1px solid #ddd; padding: 5px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    function showDetails(id) {
        $.ajax({
            type: 'POST',
            url: 'functions/requests/request-details.php', 
            data: { request_id: id },
            success: function(response) {
                const data = JSON.parse(response);
                
                $('#requestDetailsModalLabel').text("Request ID : "+data.request_id);

                $('#customerName').text(data.customer_name);
                $('#customerMobile').text(data.customer_mobile);
                $('#customerEmail').text(data.customer_email);
                $('#requestDate').text(data.request_date);
                $('#customerAddressOne').text(data.customer_address_one);
                $('#customerAddressTwo').text(data.customer_address_two);

                $('#productName').text(data.product_name);
                $('#productQuantity').text(data.product_quantity);
                $('#productPrice').text(data.product_price);

                $('#productShortDescription').text(data.product_short_description);
                $('#productLongDescription').text(data.product_long_description);
                    
                const productImageUrl = '../admin/product_images/' + data.product_image; 
                $('#productImage').attr('src', productImageUrl);

                $('#requestDetailsModal').modal('show');
            },
            error: function() {
                alert('Failed to fetch details. Please try again later.');
            }
        });
    }

    function deleteRequest(id) {
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
                    url: 'functions/requests/delete.php',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result == '1') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: 'Request deleted successfully.',
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!',
                            });
                        }
                    }
                });
            }
        });
    }

</script>


<?php include('partials/footer.php'); ?>
