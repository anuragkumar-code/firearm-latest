<?php include('partials/header.php'); ?>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Customers</h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">S. No.</th>
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
					    $query = "SELECT * from users where type = 'C' order by id desc";
					    $result = $conn->query($query);
					    $sno = '';
					    if ($result->num_rows > 0) {
					    	while($row = $result->fetch_assoc()) {
					    		$sno++;
					    ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
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
