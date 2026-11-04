

// 1. Konfirmasi sebelum menghapus data (Pelanggan / Transaksi / Laptop)
document.addEventListener("DOMContentLoaded", function() {
    const tombolHapus = document.querySelectorAll(".btn-danger");
    
    tombolHapus.forEach(function(button) {
        button.addEventListener("click", function(event) {
            // Jika tombol tidak memiliki atribut onclick bawaan, jalankan konfirmasi JS ini
            if (!button.hasAttribute("onclick")) {
                const konfirmasi = confirm("Apakah Anda yakin ingin menghapus data ini?");
                if (!konfirmasi) {
                    event.preventDefault(); // Batalkan aksi jika user klik "Cancel"
                }
            }
        });
    });
});

// 2. Fungsi validasi sederhana untuk form login/registrasi
function validasiForm(event) {
    const password = document.querySelector("input[name='password']");
    const konfirmasiPassword = document.querySelector("input[name='konfirmasi_password']");

    // Jika form registrasi memiliki konfirmasi password
    if (password && konfirmasiPassword) {
        if (password.value !== konfirmasiPassword.value) {
            alert("Konfirmasi password tidak sesuai!");
            event.preventDefault(); // Hentikan pengiriman form
            return false;
        }
    }
    return true;
}

// Pasang event listener pada form jika ada
const formRegistrasi = document.querySelector("form");
if (formRegistrasi) {
    formRegistrasi.addEventListener("submit", validasiForm);
}