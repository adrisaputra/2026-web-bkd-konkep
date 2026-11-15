import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

window.showNotification = (message) => {
    const box = document.getElementById('notification-box');
    const text = document.getElementById('notification-text');

    if (!box || !text) {
        return;
    }

    text.textContent = message;
    window.bootstrap.Toast.getOrCreateInstance(box).show();
};

window.triggerSimulateService = (serviceName) => {
    window.showNotification(`Membuka layanan ${serviceName}. Silakan login dengan NIP Anda.`);
};

window.triggerDownload = (fileName) => {
    window.showNotification(`Mengunduh dokumen: ${fileName}`);
};
