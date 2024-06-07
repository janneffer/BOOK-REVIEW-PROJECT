<!-- ==================== TRENDING SECTION ==================== -->
<section class="trending" id="trending">
    <div class="heading">
        <h2>TRENDING</h2>
    </div>
    
    <div class="trending-container">
        <?php
        // Query untuk mengambil data dari tabel trending beserta nama penulis dari tabel authors
        $sql = "SELECT t.*, a.author_name 
                FROM trending t 
                LEFT JOIN authors a ON t.author_id = a.author_id";
        $result = $conn->query($sql);

        // Periksa apakah ada baris yang dikembalikan dari query
        if ($result->num_rows > 0) {
            // Loop melalui setiap baris data
            while ($row = $result->fetch_assoc()) {
                // Menampilkan konten untuk setiap buku yang sedang tren
                echo '<div class="box">';
                echo '<a href="bookreview.php?book_id=' . $row['book_id'] . '">';
                echo '<div class="image">';
                echo '<img src="' . $row['cover_image'] . '" alt="' . $row['title'] . '">';
                echo '</div>';
                echo '<div class="content">';
                echo '<h4>' . $row['title'] . '</h4>';
                // Menampilkan nama penulis
                echo '<p>' . $row['author_name'] . '</p>';
                if ($row['total_rating'] != null) {
                    echo '<h5>' . $row['total_rating'] . '<span>/5</span></h5>';
                } else {
                    // Jika peringkat tidak tersedia
                    echo '<h5>Not yet reviewed</h5>';
                }
                echo '</div>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            // Jika tidak ada data yang tersedia
            echo '<p>No trending books available</p>';
        }
        ?>
    </div>
</section>
