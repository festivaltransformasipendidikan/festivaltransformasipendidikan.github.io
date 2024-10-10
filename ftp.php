<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Simple PWA in One File</title>
  <link rel="apple-touch-icon" sizes="180x180" href="https://i.ibb.co.com/tmK6GSZ/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="https://i.ibb.co.com/F7TzwCP/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://i.ibb.co.com/D70CCD8/favicon-16x16.png">
  <meta name="msapplication-TileColor" content="#224679">
  <meta name="theme-color" content="#ffffff">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
  <!-- Memuat html2canvas -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


  <!-- Manifest in a <script> block -->
  <link
    rel="manifest"
    href="data:application/manifest+json,{'name':'Simple PWA','short_name':'PWA','start_url':'/ftp.php','display':'standalone','background_color':'#ffffff','theme_color':'#000000','icons':[{'src':'https://via.placeholder.com/192','sizes':'192x192','type':'image/png'},{'src':'https://via.placeholder.com/512','sizes':'512x512','type':'image/png'}]}" />

  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      /* Atur ukuran font untuk seluruh teks di body */
      padding: 20px;
      text-align: center;
    }

    helptext {
      font-size: 9px;
      color: #666;

    }

    h1 {
      color: #333;
    }
  </style>

  <script>
    $(document).ready(function() {

      $(document).on("contextmenu", function(event) {
        event.preventDefault(); // Mencegah menu konteks muncul
      });

      const url = "https://script.google.com/macros/s/AKfycbwvEuVg0otuL2zIRtqPYl6qrvBMF6pAG_PmUSrJ7Ow6jDuijCj8K0-2I55QlLxqZ8DDHA/exec"; // Ganti dengan URL Web App Anda  

      // Inisialisasi variabel untuk langkah saat ini
      let currentStep = 1;

      // Tampilkan step pertama saat halaman dimuat
      showStep();

      $('#boardingPassButton').on('click', function() {
        // Ambil elemen yang ingin diubah menjadi gambar (boarding pass)
        var boardingPass = $('.cetakboardingpass')[0]; // Ambil elemen sebagai DOM

        // Gunakan html2canvas untuk menangkap elemen HTML
        html2canvas(boardingPass, {
          scale: 2 // Resolusi tinggi
        }).then(function(canvas) {
          // Buat link untuk mengunduh gambar
          var link = document.createElement('a');
          link.download = 'boarding_pass.png'; // Nama file gambar
          link.href = canvas.toDataURL('image/png'); // Konversi canvas ke data URL
          link.click(); // Simulasi klik untuk mengunduh
        });
      });

      function tes() {
        fetch(url, {
          redirect: "follow",
          method: "POST",
          body: JSON.stringify("DATA"),
          headers: {
            "Content-Type": "text/plain;charset=utf-8",
          },
        })
      }

      // Fungsi untuk menampilkan langkah tertentu dan memperbarui stepper
      function showStep() {
        // Sembunyikan semua step
        $("#step1, #step2, #step3").hide();
        $(".nav-link").removeClass("active"); // Hapus status aktif dari semua link

        // Menentukan langkah yang aktif
        if (currentStep === 1) {
          $("#step1").show();
          updateStepLink("#step1Link", true, "NUPTK");
        } else if (currentStep === 2) {
          $("#step2").show();
          updateStepLink("#step2Link", true, "PENDAFTAR");
          updateStepLink("#step1Link", false, "1"); // Menghapus status aktif dari step 1
        } else if (currentStep === 3) {
          $("#step3").show();
          updateStepLink("#step3Link", true, "KEGIATAN");
          updateStepLink("#step2Link", false, "2"); // Menghapus status aktif dari step 2
          updateStepLink("#step1Link", false, "1"); // Menghapus status aktif dari step 1
        }
      }

      // Fungsi untuk memperbarui status link langkah
      function updateStepLink(stepId, isActive, label) {
        $(stepId).toggleClass("active", isActive); // Menetapkan kelas aktif
        if (isActive) {
          $(stepId).html(
            `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg> <span style="color: white;">${label}</span>`
          );
        } else {
          $(stepId).html(
            `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg> <span style="color: white;"></span>`
          );
        }
      }


      // Fungsi untuk menampilkan data pengguna di halaman (Step 2)
      function displayUserData(userData) {
        $("#nameInput").val(userData.nama); // Nama pengguna
        $(".uname").text(userData.nama); // Nama pengguna

        // Convert the userData.jabatan to lower case for comparison
        var userJabatan = userData.jabatan.toLowerCase();

        // Loop through the options to find a match
        $("#positionInput option").each(function() {
          // Compare the option value in lower case
          if ($(this).val().toLowerCase() === userJabatan) {
            $("#positionInput").val($(this).val()); // Set the value if match found
            return false; // Exit the loop
          }
        })

        $("#generationInput").val(userData.peran); // Angkatan atau peran
        $("#institutionInput").val(userData.instansi); // Instansi (editable)
        $("#districtInput").val(userData.kabupaten); // Kabupaten        

        // Data mapping jenjang to options
        const jenjangMap = {
          "01. PAUD/TK": "Taman Kanak-Kanak (TK)",
          "02. SD": "Sekolah Dasar (SD)",
          "03. SMP": "Sekolah Menengah Pertama (SMP)",
          "04. SMA": "Sekolah Menengah Atas (SMA)",
          "05. SMK": "Sekolah Menengah Kejuruan (SMK)"
        };

        // Cek apakah userData.jenjang ada di mapping
        if (jenjangMap[userData.jenjang]) {
          $("#schoolLevelInput").val(jenjangMap[userData.jenjang]); // Set input dengan jenjang yang sesuai
        } else {
          // Jika jenjang tidak ditemukan, bisa ditambahkan aksi lain misalnya alert atau default value
          $("#schoolLevelInput").val(''); // Kosongkan input jika tidak cocok
        }

        // Datalist for Autocomplete
        const datalistHtml = `
          <datalist id="schoolLevelList">
            <option value="Taman Kanak-Kanak (TK)">
            <option value="Sekolah Dasar (SD)">
            <option value="Sekolah Menengah Pertama (SMP)">
            <option value="Sekolah Menengah Atas (SMA)">
            <option value="Sekolah Menengah Kejuruan (SMK)">
            <option value="Madrasah Ibtidaiyah (MI)">
            <option value="Madrasah Tsanawiyah (MTs)">
            <option value="Madrasah Aliyah (MA)">
            <option value="Pendidikan Anak Usia Dini (PAUD)">
            <option value="Sekolah Luar Biasa (SLB)">
            <option value="Perguruan Tinggi">
          </datalist>
        `;

        // Masukkan datalist ke dalam DOM (jika diperlukan)
        $("#schoolLevelInput").after(datalistHtml);

        // Pastikan inputan tambahan kosong (jika diinginkan)
        $("#whatsappInput").val(userData.nomor_whatsapp); // Nomor WhatsApp (editable)
        $("#bankNameInput").val("");
        $("#accountNumberInput").val("");
        $("#accountNameInput").val(userData.nama);
        $("#kodeKegiatanInput").val(userData.jumlah_kegiatan);

        tampilKegiatan(userData.jumlah_kegiatan); // Tampilkan kegiatan yang tersedia
      }

      // Fungsi untuk menampilkan data registrasi di halaman (Step 2)
      function displayUserDataRegistrasi(userDataRegistrasi, userData) {

        $("#nameInput").val(userData.nama); // Nama pengguna
        $(".uname").text(userData.nama); // Nama pengguna

        generateQRCode(userData.nuptk); // Generate QR code

        // Set the value of each input field with the corresponding data from userDataRegistrasi using jQuery
        $("#regnuptk").val(userData.nuptk || "Inputan otomatis dari sistem");
        $("#regnama").val(userData.nama || "Inputan otomatis dari sistem");
        $("#regjabatan").val(userDataRegistrasi.jabatan || "Inputan otomatis dari sistem");
        $("#reginstansi").val(userDataRegistrasi.instansi || "Inputan otomatis dari sistem");
        $("#regkabupaten").val(userDataRegistrasi.kabupaten || "Inputan otomatis dari sistem");

        $("#regkodeKegiatan").val(userDataRegistrasi.kodeKegiatan || "Inputan otomatis dari sistem");
        $("#regkegiatan").val(userDataRegistrasi.kegiatan || "Inputan otomatis dari sistem");
        $("#regsubKegiatan").val(userDataRegistrasi.subKegiatan || "Inputan otomatis dari sistem");
        $("#regsubTema").val(userDataRegistrasi.subTema || "Inputan otomatis dari sistem");
      }

      // Fungsi untuk menampilkan data registrasi habis registrasi di halaman (Step 2)
      function displayUserDataRegistrasiHabisRegistrasi(nama, nuptk, jabatan, instansi, kabupaten, kodeKegiatan, kegiatan, subKegiatan, subTema) {

        $("#nameInput").val(nama); // Nama pengguna
        $(".uname").text(nama); // Nama pengguna

        generateQRCode(nuptk); // Generate QR code

        // Set the value of each input field with the corresponding data from userDataRegistrasi using jQuery
        $("#regnuptk").val(nuptk || "Inputan otomatis dari sistem");
        $("#regnama").val(nama || "Inputan otomatis dari sistem");
        $("#regjabatan").val(jabatan || "Inputan otomatis dari sistem");
        $("#reginstansi").val(instansi || "Inputan otomatis dari sistem");
        $("#regkabupaten").val(kabupaten || "Inputan otomatis dari sistem");

        $("#regkodeKegiatan").val(kodeKegiatan || "Inputan otomatis dari sistem");
        $("#regkegiatan").val(kegiatan || "Inputan otomatis dari sistem");
        $("#regsubKegiatan").val(subKegiatan || "Inputan otomatis dari sistem");
        $("#regsubTema").val(subTema || "Inputan otomatis dari sistem");
      }

      function unggahNaskah() {
        // Ambil nilai dari input field
        const NUPTK = $("#regnuptk").val();
        const judulBaru = $("#judulnaskahInput").val();
        const naskahBaru = $("#naskahInput").val();
        const suratKeteranganBaru = $("#suratInput").val();

        // Ganti dengan URL Web App Anda
        const baseUrl = "https://script.google.com/macros/s/AKfycbwvEuVg0otuL2zIRtqPYl6qrvBMF6pAG_PmUSrJ7Ow6jDuijCj8K0-2I55QlLxqZ8DDHA/exec";

        // Menambahkan parameter judulBaru, naskahBaru, dan suratKeteranganBaru ke dalam URL
        const url = `${baseUrl}?NUPTK=${encodeURIComponent(NUPTK)}&judulBaru=${encodeURIComponent(judulBaru)}&naskahBaru=${encodeURIComponent(naskahBaru)}&suratKeteranganBaru=${encodeURIComponent(suratKeteranganBaru)}`;

        // Menggunakan fetch API untuk mengirim permintaan GET
        fetch(url, {
            redirect: "follow",
            method: "GET", // Menggunakan metode GET            
            headers: {
              "Content-Type": "text/plain;charset=utf-8", // Header sesuai permintaan
            },
          })
          .then((response) => {
            if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json(); // Mengharapkan respons JSON
          })
          .then((responseData) => {
            // Log respons untuk debug
            console.log("Response Data:", responseData);

            if (responseData.status === "error") {
              console.error(responseData.message);
              alert(`Error: ${responseData.message}`);
              return;
            }

            if (responseData.status === "success") {
              swal({
                title: "Berhasil!",
                text: "Data naskah berhasil diperbarui!",
                icon: "success", // Ikon "success"
                button: "Terima kasih, Kak!",
              });
            }

          })
          .catch((error) => {
            // Log error untuk debug
            console.error("Terjadi kesalahan:", error);
            alert("Terjadi kesalahan saat memperbarui data.");
          });
      }

      // Fungsi untuk menampilkan kegiatan yang tersedia di dropdown select
      function tampilKegiatan(jumlahKegiatan) {
        // Ganti dengan URL Web App Anda
        const baseUrl = "https://script.google.com/macros/s/AKfycbwvEuVg0otuL2zIRtqPYl6qrvBMF6pAG_PmUSrJ7Ow6jDuijCj8K0-2I55QlLxqZ8DDHA/exec";

        // Menambahkan parameter jumlahKegiatan ke dalam URL
        const url = `${baseUrl}?kode=${encodeURIComponent(jumlahKegiatan)}`;

        // Menggunakan fetch API untuk mengirim permintaan GET
        fetch(url, {
            redirect: "follow",
            method: "GET", // Menggunakan metode GET            
            headers: {
              "Content-Type": "text/plain;charset=utf-8", // Header sesuai permintaan
            },
          })
          .then((response) => {
            if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json(); // Mengharapkan respons JSON
          })
          .then((responseData) => {
            // Log respons untuk debug
            console.log("Data kegiatan:", responseData);

            // Kosongkan dropdown sebelum diisi
            $("#activitySelect").empty();
            $("#activitySelect").append('<option value="" disabled selected>Pilih Kegiatan</option>');

            // Cek jika ada kesalahan dalam respons
            if (responseData.error) {
              console.error(responseData.error);
              return;
            }

            // Tampilkan data kegiatan di dropdown select
            const kegiatan = responseData.kegiatan || [];
            kegiatan.forEach(function(activity) {
              const namaKegiatanArray = activity.nama.split(',').map(k => k.trim());

              namaKegiatanArray.forEach(function(namaKegiatan) {
                $("#activitySelect").append(
                  `<option value="${namaKegiatan}">${namaKegiatan} (${activity.timja})</option>`
                );
              });
            });
          })
          .catch((error) => {
            // Log error untuk debug
            console.error("Terjadi kesalahan:", error);
          });
      }

      // Fungsi untuk mengambil data naskah berdasarkan NUPTK dan set ke input
      function getNaskah(NUPTK) {
        // Ganti dengan URL Web App Anda
        const baseUrl = "https://script.google.com/macros/s/AKfycbwvEuVg0otuL2zIRtqPYl6qrvBMF6pAG_PmUSrJ7Ow6jDuijCj8K0-2I55QlLxqZ8DDHA/exec";

        // Menambahkan parameter NUPTK ke dalam URL
        const url = `${baseUrl}?NUPTK=${encodeURIComponent(NUPTK)}`;

        // Menggunakan fetch API untuk mengirim permintaan GET
        fetch(url, {
            redirect: "follow",
            method: "GET",
            headers: {
              "Content-Type": "text/plain;charset=utf-8",
            },
          })
          .then((response) => {
            if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json(); // Mengharapkan respons JSON
          })
          .then((responseData) => {
            // Cek jika ada kesalahan dalam respons
            if (responseData.status !== "success") {
              console.error("Data naskah tidak ditemukan atau terjadi kesalahan.");
              return;
            }

            // Tampilkan data naskah di input form
            const naskahData = responseData;

            // Isi input field dengan data naskah
            $("#judulnaskahInput").val(naskahData.judulNaskah); // Mengisi input judul naskah
            $("#naskahInput").val(naskahData.naskah); // Mengisi input naskah
            $("#suratInput").val(naskahData.suratKeterangan); // Mengisi input surat keterangan

          })
          .catch((error) => {
            console.error("Terjadi kesalahan:", error);
          });
      }

      // Fungsi format nomor WhatsApp
      function formatWhatsApp(number) {
        // Hapus karakter selain angka
        number = number.replace(/\D/g, '');

        // Cek apakah nomor dimulai dengan 08
        if (number.startsWith('08')) {
          // Ganti 08 dengan 62
          number = '62' + number.slice(1);
        } else if (!number.startsWith('62')) {
          // Jika nomor tidak dimulai dengan 62, tambahkan 62 di depan
          number = '62' + number;
        }

        // Kembalikan nomor yang telah diformat
        return number;
      }

      // Fungsi untuk menghasilkan QR code
      function generateQRCode(qrtext) {
        // Clear the previous QR code
        $('#qrcode').empty();

        // Get the input text
        var qrText = qrtext;

        // Generate the QR code with custom styles
        if (qrText) {
          var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: qrText,
            width: 200, // QR code width
            height: 200, // QR code height            
            correctLevel: QRCode.CorrectLevel.H // Error correction level
          });

        }
      }

      // Batasi input hanya angka dan maksimal 16 digit
      $('#NUPTK').on('input', function() {
        var value = $(this).val().replace(/[^0-9]/g, ''); // Hanya izinkan angka
        if (value.length > 16) {
          value = value.slice(0, 16); // Batasi maksimal 16 digit
        }
        $(this).val(value);
        $("#message")
          .text("")
          .addClass("text-red-500");
      });

      // Validasi NUPTK saat blur
      $('#NUPTK').on('blur', function() {
        var value = $(this).val();
        if (value.length !== 16) {
          $("#message")
            .text("NUPTK harus berupa 16 digit angka.")
            .addClass("text-red-500");
        }
      });

      // Step 1: Validasi NUPTK
      $("#checkButton").click(function() {
        $("#loading").show(); // Tampilkan spinner loading
        $("#checkButton").prop("disabled", true).text("Proses Verifikasi...");

        const NUPTK = $("#NUPTK").val();

        // cek nuptk kosong
        if (NUPTK == "") {
          swal({
            title: "Hai, kak!",
            text: "NUPTK harus lengkap sebelum melanjutkan.",
            icon: "error", // Bisa "warning", "error", "success", atau "info"
            button: {
              text: "Oke, Siap ka!", // Label tombol
              className: "btn btn-primary", // Menggunakan kelas btn-primary dari Bootstrap 5
              closeModal: true // Tutup setelah tombol diklik
            }
          });
          $("#loading").hide(); // Sembunyikan spinner
          $("#checkButton").prop("disabled", false).text("Verifikasi");


          return; // Hentikan eksekusi jika NUPTK kosong
        }


        // Kirim NUPTK ke Google Apps Script untuk validasi        
        const params = {
          NUPTK: NUPTK,
        };

        // Tampilkan SweetAlert dengan hitung mundur
        let countdown = 10;
        swal({
          title: "Proses Verifikasi",
          text: `Kami sedang memverifikasi NUPTK ${NUPTK} (Tunggu hingga : ${countdown} detik)`,
          icon: "info",
          buttons: false,
          closeOnClickOutside: false,
          closeOnEsc: false,
        });

        // Mulai hitung mundur setiap 1 detik
        const countdownInterval = setInterval(function() {
          countdown--;
          swal({
            title: "Proses Verifikasi",
            text: `Kami sedang memverifikasi NUPTK (Tunggu hingga : ${countdown} detik)`,
            icon: "info",
            buttons: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
          });

          // Jika countdown selesai, hentikan interval
          if (countdown === 0) {
            clearInterval(countdownInterval);
          }
        }, 1000);

        // Menggunakan fetch API untuk mengirim permintaan POST
        fetch(url, {
            redirect: "follow",
            method: "POST",
            body: JSON.stringify(params), // Data dalam format JSON
            headers: {
              "Content-Type": "text/plain;charset=utf-8", // Menggunakan text/plain untuk menghindari masalah CORS
            },
          })
          .then((response) => {
            $("#loading").hide(); // Sembunyikan spinner
            $("#checkButton").prop("disabled", false).text("Cek NUPTK");

            clearInterval(countdownInterval); // Hentikan hitung mundur

            // Cek apakah respons berhasil
            if (!response.ok) {
              throw new Error("Jaringan bermasalah. Coba lagi nanti.");
            }

            return response.json(); // Mengubah respons menjadi JSON
          })
          .then((response) => {
            console.log("Respons dari server:", response); // Log respons untuk debug

            // Handle different response statuses
            if (response.status === "invalid") {
              swal({
                title: "NUPTK Tidak Terdaftar",
                text: "Kakak tidak bisa melanjutkan.",
                icon: "error",
                button: {
                  text: "OK", // Label tombol
                  className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
                  closeModal: true // Tutup swal setelah tombol diklik
                }
              }).then(() => {
                $("#message").text("NUPTK tidak terdaftar. Anda tidak bisa melanjutkan.").addClass("text-red-500");
                $("#NUPTK").val(""); // Kosongkan input NUPTK
              });

            } else if (response.status === "registered") {

              getNaskah(NUPTK);

              const userDataRegistrasi = response.userDataRegistrasi; // Ambil data registrasi
              const userData = response.userData; // Ambil data pengguna

              displayUserDataRegistrasi(userDataRegistrasi, userData); // Menampilkan data pengguna

              swal({
                title: "NUPTK Sudah Terdaftar",
                text: "NUPTK sudah terdaftar pada kegiatan " + userDataRegistrasi.kegiatan,
                icon: "warning",
                button: {
                  text: "Lihat detail kegiatan", // Label tombol
                  className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
                  closeModal: true // Tutup swal setelah tombol diklik
                }
              }).then(() => {
                $("#message").text("NUPTK sudah terdaftar untuk kegiatan.").addClass("text-red-500");
                $(".forma").prop("hidden", true);
                $(".formc").prop("hidden", false);

                if (userDataRegistrasi.subTema === "Tidak Dipilih") {
                  $(".formunggah").prop("hidden", true);
                } else {
                  $(".formunggah").prop("hidden", false);
                }
              });

            } else if (response.status === "valid") {
              swal({
                title: "NUPTK Valid",
                text: "Silakan lanjut ke langkah berikutnya.",
                icon: "success",
                button: {
                  text: "Siap, kakak", // Label tombol
                  className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
                  closeModal: true // Tutup swal setelah tombol diklik
                }
              }).then(() => {
                $("#message").text("NUPTK valid. Silakan lanjut ke langkah berikutnya.").removeClass("text-red-500").addClass("text-green-500");

                const userData = response.userData;
                displayUserData(userData); // Tampilkan data pengguna

                currentStep = 2;
                showStep(); // Function to proceed to the next step
              });

            }
          })
          .catch((error) => {
            $("#loading").hide(); // Sembunyikan spinner
            $("#checkButton").prop("disabled", false).text("Cek NUPTK");

            clearInterval(countdownInterval); // Hentikan hitung mundur jika ada error

            console.log("Error details:", error); // Log errors

            let errorMessage = "Terjadi kesalahan.";
            if (error.message.includes("Jaringan bermasalah")) {
              errorMessage = "Tidak bisa terhubung ke server. Periksa koneksi internet Anda.";
            }

            swal({
              title: "Error",
              text: errorMessage,
              icon: "error",
              button: {
                text: "Siap, kak!", // Label tombol
                className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
                closeModal: true // Tutup swal setelah tombol diklik
              }
            });


            $("#message").text(errorMessage).addClass("text-red-500");
          });
      });

      // Step 2: Lanjutkan ke Pilih Kegiatan
      $("#nextButton").click(function() {

        // Ambil nilai dari semua input
        const jenjang = $("#schoolLevelInput").val(); // Jenjang sekolah
        const position = $("#positionInput").val(); // Get the selected value
        const institution = $("#institutionInput").val().trim();
        const district = $("#districtInput").val().trim();
        const whatsapp = $("#whatsappInput").val().trim();
        const bankName = $("#bankNameInput").val().trim();
        const accountNumber = $("#accountNumberInput").val().trim();
        const accountName = $("#accountNameInput").val().trim();

        // Validasi: Pastikan semua field terisi
        if (jenjang == "" || position == "" || position == null || !institution || !district || !whatsapp || !bankName || !accountNumber || !accountName) {
          swal({
            title: "Hai, kak!",
            text: "Semua data harus terisi sebelum melanjutkan.",
            icon: "error",
            button: {
              text: "Ok siap", // Label tombol
              className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
              closeModal: true // Tutup swal setelah tombol diklik
            }
          });

          return; // Hentikan eksekusi jika ada field yang kosong
        }

        // Jika semua field terisi, lanjutkan ke langkah berikutnya
        currentStep = 3;
        showStep();
      });

      // Step 3: Daftar kegiatan
      $("#submitFormButton").click(function() {

        const selectedActivity = $("#activitySelect").val(); // Kegiatan yang dipilih
        var subKegiatan = "Tidak Dipilih"; // Tipe kegiatan tambahan (jika ada)
        var subTema = "Tidak Dipilih"; // Tema kegiatan tambahan (jika ada)

        // Cek jika "Simposium Berbagi Praktik Baik Prakarsa Perubahan" dipilih
        if (selectedActivity === 'Simposium Berbagi Praktik Baik Prakarsa Perubahan') {
          // Tampilkan opsi tambahan
          subKegiatan = $("#additionalSelect2").val() || subKegiatan; // Ambil tipe kegiatan tambahan (jika ada)
          subTema = $("#additionalSelect").val() || subTema; // Ambil tipe tema kegiatan tambahan (jika ada)
        }

        const NUPTK = $("#NUPTK").val(); // NUPTK yang diinputkan
        const jabatan = $("#positionInput").val(); // Jabatan dari input
        const instansi = $("#institutionInput").val(); // Ambil instansi dari input
        const jenjang = $("#schoolLevelInput").val(); // Ambil jenjang sekolah dari input
        const kabupaten = $("#districtInput").val(); // Ambil kabupaten dari input
        const whatsapp = formatWhatsApp($("#whatsappInput").val()); // Ambil nomor WhatsApp dari input
        const bankName = $("#bankNameInput").val(); // Ambil nama bank dari input
        const accountNumber = $("#accountNumberInput").val(); // Ambil nomor rekening dari input
        const accountName = $("#accountNameInput").val(); // Ambil atas nama rekening dari input
        const kodeKegiatan = $("#kodeKegiatanInput").val(); // Ambil kode kegiatan (misalnya dari input)

        displayUserDataRegistrasiHabisRegistrasi($("#nameInput").val(), NUPTK, jabatan, instansi, kabupaten, kodeKegiatan, selectedActivity, subKegiatan, subTema);

        // Membangun data yang akan dikirim
        const params = {
          NUPTK: NUPTK,
          activity: selectedActivity,
          jabatan: jabatan,
          instansi: instansi,
          jenjang: jenjang,
          kabupaten: kabupaten,
          whatsapp: whatsapp,
          bankName: bankName,
          accountNumber: accountNumber,
          accountName: accountName,
          kode: kodeKegiatan, // Jika ada input untuk kode kegiatan
          subKegiatan: subKegiatan, // Jika ada input untuk tipe kegiatan tambahan
          subTema: subTema // Jika ada input untuk tema kegiatan tambahan
        };

        // Tampilkan SweetAlert dengan hitung mundur 10 detik
        let countdown = 10;
        swal({
          title: "Menunggu Memproses Pendaftaran",
          text: `Kami sedang memproses pendaftaran.. (Tunggu hingga: ${countdown} detik)`,
          icon: "info",
          buttons: false,
          closeOnClickOutside: false,
          closeOnEsc: false,
        });

        const countdownInterval = setInterval(function() {
          countdown--;
          swal({
            title: "Menunggu Proses Pendaftaran",
            text: `Kami sedang memproses pendaftaran.. (Tunggu hingga: ${countdown} detik)`,
            icon: "info",
            buttons: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
          });

          // Jika countdown selesai, hentikan interval
          if (countdown === 0) {
            clearInterval(countdownInterval);
          }
        }, 1000);

        // Kirim data pendaftaran menggunakan fetch
        fetch(url, {
            redirect: "follow",
            method: "POST",
            body: JSON.stringify(params), // Data dalam format JSON
            headers: {
              "Content-Type": "text/plain;charset=utf-8", // Menggunakan text/plain untuk menghindari masalah CORS
            },
          })
          .then(response => {
            if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json(); // Mengharapkan respons dalam format JSON
          })
          .then(response => {
            clearInterval(countdownInterval); // Hentikan hitung mundur jika respons diterima

            // Hapus spinner dan kembalikan tombol ke status awal
            $("#submitFormButton").prop("disabled", false).text("Daftar");

            // Menangani respons dari server
            if (response.status === "success") {
              swal({
                title: "Pendaftaran Berhasil, Kak!",
                text: response.message,
                icon: "success",
                button: {
                  text: "Siap terima kasih", // Label tombol
                  className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
                  closeModal: true // Tutup swal setelah tombol diklik
                }
              }).then(() => {
                $(".forma").prop("hidden", true); // Menyembunyikan Form A
                $(".formb").prop("hidden", false); // Menampilkan Form B
                $(".formc").prop("hidden", false); // Menampilkan Form C  

                generateQRCode(NUPTK); // Generate QR code

                // Tampilkan dropdown tema simposium jika tipe kegiatan adalah "Simposium"
                if (subKegiatan === "Simposium") {
                  $(".formunggah").prop("hidden", false); // Menampilkan Form C              
                }

                $("#message")
                  .text(response.message)
                  .addClass("text-green-500")
                  .removeClass("text-muted");
              });

            } else {
              swal({
                title: "Pendaftaran Gagal, Kak!",
                text: "Kakak hanya boleh mendaftar 1 kegiatan, ya!",
                icon: "error",
                button: {
                  text: "Siap kak!", // Label tombol
                  className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
                  closeModal: true // Tutup swal setelah tombol diklik
                }
              }).then(() => {
                $("#message")
                  .text("Pendaftaran gagal.")
                  .addClass("text-danger")
                  .removeClass("text-muted");
              });

            }
          })
          .catch(error => {
            clearInterval(countdownInterval); // Hentikan hitung mundur jika ada error

            // Hapus spinner dan kembalikan tombol ke status awal
            $("#submitFormButton").prop("disabled", false).text("Daftar sekarang");
            swal({
              title: "Terjadi Kesalahan, Kak!",
              text: "Coba mendaftar lagi, kakak.",
              icon: "error",
              button: {
                text: "OK", // Label tombol
                className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
                closeModal: true // Tutup swal setelah tombol diklik
              }
            }).then(() => {
              $("#message")
                .text("Terjadi kesalahan: " + error.message)
                .addClass("text-danger")
                .removeClass("text-muted");
            });

          });
      });

      // Step 4: Unggah Naskah
      $("#unggahNaskahButton").click(function() {

        // cek jika empty
        if ($("#judulnaskahInput").val() == "" || $("#naskahInput").val() == "" || $("#suratInput").val() == "") {
          swal({
            title: "Hai, kak!",
            text: "Semua data naskah harus terisi sebelum mengunggah.",
            icon: "error",
            button: {
              text: "Ok siap", // Label tombol
              className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
              closeModal: true // Tutup swal setelah tombol diklik
            }
          });

          return; // Hentikan eksekusi jika ada field yang kosong

        } else {

          unggahNaskah();
        }

      });

      // Fungsi untuk membatasi input hanya angka
      $('#whatsappInput').on('input', function() {
        var value = $(this).val().replace(/[^0-9]/g, ''); // Hanya izinkan angka
        if (value.length > 0 && value[0] !== '0') {
          value = '0' + value.slice(1); // Pastikan dimulai dengan 0
        }
        $(this).val(value);
      });

      // Fungsi untuk membatasi input hanya angka
      $('#accountNumberInput').on('input', function() {
        // Hapus karakter yang bukan angka
        this.value = this.value.replace(/[^0-9]/g, '');
      });

      // Fungsi untuk membuka link naskah menggunakan jQuery    
      $('#cekNaskahBtn').on('click', function() {
        const naskahLink = $('#naskahInput').val(); // Mendapatkan nilai dari input dengan jQuery
        if (naskahLink) {
          // Membuka link di tab baru
          window.open(naskahLink, '_blank');
        } else {
          // Menggunakan SweetAlert untuk menampilkan pesan kesalahan
          swal({
            title: "Link Tidak Ditemukan!",
            text: "Harap masukkan link naskah terlebih dahulu.",
            icon: "warning",
            button: {
              text: "OK", // Label tombol
              className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
              closeModal: true // Tutup swal setelah tombol diklik
            }
          });

        }
      });

      // Fungsi untuk membuka link surat pernyataan
      $('#cekSuratBtn').on('click', function() {
        const suratLink = $('#suratInput').val();
        if (suratLink) {
          // Membuka link di tab baru
          window.open(suratLink, '_blank');
        } else {
          // Menggunakan SweetAlert untuk menampilkan pesan jika link tidak ada
          swal({
            title: "Link Tidak Ditemukan!",
            text: "Harap masukkan link surat pernyataan terlebih dahulu.",
            icon: "warning",
            button: {
              text: "OK, kak!", // Label tombol
              className: "btn btn-primary", // Menggunakan kelas btn-primary Bootstrap 5
              closeModal: true // Tutup swal setelah tombol diklik
            }
          });

        }
      });

      // Fungsi untuk menampilkan data kegiatan berdasarkan NUPTK
      const activities = [{
          nama: 'Simposium Berbagi Praktik Baik Prakarsa Perubahan'
        },
        {
          nama: 'Gebyar Implementasi Kurikulum Merdeka (IKM)'
        },
        {
          nama: 'BBB'
        },
        {
          nama: 'Pedagogik'
        }
        // Tambahkan kegiatan lainnya
      ];

      // Isi select dengan kegiatan dinamis
      activities.forEach(function(activity) {
        $("#activitySelect").append(
          `<option value="${activity.nama}">${activity.nama}</option>`
        );
      });

      // Ketika kegiatan dipilih
      $("#activitySelect").change(function() {
        const selectedActivity = $(this).val();

        // Cek jika "Simposium Berbagi Praktik Baik Prakarsa Perubahan" dipilih
        if (selectedActivity === 'Simposium Berbagi Praktik Baik Prakarsa Perubahan') {
          // Tampilkan opsi tambahan
          $("#additionalOptions2").show();
          $("#additionalSelect2").val("");
          $("#additionalSelect").val("");
        } else {
          // Sembunyikan opsi tambahan jika kegiatan lain dipilih
          $("#additionalOptions").hide();
          $("#additionalSelect2").val("");
          $("#additionalSelect").val("");
          $("#additionalOptions2").hide();
        }
      });

      // Event handler untuk dropdown tipe kegiatan
      $("#additionalSelect2").change(function() {
        const selectedType = $(this).val();

        // Tampilkan dropdown tema simposium jika tipe kegiatan adalah "Simposium"
        if (selectedType === "Simposium") {
          $("#additionalOptions").show();
        } else {
          $("#additionalOptions").hide();
          $("#additionalSelect").val("");
        }
      });

    });
  </script>

  <style>
    /* Stepper container */
    #stepper {
      display: flex;
      /* Mengatur elemen anak agar berada dalam satu baris */
      justify-content: center;
      /* Memusatkan elemen */
      list-style-type: none;
      /* Menghilangkan bullet points */
      padding: 0;
    }

    /* Stepper items */
    #stepper .nav-item {
      margin: 2px;
      /* Memberikan jarak antar elemen */
    }

    /* Style untuk tautan stepper */
    #stepper .nav-link {
      display: inline-flex;
      /* Agar ikon dan teks berada dalam satu baris */
      align-items: center;
      /* Mengatur ikon dan teks sejajar secara vertikal */
      padding: 5px 10px;
      border-radius: 5px;
      background-color: #007bff;
      /* Warna latar belakang */
      color: white;
      text-decoration: none;
    }

    /* Menyesuaikan ukuran ikon */
    #stepper .nav-link svg {
      margin-right: 2px;
      /* Memberikan jarak antara ikon dan teks */
    }

    /* Style untuk tautan yang disabled */
    #stepper .nav-link.disabled {
      background-color: #6c757d;
      cursor: not-allowed;
    }

    /* Style untuk tautan stepper */
    #stepper .nav-link {
      display: inline-flex;
      align-items: center;
      padding: 10px 20px;
      border-radius: 5px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      font-size: 9px;
      /* Ukuran font diperkecil */
    }

    /* Menyesuaikan ukuran ikon */
    #stepper .nav-link svg {
      margin-right: 8px;
      width: 14px;
      /* Ukuran ikon diperkecil */
      height: 14px;
      /* Ukuran ikon diperkecil */
    }
  </style>

