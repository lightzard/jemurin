# jemurin
Smart Jemuran Prototype
Arduino-based integration with telkom API for notifications

## Deskripsi
Aplikasi ini memprotoypekan jemuran pintar yang dapat otomatis mengatur jemuran dengan menyesuaikan kondisi yang ada. Kondisi yang dimaksud antara lain:
* Apabila cuaca mendung/hujan maka tali jemuran akan otomatis tergulung dan mengirimkan notifikasi via SMS ke pengguna (melalu Telkom API) bahwa jemuran telah digulung
* Apabila jemuran sudah kering (berat jemuran sudah kurang dari batas treshold 'kering') maka jemuran akan otomatis tergulung dan mengirimkan notifikasi via SMS ke pengguna (melalu Telkom API) bahwa jemuran telah digulung
* Apabila cuaca cerah, maka jemuran akan dibuka

## Fitur
Pendeteksian cuaca dimodelkan dengan sensor cahaya menggunakan Arduino UNO. Pendeteksian berat pakaian yang sudah kering menggunakan potensiometer. Telkom SMS API diimplementasikan pada set_rain.php dan set_finish.php yang akan dieksekusi Arduino yang terkoneksi dengan jaringan internet melalui script.

## About Us
SunSquare Studio:
* Riza Herzego Nida F
* Irfan Nur Afif
* Kurniagusta Dwinto
* Muhammad Faris
* Yusuf Cahyo
