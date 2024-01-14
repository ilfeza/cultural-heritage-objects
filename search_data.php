<?php

include "db.php";

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];

    $sql = "SELECT `Номер в реестре`, `Объект`, `id` FROM course WHERE `Объект` LIKE N'%$searchTerm%' LIMIT 100";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<p><a href="search_details.php?id=' . $row['Номер в реестре'] . '">' . $row['Объект'] . '</a></p>';
        }
    } else {
        echo '<p>No results found</p>';
    }
}
$conn->close();

?>
