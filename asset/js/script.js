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

// ==================== STAR RATING - REVIEW HTML ====================

document.addEventListener('DOMContentLoaded', () => {
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



// ==================== MORE OPTIONS - REVIEW HTML ====================
document.addEventListener("DOMContentLoaded", function() {
    var moreOptionsBtns = document.querySelectorAll(".more-options");
    var popups = document.querySelectorAll(".more-options-popup");

    moreOptionsBtns.forEach(function(btn, index) {
        btn.addEventListener("click", function(event) {
            event.stopPropagation(); // Prevents the event from bubbling up
            togglePopup(index);
        });
    });

    // Close popup when clicking outside of it
    window.addEventListener("click", function(event) {
        popups.forEach(function(popup) {
            if (!popup.contains(event.target)) {
                popup.style.display = 'none';
            }
        });
    });

    // Function to toggle the visibility of the popup
    function togglePopup(index) {
        popups.forEach(function(popup, i) {
            if (i === index) {
                popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
            } else {
                popup.style.display = 'none';
            }
        });
    }
});





