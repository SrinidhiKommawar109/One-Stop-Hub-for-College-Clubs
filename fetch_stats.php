<?php
// fetch_stats.php
include 'db.php';

$stats = [];
$sql = "SELECT 
            (SELECT COUNT(*) FROM clubs) as total_clubs, 
            (SELECT COUNT(*) FROM events) as total_events,
            (SELECT COUNT(DISTINCT username) FROM form) as total_form, -- Updated query for unique usernames
            (SELECT COUNT(*) FROM admin) as total_admin,
            (SELECT COUNT(*) FROM nss) as total_nss,
            (SELECT COUNT(*) FROM liveware) as total_livewire";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $stats = $result->fetch_assoc();
}

$conn->close();

echo json_encode($stats);
?>
