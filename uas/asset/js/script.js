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

// ==================== FILTER OPTIONS - BROWSE HTML ====================

document.addEventListener('DOMContentLoaded', function() {
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


