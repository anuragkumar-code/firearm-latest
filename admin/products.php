<?php include('partials/header.php'); ?>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Products</h6>
                <a href="add-product.php" class="btn btn-primary">+ Product</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">Inventory No.</th>
                            <th scope="col">Manufacturer</th>
                            <th scope="col">Caliber</th>
                            <th scope="col">Price</th>
                            <th scope ="col">Model</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
					    $query = "SELECT * from products order by id desc";
					    $result = $conn->query($query);
					    $sno = '';
					    if ($result->num_rows > 0) {
					    	while($row = $result->fetch_assoc()) {
					    ?>
                    <tr>
                        <td><?php echo $row['inventory_number']; ?></td>
                        <td><?php echo $row['manufacturer']; ?></td>
                        <td><?php echo $row['caliber']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td>
                            <div class="main-toggle main-toggle-success <?php if($row['status'] == 'A'){ ?> on <?php }?>" style="border-radius: 22px;" data-id="<?php echo $row['id']; ?>">
								<span style="border-radius: 22px;"></span>
								<input type="hidden" id="statusId_<?php echo $row['id']; ?>" value="<?php echo $row['status']; ?>">
							</div>
                        </td>
                        <td>
                        	<a href="upload-images.php?product=<?php echo base64_encode($row['id']); ?>" class="btn btn-sm btn-secondary"><i class="fa fa-image"></i></a>
                        	<a href="edit-product.php?product=<?php echo base64_encode($row['id']); ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                        	<a class="btn btn-sm btn-danger" onclick="deleteProduct(<?php echo $row['id']; ?>)"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


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
			url: 'functions/product/update-status.php',
			data: {
				status:status,
				id:id
			},
			success: function(result){
				if(result == '1'){
					console.log("status updated");
				}else{
					alert('Something went wrong! Please contact admin.');
				}
			}
	  	});
	}

	function deleteProduct(id) {
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
                    url: 'functions/product/delete.php',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result == '1') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Product deleted successfully.'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong! Please try again.'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while processing your request. Please try again.'
                        });
                    }
                });
            }
        });
    }

</script>


<?php include('partials/footer.php'); ?>
