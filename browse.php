<?php
    include 'dbconn.php';
    include 'header.php';

    // Inisialisasi variabel pencarian
    $search_query = "";

    // Periksa apakah ada input pencarian dari pengguna
    if(isset($_GET['search'])) {
        $search_query = $_GET['search'];
        $search_query_safe = $conn->real_escape_string($search_query); // Membersihkan input

        // Query untuk mencari buku berdasarkan judul atau nama penulis yang cocok dengan input pencarian
        $sql = "SELECT b.*, a.author_name, CONCAT_WS(' ', b.desc_1, b.desc_2, b.desc_3) AS short_description
                FROM books b
                INNER JOIN authors a ON b.author_id = a.author_id
                WHERE LOWER(b.title) LIKE LOWER('%$search_query_safe%') OR LOWER(a.author_name) LIKE LOWER('%$search_query_safe%')
                ORDER BY b.title ASC";
        $result = $conn->query($sql);
    } else {
        // Jika tidak ada input pencarian, tampilkan semua buku
        $sql = "SELECT b.*, a.author_name, CONCAT_WS(' ', b.desc_1, b.desc_2, b.desc_3) AS short_description
                FROM books b
                INNER JOIN authors a ON b.author_id = a.author_id
                ORDER BY b.title ASC";
        $result = $conn->query($sql);
    }
?>

<section class="browsing" id="browsing">
    <form method="GET">
        <div class="search">
            <i class='bx bx-search'></i>
            <i class='bx bx-x clear-icon'></i>
            <input type="text" name="search" placeholder="Search Book" value="<?php echo $search_query; ?>">
        </div>
        <button type="submit" style="display: none;">Submit</button>
    </form>

    <div class="filter-container">
        <div class="filters">
            <h3>Filter</h3>
            <button class="show-button" id="show-button"><i class='bx bx-chevron-down'></i></button>
            <div class="options">
                <div class="genres">
                    <h4>Genre</h4>
                    <ul>
                        <?php
                            // Query untuk mengambil daftar genre dari database
                            $genreSql = "SELECT * FROM genres ORDER BY genre_name ASC";
                            $genreResult = $conn->query($genreSql);

                            if ($genreResult->num_rows > 0) {
                                while($genreRow = $genreResult->fetch_assoc()) {
                                    echo "<li><input type='checkbox' id='" . $genreRow['genre_id'] . "' name='genre' value='" . $genreRow['genre_name'] . "'><label for='" . $genreRow['genre_id'] . "'>" . $genreRow['genre_name'] . "</label></li>";
                                }
                            } else {
                                echo "Tidak ada data genre.";
                            }
                        ?>
                    </ul>
                </div>
                <div class="years">
                    <h4>Year</h4>
                    <ul>
                        <?php
                            // Query untuk mengambil daftar tahun dari data buku yang ada di database
                            $yearSql = "SELECT DISTINCT YEAR(first_publish) AS year FROM books ORDER BY year ASC";
                            $yearResult = $conn->query($yearSql);

                            if ($yearResult->num_rows > 0) {
                                while($yearRow = $yearResult->fetch_assoc()) {
                                    echo "<li><input type='checkbox' id='" . $yearRow['year'] . "' name='year' value='" . $yearRow['year'] . "'><label for='" . $yearRow['year'] . "'>" . $yearRow['year'] . "</label></li>";
                                }
                            } else {
                                echo "Tidak ada data tahun.";
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <button class="apply-button">Apply</button>
        </div>                
    </div>                          
    
    <!-- Tampilkan hasil pencarian atau semua buku -->
    <div class="books-container">
        <?php
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
                    echo "</div>";
                    echo "</a>";
                }
            } else {
                echo "Tidak ada hasil yang ditemukan.";
            }
        ?>
    </div>
</section>

<?php
    include 'footer.php';
    $conn->close();
?>
