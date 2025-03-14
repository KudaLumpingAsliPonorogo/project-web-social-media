function playNotificationSound() {
    const audio = new Audio('<?= BASE_URL ?>assets/sounds/notification.mp3');
    audio.play();
}

// Contoh penggunaan
document.addEventListener('DOMContentLoaded', function () {
    // Trigger notifikasi suara saat ada notifikasi baru
    if (document.querySelector('.notification')) {
        playNotificationSound();
    }
});