</head>

<body class="bg-primary">

  <!-- HTML -->
  <div class="header-container container mb-3">

    <!-- Gambar di kiri -->
    <a target="_blank" href="https://bbgpjateng.kemdikbud.go.id/">
      <img src="https://i.ibb.co.com/xf7zM5g/TULISAN-BBGP-3-1.png" width="45%" alt="bbgpjateng" border="0">
    </a>

    <!-- Teks di kanan -->
    <div class="mt-3">
      <span class="text-white">Hai kak, </span><span class="fw-bold uname text-white">Selamat datang</span>
    </div>
  </div>
  </div>

  <div class="container p-5 bg-light rounded shadow forma">
    <h1 class="mb-4 fw-bold h3 text-dark">Festival Transformasi Pendidikan</h1>

    <input type="text" id="kodeKegiatanInput" hidden>

    <!-- Stepper -->
    <ul class="nav nav-pills mb-4" id="stepper">
      <li class="nav-item">
        <a class=" nav-link active fw-bold text-white" id="step1Link">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
            <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
          </svg>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled fw-bold text-white h6" id="step2Link" href="#" tabindex="-1" aria-disabled="true">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z" />
          </svg>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled fw-bold text-white" id="step3Link" href="#" tabindex="-1" aria-disabled="true">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-dash-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M6 6a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z" />
          </svg>
        </a>
      </li>
    </ul>

    <!-- Step 1: Input NUPTK -->
    <div id="step1">
      <label for="NUPTK" class="form-label ">Masukkan ID Pendaftaran (NUPTK/NIK)</label>

      <!-- Input group for NUPTK with floating label -->
      <div class="form-floating mb-3">
        <input type="text" inputmode="numeric" id="NUPTK" required class="form-control" placeholder="NUPTK" />
        <label for="NUPTK">NUPTK</label> <!-- Floating label -->
        <div class="input-group-append mt-2">
          <div class="d-grid gap-2">
            <button id="checkButton" class="btn btn-primary gradient-button fw-bold" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
              </svg> Verifikasi
            </button>
          </div>
        </div>
        <small class="mt-5 text-muted">Jika tidak punya NUPTK bisa menggunakan NIK</small>
      </div>

      <p id="message" class="mt-3"></p>
      <div id="loading" class="text-muted mt-2"></div>
    </div>

    <!-- Step 2: Tampilkan data pengguna dalam bentuk input -->
    <div id="step2" class="hidden text-left" style="display: none">

      <!-- <label for="nameInput" class="form-label">Nama Lengkap</label> -->
      <!-- Input Nama (non-editable) -->
      <div class="mb-3 input-group">
        <span class="input-group-text" style="text-align: left;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg> <!-- Icon Nama -->
        </span>
        <input type="text" id="nameInput" class="form-control non-editable" style="text-align: left;" disabled placeholder="Nama tidak bisa diedit">
      </div>

      <!-- <p for="NUPTK" class="form-label">Peran</p> -->
      <!-- Input Peran (non-editable) -->
      <div class="mb-3 input-group">
        <span class="input-group-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
            <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
            <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z" />
          </svg> <!-- Icon Peran -->
        </span>
        <input type="text" id="generationInput" class="form-control non-editable" disabled placeholder="Peran">
      </div>

      <hr>

      <!-- <p for="NUPTK" class="text-left form-label">Jabatan</p> -->
      <!-- Input Jabatan (editable) -->
      <div class="mb-3 input-group">
        <span class="input-group-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
            <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5" />
            <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85z" />
          </svg> <!-- Icon Jabatan -->
        </span>
        <select id="positionInput" class="form-select editable">
          <option value="" disabled selected>Pilih Jabatan Anda</option>
          <option value="Guru">Guru</option>
          <option value="Kepala Sekolah">Kepala Sekolah</option>
          <option value="Wakil Kepala Sekolah">Wakil Kepala Sekolah</option>
          <option value="Pengawas Sekolah">Pengawas Sekolah</option>
          <option value="Tenaga Pendidik Lainnya">Tenaga Pendidik Lainnya</option>
        </select>
        <small class="ml-3 mt-1 help-text helptext">Pilih jabatan sesuai posisi saat ini.</small>
      </div>


      <!-- <p for="NUPTK" class="form-label mt-3">Instansi</p> -->
      <!-- Input Instansi (editable) -->
      <div class="mb-3 input-group mt-3">
        <span class="input-group-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-buildings-fill" viewBox="0 0 16 16">
            <path d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zM2 11h1v1H2zm2 0h1v1H4zm-1 2v1H2v-1zm1 0h1v1H4zm9-10v1h-1V3zM8 5h1v1H8zm1 2v1H8V7zM8 9h1v1H8zm2 0h1v1h-1zm-1 2v1H8v-1zm1 0h1v1h-1zm3-2v1h-1V9zm-1 2h1v1h-1zm-2-4h1v1h-1zm3 0v1h-1V7zm-2-2v1h-1V5zm1 0h1v1h-1z" />
          </svg> <!-- Icon Instansi -->
        </span>
        <input type="text" id="institutionInput" class="form-control editable" placeholder="Isi instansi Anda">
        <small class="ml-3 mt-1 help-text">Pastikan instansi sesuai tempat bekerja saat ini.</small>
      </div>


      <!-- <p for="schoolLevelInput" class="form-label mt-3">Jenjang</p> -->
      <!-- Input Jenjang Sekolah (editable) -->
      <div class="mb-3 input-group mt-3">
        <span class="input-group-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
            <path d="M13.5.5a.5.5 0 0 1 .5.5v14a.5.5 0 0 1-1 0V13h-2v2a.5.5 0 0 1-1 0v-2H6v2a.5.5 0 0 1-1 0v-2H3v2a.5.5 0 0 1-1 0v-14a.5.5 0 0 1 .5-.5h11ZM2 1a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2Zm1 10v3h2v-3H3Zm0-1h2V7H3v3Zm3 0h2V7H6v3Zm0 1v3h2v-3H6Zm3 0v3h2v-3H9Zm0-1h2V7H9v3Zm3 0v3h2v-3h-2Zm0-1h2V7h-2v3ZM3 6h2V4H3v2Zm3 0h2V4H6v2Zm3 0h2V4H9v2Zm3 0h2V4h-2v2ZM3 3h2V2H3v1Zm3 0h2V2H6v1Zm3 0h2V2H9v1Zm3 0h2V2h-2v1Z" />
          </svg> <!-- Icon Building (School) -->
        </span>
        <input type="text" id="schoolLevelInput" class="form-control editable" placeholder="Pilih Jenjang Sekolah" list="schoolLevelList">
        <small class="ml-3 mt-1 help-text">Pastikan jenjang sesuai tempat bekerja saat ini.</small>
      </div>


      <!-- Datalist for Autocomplete -->
      <datalist id="schoolLevelList">
        <option value="Taman Kanak-Kanak (TK)">
        <option value="Sekolah Dasar (SD)">
        <option value="Sekolah Menengah Pertama (SMP)">
        <option value="Sekolah Menengah Atas (SMA)">
        <option value="Sekolah Menengah Kejuruan (SMK)">
        <option value="Madrasah Ibtidaiyah (MI)">
        <option value="Madrasah Tsanawiyah (MTs)">
        <option value="Madrasah Aliyah (MA)">
        <option value="Pendidikan Anak Usia Dini (PAUD)">
        <option value="Sekolah Luar Biasa (SLB)">
        <option value="Perguruan Tinggi">
      </datalist>

      <!-- <p for="NUPTK" class="form-label mt-3">Kabupaten</p> -->
      <!-- Input Kabupaten (editable) -->
      <div class="mb-3 input-group mt-3">
        <span class="input-group-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
          </svg> <!-- Icon Kabupaten -->
        </span>
        <input type="text" id="districtInput" class="form-control editable" placeholder="Isi kabupaten Anda">
        <small class="ml-3 mt-1 help-text">Pastikan kab/kota sesuai wilayah kerja saat ini.</small>
      </div>



      <!-- <p for="NUPTK" class="form-label mt-3">Nomor WhatsApp</p> -->
      <!-- Input Nomor WhatsApp (editable) -->
      <div class="mb-3 input-group mt-3">
        <span class="input-group-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
          </svg> <!-- Icon WhatsApp -->
        </span>
        <input type="text" inputmode="numeric" id="whatsappInput" class="form-control editable" placeholder="0821xxxxxx">
      </div>

      <hr>

      <!-- <p for="bankNameInput" class="form-label mt-3">Nama Bank</p> -->
      <!-- Input Nama Bank (editable) -->
      <div class="mb-3 input-group mt-3">
        <span class="input-group-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bank2" viewBox="0 0 16 16">
            <path d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z" />
          </svg> <!-- Icon Bank -->
        </span>
        <input type="text" id="bankNameInput" class="form-control editable" placeholder="Nama Bank Anda" list="bankList">
        <small class="ml-3 mt-1 help-text">Isi dengan nama bank sesuai rekening Anda.</small>
      </div>

      <!-- Datalist for Autocomplete -->
      <datalist id="bankList">
        <option value="Bank Negara Indonesia (BNI)">
        <option value="Bank Rakyat Indonesia (BRI)">
        <option value="Bank Mandiri">
        <option value="Bank Tabungan Negara (BTN)">
        <option value="Bank Syariah Indonesia (BSI)">
        <option value="Bank Jateng">
        <option value="Bank BPR">
        <option value="Bank Central Asia (BCA)">
        <option value="Bank CIMB Niaga">
        <option value="Bank Danamon">
        <option value="Bank Permata">
        <option value="Bank Panin">
        <option value="Bank Mega">
        <option value="Bank OCBC NISP">
        <option value="Bank Maybank Indonesia">
        <option value="Bank Sinarmas">
        <option value="Bank Muamalat">
        <option value="Bank Bukopin">
      </datalist>

      <!-- <p for="NUPTK" class="form-label mt-3">Nomor Rekening</p> -->
      <!-- Input Nomor Rekening (editable) -->
      <div class="mb-3 input-group mt-3">
        <span class="input-group-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet-fill" viewBox="0 0 16 16">
            <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v2h6a.5.5 0 0 1 .5.5c0 .253.08.644.306.958.207.288.557.542 1.194.542s.987-.254 1.194-.542C9.42 6.644 9.5 6.253 9.5 6a.5.5 0 0 1 .5-.5h6v-2A1.5 1.5 0 0 0 14.5 2z" />
            <path d="M16 6.5h-5.551a2.7 2.7 0 0 1-.443 1.042C9.613 8.088 8.963 8.5 8 8.5s-1.613-.412-2.006-.958A2.7 2.7 0 0 1 5.551 6.5H0v6A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5z" />
          </svg> <!-- Icon Rekening -->
        </span>
        <input type="text" inputmode="numeric" id="accountNumberInput" class="form-control editable" placeholder="Nomor Rekening Anda">
        <small class="ml-3 mt-1 help-text">Masukkan nomor rekening yang benar.</small>
      </div>

      <!-- <p for="NUPTK" class="form-label mt-3">Atas Nama Rekening</p> -->
      <!-- Input Atas Nama Rekening (editable) -->
      <div class="mb-3 input-group mt-3">
        <span class="input-group-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
            <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
            <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492z" />
          </svg> <!-- Icon Atas Nama Rekening -->
        </span>
        <input type="text" id="accountNameInput" class="form-control editable" placeholder="Nama Pemilik Rekening">
        <small class="ml-3 mt-1 help-text">Nama pemilik rekening harus sesuai.</small>
      </div>

      <button id="nextButton" class="btn btn-primary mt-3 gradient-button fw-bold mt-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
          <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
        </svg> Lanjut ke Pilih Kegiatan
      </button>
    </div>

    <!-- Step 3: Pilih kegiatan -->
    <div id="step3" class="hidden" style="display: none">
      <label for="activitySelect" class="form-label">Kegiatan yang akan kamu ikuti : </label>
      <select id="activitySelect" class="form-select mb-3 editable">
        <option value="" disabled selected>Pilih salah satu</option>
        <!-- Opsi kegiatan akan diisi secara dinamis oleh JavaScript -->
      </select>

      <!-- Opsi tambahan yang akan muncul jika kegiatan tertentu dipilih -->
      <div id="additionalOptions2" style="display: none;">
        <label for="additionalSelect2" class="form-label mt-2">Kegiatan simposium atau seminar :</label>
        <select id="additionalSelect2" class="form-select mb-3 editable">
          <option value="" disabled selected>Pilih salah satu</option>
          <option value="Simposium">Simposium</option>
          <option value="Seminar">Seminar</option>
        </select>
      </div>

      <!-- Opsi tambahan yang akan muncul jika kegiatan tertentu dipilih -->
      <div id="additionalOptions" style="display: none;">
        <label for="additionalSelect" class="form-label mt-2">Pilih tema Simposium :</label>
        <select id="additionalSelect" class="form-select mb-3 editable">
          <option value="" disabled selected>Pilih salah satu</option>
          <option value="Kemampuan Literasi">Kemampuan Literasi</option>//jika sudah diisi 300 maka tidak pilih lagi ?
          <option value="Kemampuan Numerasi">Kemampuan Numerasi</option>//jika sudah diisi 300 maka tidak pilih lagi ?
          <option value="Karakter">Karakter</option>//jika sudah diisi 300 maka tidak pilih lagi
          <option value="Iklim Keamanan Sekolah">Iklim Keamanan Sekolah</option>//jika sudah diisi 300 maka tidak pilih lagi
          <option value="Iklim Kebhinekaan">Iklim Kebhinekaan</option>//jika sudah diisi 300 maka tidak pilih lagi
          <option value="Kualitas Pembelajaran">Kualitas Pembelajaran</option>//jika sudah diisi 300 maka tidak pilih lagi
        </select>
      </div>

      <button id="submitFormButton" class="btn btn-primary gradient-button fw-bold">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
          <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
        </svg> Daftar sekarang
      </button>
    </div>

  </div>

  <div class="card bg-light text-white container formb" hidden>
    <div class="card-body">
      <div class="px-4 py-5 my-5 text-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="150"
          height="150"
          fill="green"
          class="bi bi-check-circle-fill"
          viewBox="0 0 16 16">
          <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
        <h1 class="display-5 fw-bold text-body-emphasis">
          Kamu berhasil terdaftar!
        </h1>
        <div class="col-lg-6 mx-auto">
          <p class="lead mb-4 text-dark">
            Sampai jumpa di kegiatan pada acara puncak!
          </p>
          <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="https://wa.me/082143168886" target="_blank" type="button" class="btn fw-bold rounded-pill btn-primary px-4gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
              </svg> Narahubung
            </a>
            <a
              type="button" target="_blank" href="mailto:bbgpjateng@kemdikbud.go.id"
              class="btn rounded-pill fw-bold btn-outline-primary px-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z" />
              </svg> Email
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="formc" hidden>
    <!-- Hero Section -->
    <section class="text-white text-center py-5">
      <div class="container">
        <h1 class="display-6 text-white fw-bold">Resume Pendaftaran</h1>
        <p class="lead">Terima kasih kakak telah mendaftar!. Festival Transformasi Pendidikan</p>
      </div>
    </section>

    <div class="container cetakboardingpass bg-white p-5 rounded shadow">
      <h1 class="mb-4 fw-bold">Status Pendaftaran</h1>
      <p class="lead">Festival Transformasi Pendidikan BBGP Jawa Tengah.</p>

      <center>
        <div id="qrcode"></div>
        <button class="btn btn-primary rounded-pill mt-3 fw-bold">
          Status : Terdaftar
        </button>
      </center>

      <hr>
      <div class="mt-4">
        <!-- Data Pendaftar -->
        <h5 class="fw-bold">Data Pendaftar:</h5>
        <p>Detail data kakak yang terdaftar.</p>

        <div class="mb-3 form-floating">
          <input type="text" id="regnuptk" class="form-control non-editable" disabled placeholder="Inputan otomatis anda tidak perlu mengisi.." />
          <label for="regnuptk">NUPTK</label>
        </div>

        <div class="mb-3 form-floating">
          <input type="text" id="regnama" class="form-control non-editable" disabled placeholder="Inputan otomatis anda tidak perlu mengisi.." />
          <label for="regnama">Nama Lengkap</label>
        </div>

        <div class="mb-3 form-floating">
          <input type="text" id="regjabatan" class="form-control non-editable" disabled placeholder="Inputan otomatis anda tidak perlu mengisi.." />
          <label for="regjabatan">Jabatan</label>
        </div>

        <div class="mb-3 form-floating">
          <input type="text" id="reginstansi" class="form-control non-editable" disabled placeholder="Inputan otomatis anda tidak perlu mengisi.." />
          <label for="reginstansi">Instansi</label>
        </div>

        <div class="mb-3 form-floating">
          <input type="text" id="regkabupaten" class="form-control non-editable" disabled placeholder="Inputan otomatis anda tidak perlu mengisi.." />
          <label for="regkabupaten">Kabupaten</label>
        </div>
      </div>

      <hr>
      <div class="mt-4">
        <h5 class="fw-bold">Detail Registrasi:</h5>
        <p>Detail kegiatan yang kakak ikuti.</p>

        <div class="mb-3 form-floating">
          <input type="text" id="regkodeKegiatan" class="form-control non-editable" disabled placeholder="Inputan otomatis anda tidak perlu mengisi.." />
          <label for="regkodeKegiatan">Kode Kegiatan</label>
        </div>

        <div class="mb-3 form-floating">
          <textarea id="regkegiatan" class="form-control non-editable" disabled placeholder="Inputan otomatis anda tidak perlu mengisi.." style="height: 100px;"></textarea>
          <label for="regkegiatan">Kegiatan</label>
        </div>

        <div class="mb-3 form-floating">
          <input type="text" id="regsubKegiatan" class="form-control non-editable" disabled placeholder="Inputan otomatis anda tidak perlu mengisi.." />
          <label for="regsubKegiatan">Sub Kegiatan</label>
        </div>

        <div class="mb-3 form-floating">
          <input type="text" id="regsubTema" class="form-control non-editable" disabled placeholder="Inputan otomatis anda tidak perlu mengisi.." />
          <label for="regsubTema">Sub Tema</label>
        </div>

        <button id="boardingPassButton" class="btn btn-primary mt-3 gradient-button fw-bold mt-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
          </svg> Unduh Boarding Pass
        </button>
      </div>

      <hr>
      <div class="mt-4 formunggah" hidden>

        <h5 class="fw-bold">Detail Naskah:</h5>
        <p>Detail naskah yang kakak unggah.</p>

        <!-- Input Judul Naskah -->
        <div class="form-floating mb-3 mt-3">
          <input type="text" id="judulnaskahInput" class="form-control editable" placeholder="Isi judul naskah anda">
          <label for="judulnaskahInput">Judul Naskah</label>
          <small class="mt-2 help-text">Judul naskah sesuai dengan tema dipilih.</small>

        </div>

        <!-- Input Link Google Drive Naskah -->
        <div class="form-floating mb-3">
          <input type="text" id="naskahInput" class="form-control editable" placeholder="Isi link google drive naskah anda">
          <label for="naskahInput">Link Google Drive Naskah Mode View</label>
          <button class="btn btn-outline-primary fw-bold mt-2" id="cekNaskahBtn">Cek Link Naskah</button>
        </div>


        <!-- Input Link Surat Pernyataan -->
        <div class="form-floating mb-3">
          <input type="text" id="suratInput" class="form-control editable" placeholder="Isi link google drive surat pernyataan anda">
          <label for="suratInput">Link Google Drive Surat Pernyataan Mode View</label>
          <button class="btn btn-outline-primary fw-bold mt-2 text-left" id="cekSuratBtn">Cek Link Surat</button>
        </div>



        <button id="unggahNaskahButton" class="btn btn-primary fw-bold mt-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
          </svg> Unggah Naskah
        </button>

      </div>

    </div>

  </div>

  <footer class="mt-5 text-center mb-5 text-white"> Balai Besar Guru Penggerak Jawa Tengah &copy; 2024 Festival Transformasi Pendidikan</footer>

  <script>
    // Register the Service Worker
    if ("serviceWorker" in navigator) {
      window.addEventListener("load", function() {
        navigator.serviceWorker
          .register(
            "data:text/javascript," +
            encodeURIComponent(`
          const CACHE_NAME = 'pwa-cache-v1';
          const urlsToCache = [
            '/',
            '/index.html'
          ];

          // Install Service Worker and cache files
          self.addEventListener('install', function(event) {
            event.waitUntil(
              caches.open(CACHE_NAME).then(function(cache) {
                return cache.addAll(urlsToCache);
              })
            );
          });

          // Fetch from cache
          self.addEventListener('fetch', function(event) {
            event.respondWith(
              caches.match(event.request).then(function(response) {
                return response || fetch(event.request);
              })
            );
          });

          // Activate new Service Worker and remove old caches
          self.addEventListener('activate', function(event) {
            var cacheWhitelist = [CACHE_NAME];
            event.waitUntil(
              caches.keys().then(function(cacheNames) {
                return Promise.all(
                  cacheNames.map(function(cacheName) {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                      return caches.delete(cacheName);
                    }
                  })
                );
              })
            );
          });
        `), {
              scope: "./"
            }
          )
          .then(function(registration) {
            console.log(
              "ServiceWorker registration successful with scope: ",
              registration.scope
            );
          })
          .catch(function(err) {
            console.log("ServiceWorker registration failed: ", err);
          });
      });
    }
  </script>
</body>

</html>