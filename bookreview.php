<?php
session_start();
include 'dbconn.php';
include 'header.php';

// Fetch book ID from query parameter
$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : 1; // Default to 1 if no book_id provided

// Fetch book details from the database
$book_query = "SELECT books.title, authors.author_name, books.cover_image, books.first_publish, books.isbn, languages.language_name, books.pages, publishers.publisher_name, books.desc_1, books.desc_2, books.desc_3, books.desc_4, books.desc_5, GROUP_CONCAT(genres.genre_name SEPARATOR ', ') AS genre
               FROM books
               JOIN authors ON books.author_id = authors.author_id
               JOIN languages ON books.language_id = languages.language_id
               JOIN publishers ON books.publisher_id = publishers.publisher_id
               LEFT JOIN book_genre ON books.book_id = book_genre.book_id
               LEFT JOIN genres ON book_genre.genre_id = genres.genre_id
               WHERE books.book_id = $book_id
               GROUP BY books.book_id";

$book_result = $conn->query($book_query);
$book = $book_result->fetch_assoc();

// Check if user is logged in
$user_logged_in = isset($_SESSION['user_id']);

// Process review submission
if (isset($_POST['submit_review'])) {
    if ($user_logged_in) {
        $user_id = $_SESSION['user_id'];
        $review_text = $_POST['review_text'];
        $rating = $_POST['rating'];

        // Insert review into database
        $insert_review_query = "INSERT INTO reviews (user_id, book_id, review_text, rating) VALUES ('$user_id', '$book_id', '$review_text', '$rating')";
        $conn->query($insert_review_query);

        // Redirect to prevent form resubmission on page refresh
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }
}

// Fetch reviews for the book from the database
$reviews_query = "SELECT users.first_name, users.last_name, reviews.review_text, reviews.rating, reviews.review_date
                  FROM reviews
                  JOIN users ON reviews.user_id = users.user_id
                  WHERE reviews.book_id = $book_id";
$reviews_result = $conn->query($reviews_query);

// Hitung total rating dan jumlah ulasan
$total_rating = 0;
$total_reviews = 0;
$reviews = []; // Array to store reviews
while ($row = $reviews_result->fetch_assoc()) {
    $reviews[] = $row;
    $total_rating += $row['rating'];
    $total_reviews++;
}

// Hitung rata-rata rating
$average_rating = $total_reviews > 0 ? $total_rating / $total_reviews : 0;

// Menampilkan bintang sesuai dengan rata-rata rating
$full_stars = floor($average_rating);
$half_star = ceil($average_rating - $full_stars);
$empty_stars = 5 - $full_stars - $half_star;

// Memformat rata-rata rating menjadi satu desimal
$formatted_rating = number_format($average_rating, 1);
?>

<!-- ==================== THE BOOK SECTION ==================== -->
<section class="thebook" id="thebook">
    <div class="b-container">
        <div class="image">
            <img src="<?php echo $book['cover_image']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
        </div>
        <div class="content">
            <h2><?php echo htmlspecialchars($book['title']); ?></h2>
            <h4><?php echo htmlspecialchars($book['author_name']); ?></h4>
            <div class="total-rating">
                <?php
                // Menampilkan bintang sesuai dengan rata-rata rating
                for ($i = 0; $i < $full_stars; $i++) {
                    echo '<i class="bx bxs-star"></i>';
                }
                if ($half_star == 1) {
                    echo '<i class="bx bxs-star-half"></i>';
                }
                for ($i = 0; $i < $empty_stars; $i++) {
                    echo '<i class="bx bx-star"></i>';
                }
                ?>
                <span><?php echo $formatted_rating; ?></span>
            </div>
            <p><?php echo $book['desc_1']; ?></p>
            <p><?php echo $book['desc_2']; ?></p>
            <p><?php echo $book['desc_3']; ?></p>
            <p><?php echo $book['desc_4']; ?></p>
            <p><?php echo $book['desc_5']; ?></p>
            <div class="column">
                <div class="row">
                    <h4>Publisher</h4>
                    <p><?php echo htmlspecialchars($book['publisher_name']); ?></p>
                </div>
                <div class="row">
                    <h4>First Publish</h4>
                    <p><?php echo date('d F Y', strtotime($book['first_publish'])); ?></p>
                </div>
                <div class="row">
                    <h4>ISBN</h4>
                    <p><?php echo htmlspecialchars($book['isbn']); ?></p>
                </div>
                <div class="row">
                    <h4>Language</h4>
                    <p><?php echo htmlspecialchars($book['language_name']); ?></p>
                </div>
                <div class="row">
                    <h4>Pages</h4>
                    <p><?php echo htmlspecialchars($book['pages']); ?></p>
                </div>
                <div class="row">
                    <h4>Genre</h4>
                    <p><?php echo htmlspecialchars($book['genre']); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- ==================== REVIEW SECTION ==================== -->
<section class="review" id="review">
    <div class="comments">
        <?php
        if (!$user_logged_in) { // If the user is not logged in
            ?>
            <div class="write-box">
                <h4>Login Required</h4>
                <p>Please <a href="sign.php">login</a> to write a review.</p>
            </div>
            <?php
        } else { // If the user is logged in
            ?>
            <div class="write-box">
                <h4>Write Review</h4>
                <form action="" method="post"> <!-- Updated action to submit the form to the same page -->
                    <textarea name="review_text" placeholder="Write your review here..." oninput="autoResize(this)"></textarea>
                    <div class="rating-and-submit">
                        <div class="star-rating">
                            <span class="star" data-value="1">&#9733;</span>
                            <span class="star" data-value="2">&#9733;</span>
                            <span class="star" data-value="3">&#9733;</span>
                            <span class="star" data-value="4">&#9733;</span>
                            <span class="star" data-value="5">&#9733;</span>
                        </div>
                        <input type="hidden" name="rating" id="rating" value="1"> <!-- Default rating value -->
                        <button type="submit" name="submit_review" class="submit-btn">Submit</button> <!-- Added name attribute to the submit button -->
                    </div>
                </form>
            </div>
            <?php
        }
        ?>

        <div class="posted">
            <h4>Reviews (<?php echo count($reviews); ?>)</h4> <!-- Display the number of reviews -->
            <?php
            // Display existing reviews
            if (count($reviews) > 0) {
                foreach ($reviews as $row) {
                    ?>
                    <div class="review-box">
                        <div class="review-header">
                            <h5><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h5>
                            <p><?php echo date('d F Y', strtotime($row['review_date'])); ?></p>
                        </div>                        
                        <div class="star-rating">
                            <?php
                            $rating = $row['rating'];
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<span class="star">&#9733;</span>';
                                } else {
                                    echo '<span class="star">&#9734;</span>';
                                }
                            }
                            ?>
                        </div>
                        <p><?php echo htmlspecialchars($row['review_text']); ?></p>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No reviews yet.</p>";
            }
            ?>
        </div>
    </div>
</section>


<script>
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.getAttribute('data-value'));
            ratingInput.value = value;
        });
    });
</script>


<?php
include 'footer.php';
$conn->close();
?>
