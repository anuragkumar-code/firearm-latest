<?php include('partials/header.php'); ?>

<main id="main-content" class="position-relative">
    <section class="page-title position-relative">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">SHOP</li>
                </ol>
            </nav>
        </div>
    </section>
    <section class="product inner-gap" style="padding:40px 0">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-xl-3">
                    <div class="accordion accordion-bdp" id="accordionExample">
                        <div class="accordion-item">
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="filter-wrapper filter-wrapper-pp">
                                        <h6>CATEGORIES</h6>
                                        <ul class="filter-category-pp">
                                            <?php
                                            $categoriesQuery = "SELECT * FROM categories WHERE status = 'A'";
                                            $categoriesResult = $conn->query($categoriesQuery);
                                            while ($categoriesRow = $categoriesResult->fetch_assoc()) { ?>
                                                <li>
                                                    <div class="form-check">
                                                        <input onchange="categoryFilter(1)" class="form-check-input category-checkbox" type="checkbox" 
                                                            value="<?php echo $categoriesRow['id']; ?>" 
                                                            id="flexCheckDefault_<?php echo $categoriesRow['id']; ?>" 
                                                            checked> 
                                                        <label class="form-check-label" for="flexCheckDefault_<?php echo $categoriesRow['id']; ?>">
                                                            <?php echo htmlspecialchars($categoriesRow['name']); ?>
                                                        </label>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div id="product-list" class="row justify-content-center gy-3">

                    </div>

                    <div class="col-12 mt-4 mt-md-5">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center gap-2 gap-md-3" id="pagination-links">

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    function categoryFilter(page = 1) {
        var selectedCategories = [];
        $('.category-checkbox:checked').each(function() {
            selectedCategories.push($(this).val());
        });

        $.ajax({
            type: 'POST',
            url: 'functions/product/category-filter.php',
            data: {
                categories: selectedCategories,
                page: page
            },
            success: function(response) {
                var result = JSON.parse(response);
                $('#product-list').html(result.html);
                $('#pagination-links').html(result.pagination);
            },
            error: function() {
                alert('An error occurred while fetching the products.');
            }
        });
    }

    function goToPage(page) {
        categoryFilter(page);
    }

    setTimeout(()=>{
        categoryFilter(); 
    },1000);
</script>

<?php include('partials/footer.php'); ?>
