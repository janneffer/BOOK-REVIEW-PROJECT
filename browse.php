<?php
    include 'dbconn.php';
    include 'header.php';

    // Fungsi untuk membersihkan input
    function cleanInput($conn, $input) {
        return $conn->real_escape_string($input);
    }

    // Fungsi untuk mendapatkan daftar genre
    function getGenres($conn) {
        $genreSql = "SELECT * FROM genres ORDER BY genre_name ASC";
        $genreResult = $conn->query($genreSql);

        $genres = array();
        if ($genreResult->num_rows > 0) {
            while($genreRow = $genreResult->fetch_assoc()) {
                $genres[] = $genreRow;
            }
        }
        return $genres;
    }

    // Fungsi untuk mendapatkan daftar tahun
    function getYears($conn) {
        $yearSql = "SELECT DISTINCT YEAR(first_publish) AS year FROM books ORDER BY year ASC";
        $yearResult = $conn->query($yearSql);

        $years = array();
        if ($yearResult->num_rows > 0) {
            while($yearRow = $yearResult->fetch_assoc()) {
                $years[] = $yearRow;
            }
        }
        return $years;
    }

    // Fungsi untuk menampilkan buku
    function displayBooks($result, $conn) {
    if ($result->num_rows > 0) {
        while ($bookRow = $result->fetch_assoc()) {
            $book_id = $bookRow['book_id'];
            
            echo "<a href='bookreview.php?book_id=" . $book_id . "' class='books'>";
            echo "<div class='image'>";
            echo "<img src='" . $bookRow['cover_image'] . "' alt='Deskripsi gambar'>";
            echo "</div>";
            echo "<div class='content'>";
            echo "<h4>" . htmlspecialchars($bookRow['title']) . "</h4>";
            echo "<h5>" . htmlspecialchars($bookRow['author_name']) . "</h5>";
            echo "<p>" . $bookRow['short_description'] . "</p>";

            // Fetch genre from the database
            $genre_query = "SELECT g.genre_name FROM genres g
                            INNER JOIN book_genre bg ON g.genre_id = bg.genre_id
                            WHERE bg.book_id = $book_id";
            $genre_result = $conn->query($genre_query);
            if ($genre_result->num_rows > 0) {
                echo "<h5>Genre: ";
                while ($genreRow = $genre_result->fetch_assoc()) {
                    echo htmlspecialchars($genreRow['genre_name']) . ", ";
                }
                echo "</h5>";
            }

            echo "</div>";
            echo "</a>";
        }
    } else {
        echo "Tidak ada hasil yang ditemukan.";
    }
}


    // Inisialisasi variabel pencarian
    $search_query = "";

    // Periksa apakah ada input pencarian dari pengguna
    if(isset($_GET['search'])) {
        $search_query = $_GET['search'];
        $search_query_safe = cleanInput($conn, $search_query);

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
                <div class="genres" id="genre-filter">
                    <h4>Genre</h4>
                    <ul>
                        <?php
                            $genres = getGenres($conn);
                            foreach ($genres as $genreRow) {
                                echo "<li><input type='checkbox' id='" . $genreRow['genre_id'] . "' name='genre' value='" . $genreRow['genre_name'] . "'><label for='" . $genreRow['genre_id'] . "'>" . $genreRow['genre_name'] . "</label></li>";
                            }
                        ?>
                    </ul>
                </div>
                <div class="years" id="year-filter">
                    <h4>Year</h4>
                    <ul>
                        <?php
                            $years = getYears($conn);
                            foreach ($years as $yearRow) {
                                echo "<li><input type='checkbox' id='" . $yearRow['year'] . "' name='year' value='" . $yearRow['year'] . "'><label for='" . $yearRow['year'] . "'>" . $yearRow['year'] . "</label></li>";
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
            displayBooks($result, $conn);
        ?>
    </div>
</section>

<!-- Tambahkan script JavaScript untuk menangani perubahan filter -->
<script>
    // Fungsi untuk menangani perubahan filter
    function applyFilters() {
        // Ambil nilai filter yang dipilih
        var searchQuery = document.querySelector('input[name="search"]').value;
        var selectedGenres = document.querySelectorAll('input[name="genre"]:checked');
        var selectedYears = document.querySelectorAll('input[name="year"]:checked');
        
        var genres = Array.from(selectedGenres).map(genre => genre.value);
        var years = Array.from(selectedYears).map(year => year.value);
        
        // Kirim permintaan AJAX ke server
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'filter_books.php?search=' + searchQuery + '&genres=' + JSON.stringify(genres) + '&years=' + JSON.stringify(years), true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                // Perbarui daftar buku dengan hasil yang diperoleh dari server
                document.querySelector('.books-container').innerHTML = xhr.responseText;
            } else {
                console.error('Error: ' + xhr.status);
            }
        };
        xhr.send();
    }

    // Tambahkan event listener pada tombol "Apply"
    document.querySelector('.apply-button').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah form dari pengiriman data
        applyFilters(); // Terapkan filter saat tombol "Apply" diklik
    });

    // Ambil elemen-elemen yang diperlukan
    const showButton = document.getElementById('show-button');
    const filterOptions = document.querySelector('.filters .options');
    const applyButton = document.querySelector('.filters .apply-button');

    // Sembunyikan opsi filter dan tombol apply secara default
    filterOptions.style.display = 'none';
    applyButton.style.display = 'none';

    showButton.addEventListener('click', function() {
        if (filterOptions.style.display === 'none') {
            // Jika opsi filter dan tombol apply sedang disembunyikan, tampilkan mereka
            filterOptions.style.display = 'block';
            applyButton.style.display = 'block';
            showButton.innerHTML = "<i class='bx bx-chevron-up'></i>"; // Ganti ikon tombol show menjadi panah atas
        } else {
            // Jika opsi filter dan tombol apply sedang ditampilkan, sembunyikan mereka
            filterOptions.style.display = 'none';
            applyButton.style.display = 'none';
            showButton.innerHTML = "<i class='bx bx-chevron-down'></i>"; // Ganti ikon tombol show menjadi panah bawah
        }
    });
</script>

<?php
    include 'footer.php';
    $conn->close();
?>
