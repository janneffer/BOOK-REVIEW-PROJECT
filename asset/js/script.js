// ==================== STICKY NAVBAR ====================
window.addEventListener('scroll', function() {
    var header = document.querySelector('header');
    header.classList.toggle('sticky', window.scrollY > 0);
});

// ==================== NAVBAR - BURGER MENU ====================

let burgermenu = document.querySelector('#burger-menu');
let navbar = document.querySelector('.navbar');

burgermenu.onclick = () => {
    burgermenu.classList.toggle('bx-x');
    navbar.classList.toggle('active');
}

window.onscroll = () => {
    burgermenu.classList.remove('bx-x');
    navbar.classList.remove('active');
}

// ==================== SEARCH BOX - HOME SECTION ====================

document.addEventListener('DOMContentLoaded', function() {
    const homeSearchInput = document.querySelector('.search input'); 
    const homeClearIcon = document.querySelector('.search .clear-icon'); 

    function toggleClearIcon() {
        homeClearIcon.style.display = homeSearchInput.value ? 'block' : 'none'; 
    }
    
    toggleClearIcon();
    
    homeSearchInput.addEventListener('input', toggleClearIcon); 
    homeClearIcon.addEventListener('click', function() {
        homeSearchInput.value = ''; 
        toggleClearIcon(); 
    });
});

// ==================== LOGIN - REGISTER ====================
document.addEventListener("DOMContentLoaded", function() {
    const loginLink = document.getElementById("login-link");
    const registerLink = document.getElementById("register-link");
    const loginForm = document.querySelector(".form-box.login");
    const registerForm = document.querySelector(".form-box.register");

    // Sembunyikan form box register saat halaman dimuat
    registerForm.style.display = "none";

    // Tambahkan event listener pada link "Register" pada form box login
    registerLink.addEventListener("click", function(event) {
        event.preventDefault(); // Untuk mencegah perubahan URL saat link diklik
        loginForm.style.display = "none"; // Sembunyikan form box login
        registerForm.style.display = "block"; // Tampilkan form box register
    });

    // Tambahkan event listener pada link "Login" pada form box register (opsional)
    loginLink.addEventListener("click", function(event) {
        event.preventDefault(); // Untuk mencegah perubahan URL saat link diklik
        registerForm.style.display = "none"; // Sembunyikan form box register
        loginForm.style.display = "block"; // Tampilkan form box login
    });
});


// ==================== BOOKREVIEW PAGE ====================
// ==================== Star Rating, Popup, Edit Button, and Cancel Button ====================
document.addEventListener('DOMContentLoaded', () => {
    // Star rating for book review page
    const stars = document.querySelectorAll('.star-rating .star');
    let lastSelectedIndex = null; // Menyimpan indeks bintang terakhir yang dipilih

    stars.forEach((star, index) => {
        star.addEventListener('mouseout', () => {
            stars.forEach(s => s.classList.remove('hover'));
        });

        star.addEventListener('click', () => {
            const value = star.getAttribute('data-value');

            // Jika bintang yang dipilih sama dengan yang terakhir kali dipilih, batalkan pilihan
            if (index === lastSelectedIndex) {
                stars.forEach(s => s.classList.remove('selected'));
                lastSelectedIndex = null;
            } else {
                // Jika bintang sebelumnya dipilih, batalkan pilihan dan tandai bintang yang baru dipilih serta bintang sebelumnya
                if (lastSelectedIndex !== null && index < lastSelectedIndex) {
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.classList.add('selected');
                        } else {
                            s.classList.remove('selected');
                        }
                    });
                } else {
                    // Jika belum ada bintang yang dipilih atau bintang yang baru dipilih lebih besar dari bintang yang sebelumnya dipilih, tandai bintang yang dipilih dan bintang sebelumnya
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.classList.add('selected');
                        }
                    });
                }

                // Perbarui indeks bintang terakhir yang dipilih
                lastSelectedIndex = index;
            }
        });
    });

    // Star rating for new review and edit review
    const starRatingContainers = document.querySelectorAll('.write-box, .edit-review-box');
    starRatingContainers.forEach(container => {
        container.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                const reviewId = this.getAttribute('data-review-id');
                const value = parseInt(this.getAttribute('data-value'));

                // Jika id review tidak ada, tandai bintang untuk ulasan baru, jika ada, tandai untuk ulasan yang diedit
                const ratingElement = reviewId ? document.getElementById('edit-rating-' + reviewId) : document.getElementById('rating');
                ratingElement.value = value;

                // Update star colors
                updateStarRating(this.parentElement, value);
            });
        });
    });

    // Toggle more options popup
    const moreOptionsButtons = document.querySelectorAll(".more-options");
    moreOptionsButtons.forEach(btn => {
        btn.addEventListener("click", function(event) {
            event.stopPropagation();
            const reviewId = this.id.split('-')[2];
            const popup = document.getElementById('more-options-popup-' + reviewId);
            togglePopup(popup);
        });
    });

    // Close more options popup when clicking outside
    document.addEventListener("click", function(event) {
        document.querySelectorAll(".more-options-popup").forEach(popup => {
            popup.style.display = 'none';
        });
    });

    // Function to toggle the visibility of the popup
    function togglePopup(popup) {
        document.querySelectorAll(".more-options-popup").forEach(p => {
            p.style.display = 'none';
        });
        popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
    }

    // Event listener for edit and cancel buttons
    const editAndCancelButtons = document.querySelectorAll(".edit-review, .cancel-btn");
    editAndCancelButtons.forEach(btn => {
        btn.addEventListener("click", function(event) {
            event.preventDefault();
            const reviewId = this.getAttribute('data-review-id');
            const reviewBox = document.getElementById('edit-review-box-' + reviewId);
            reviewBox.style.display = reviewBox.style.display === 'block' ? 'none' : 'block';

            // Hide other popups
            document.querySelectorAll(".more-options-popup").forEach(popup => {
                popup.style.display = 'none';
            });
        });
    });

    // Auto resize textarea
    const MAX_HEIGHT = 250; // Maximum height for the textarea in pixels

    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            autoResize(this);
        });
    });

    function autoResize(textarea) {
        textarea.style.height = 'auto';
        const newHeight = Math.min(textarea.scrollHeight, MAX_HEIGHT);
        textarea.style.height = newHeight + 'px';
        textarea.style.overflowY = (textarea.scrollHeight > MAX_HEIGHT) ? 'scroll' : 'hidden';
    }
});