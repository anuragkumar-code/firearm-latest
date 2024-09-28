<?php
include('../../config/db.php'); 

$categories = $_POST['categories'];
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 9; 
$offset = ($page - 1) * $limit;

$categoryFilter = "";
if (!empty($categories)) {
    $categoryFilter = "AND category_id IN (" . implode(',', array_map('intval', $categories)) . ")";
}

$totalQuery = "SELECT COUNT(*) as total FROM products WHERE status = 'A' $categoryFilter";
$totalResult = $conn->query($totalQuery);
$totalProducts = $totalResult->fetch_assoc()['total'];

$productsQuery = "SELECT * FROM products WHERE status = 'A' $categoryFilter LIMIT $limit OFFSET $offset";
$productsResult = $conn->query($productsQuery);

$html = '';
while ($productRow = $productsResult->fetch_assoc()) {
    
    // $currentDate = new DateTime();
    // $createdDate = new DateTime($productRow['created_at']);
    // $interval = $currentDate->diff($createdDate);
    // $daysDifference = $interval->days;
    // $isNew = $daysDifference <= 10;

    $html .= '<div class="col-sm-6 col-xl-4">';
    $html .= '  <a href="product-details.php?id='.base64_encode($productRow['id']).'">';
    $html .= '      <div class="product-card">';
    // if ($isNew) {
    //     $html .= '          <span class="product-badge">new</span>';
    // }
    $html .= '          <div class="product-img">';

    $imageSrc = !empty($productRow['master_image']) ? 'admin/product_images/' . htmlspecialchars($productRow['master_image']) : 'admin/product_images/error.png';
    
    $html .= '              <img src="' . $imageSrc . '" alt="' . htmlspecialchars($productRow['manufacturer']) . '">';
    $html .= '          </div>';
    $html .= '          <div class="product-content d-flex justify-content-between align-items-center mb-4">';
    $html .= '              <span><b>' . htmlspecialchars($productRow['manufacturer']) . '</b></span>';
    $html .= '              <span><b>$' . htmlspecialchars($productRow['price']) . '</b></span>';
    $html .= '          </div>';
    $html .= '          <div class="view-product-button mt-1">View Product</div>';
    $html .= '      </div>';
    $html .= '  </a>';
    $html .= '</div>';

}

$totalPages = ceil($totalProducts / $limit);
$pagination = '';

$range = 2; 
$start = max(1, $page - $range);
$end = min($totalPages, $page + $range);

if ($page > 1) {
    $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(1)">«</a></li>';
}

if ($page > 1) {
    $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(' . ($page - 1) . ')">‹</a></li>';
}

if ($start > 1) {
    $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(1)">1</a></li>';
    if ($start > 2) {
        $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }
}

for ($i = $start; $i <= $end; $i++) {
    $active = $page == $i ? 'active' : '';
    $pagination .= '<li class="page-item"><a class="page-link ' . $active . '" href="javascript:void(0);" onclick="goToPage(' . $i . ')">' . $i . '</a></li>';
}

if ($end < $totalPages) {
    if ($end < $totalPages - 1) {
        $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }
    $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(' . $totalPages . ')">' . $totalPages . '</a></li>';
}

if ($page < $totalPages) {
    $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(' . ($page + 1) . ')">›</a></li>';
}

if ($page < $totalPages) {
    $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(' . $totalPages . ')">»</a></li>';
}

echo json_encode(['html' => $html, 'pagination' => $pagination]);
?>
