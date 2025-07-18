import './bootstrap';
import {Alpine} from "alpinejs";
import flatpickr from "flatpickr";
import QRCode from "qrcode";
import Quill from "quill";

window.Alpine = Alpine
window.flatpickr = flatpickr;
window.QRCode = QRCode;
window.Quill = Quill;

Alpine.start()


const transformDataTime = () => {
    document.querySelectorAll('[data-time]').forEach(el => {
        const raw = el.textContent;
        if (!raw) return;
        const date = new Date(raw);
        el.textContent = new Intl.DateTimeFormat(navigator.language, {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        }).format(date);
    });
}

window.transformDataTime = transformDataTime;
