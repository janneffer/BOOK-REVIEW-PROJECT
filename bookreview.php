<?php
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
                <i class='bx bxs-star'></i>
                <i class='bx bxs-star'></i>
                <i class='bx bxs-star'></i>
                <i class='bx bxs-star'></i>
                <i class='bx bxs-star-half'></i>
                <span>4.5</span>
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
        <div class="write-box">
            <h4>Write Review</h4>
            <textarea placeholder="Write your review here..." oninput="autoResize(this)"></textarea>
            <div class="rating-and-submit">
                <div class="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
                <button type="button" class="submit-btn">Submit</button>
            </div>
        </div>         
        
        <div class="posted">
            <h4>Reviews (3)</h4>
            <div class="review-box">
                <div class="review-header">
                    <h5>Janneffer</h5>
                    <p>3 June 2024 <button class="more-options">&#10247;</button></p>
                    <div class="more-options-popup" id="more-options-popup1">
                        <a href="#">Delete</a>
                        <a href="#">Report</a>
                    </div>
                </div>                        
                <div class="star-rating">
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9734;</span>
                </div>
                <p>This is a very good review. I like it a lot!</p>
            </div>
            <div class="review-box">
                <div class="review-header">
                    <h5>Janneffer</h5>
                    <p>3 June 2024 <button class="more-options">&#10247;</button></p>
                    <div class="more-options-popup" id="more-options-popup2">
                        <a href="#">Delete</a>
                        <a href="#">Report</a>
                    </div>
                </div> 
                <div class="star-rating">
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9734;</span>
                </div>
                <p>This is a very good review. I like it a lot!</p>
            </div>
            <div class="review-box">
                <div class="review-header">
                    <h5>Janneffer</h5>
                    <p>3 June 2024 <button class="more-options">&#10247;</button></p>
                    <div class="more-options-popup" id="more-options-popup3">
                        <a href="#">Delete</a>
                        <a href="#">Report</a>
                    </div>
                </div> 
                <div class="star-rating">
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9734;</span>
                </div>
                <p>This is a very good review. I like it a lot!</p>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
$conn->close();
?>
