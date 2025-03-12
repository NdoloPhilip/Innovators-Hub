<?php
// Search & Filter Projects (projects/search_filter_projects.php)
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $search = isset($_GET['search']) ? '%' . trim($_GET['search']) . '%' : '%';
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';
    $status = isset($_GET['status']) ? trim($_GET['status']) : '';
    
    $query = "SELECT p.id, p.title, p.description, p.category, p.status, p.created_at, u.name AS innovator, 
                     COALESCE(SUM(f.amount), 0) AS total_funding 
              FROM projects p 
              JOIN users u ON p.user_id = u.id 
              LEFT JOIN funding f ON p.id = f.project_id 
              WHERE (p.title ILIKE ? OR p.description ILIKE ?)
              ";
    
    $params = [$search, $search];
    
    if (!empty($category)) {
        $query .= " AND p.category = ?";
        $params[] = $category;
    }
    
    if (!empty($status)) {
        $query .= " AND p.status = ?";
        $params[] = $status;
    }
    
    $query .= " GROUP BY p.id, u.name ORDER BY p.created_at DESC";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($projects);
    } catch (PDOException $e) {
        die("Error fetching filtered projects: " . $e->getMessage());
    }
}
?>
