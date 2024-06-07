<?php
include 'dbconn.php';

// Ambil data filter dari permintaan
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$genres = isset($_GET['genres']) ? json_decode($_GET['genres']) : array();
$years = isset($_GET['years']) ? json_decode($_GET['years']) : array();

// Buat query berdasarkan filter yang diterapkan
$sql = "SELECT b.*, a.author_name, CONCAT_WS(' ', b.desc_1, b.desc_2, b.desc_3) AS short_description
        FROM books b
        INNER JOIN authors a ON b.author_id = a.author_id";

if (!empty($searchQuery)) {
    $search_query_safe = $conn->real_escape_string($searchQuery);
    $sql .= " WHERE LOWER(b.title) LIKE LOWER('%$search_query_safe%') OR LOWER(a.author_name) LIKE LOWER('%$search_query_safe%')";
}

if (!empty($genres)) {
    $genreConditions = implode("','", $genres);
    $sql .= " INNER JOIN book_genre bg ON b.book_id = bg.book_id
              INNER JOIN genres g ON bg.genre_id = g.genre_id
              WHERE g.genre_name IN ('$genreConditions')";
}

if (!empty($years)) {
    $yearConditions = implode(",", $years);
    $sql .= (empty($searchQuery) && empty($genres) ? " WHERE" : " AND") . " YEAR(first_publish) IN ($yearConditions)";
}

$sql .= " ORDER BY b.title ASC";

$result = $conn->query($sql);

// Tampilkan hasil dalam format HTML
if ($result->num_rows > 0) {
    while($bookRow = $result->fetch_assoc()) {
        echo "<a href='bookreview.html' class='books'>";
            echo "<div class='image'>";
            echo "<img src='" . $bookRow['cover_image'] . "' alt='Deskripsi gambar'>";
            echo "</div>";
            echo "<div class='content'>";
            echo "<h4>" . $bookRow['title'] . "</h4>";
            echo "<h5>" . $bookRow['author_name'] . "</h5>";
            echo "<p>" . $bookRow['short_description'] . "</p>";

            // Ambil genre dari database
            $book_id = $bookRow['book_id']; // Pastikan nama kolom sesuai dengan tabel Anda
            $genre_query = "SELECT g.genre_name FROM genres g
                            INNER JOIN book_genre bg ON g.genre_id = bg.genre_id
                            WHERE bg.book_id = $book_id";
            $genre_result = $conn->query($genre_query);
            if ($genre_result->num_rows > 0) {
                echo "<h5>Genre: ";
                while($genreRow = $genre_result->fetch_assoc()) {
                    echo $genreRow['genre_name'] . ", ";
                }
                echo "</h5>";
            }

            echo "</div>";
            echo "</a>";
    }
} else {
    echo "Tidak ada hasil yang ditemukan.";
}

$conn->close();
?>
