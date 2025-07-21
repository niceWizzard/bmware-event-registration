<x-card-layout title="Your QR Code" card-title="Registered" class="items-center"
>
    <canvas id="canvas" class="w-full "></canvas>
    <p class="text-base text-on-surface text-center">
        <span class="font-bold">Keep this QR Code.</span>
        <br>
        You can show this to the attendee on the day of the event.
    </p>
    <!-- This will be your "Download QR Code" link -->
    <div class="flex gap-2 max-sm:flex-col">
        <a
            class="btn btn-primary"
            download="qr-code.png"
            id="downloadLink"
        >
            Download QR Code
        </a>
        <a href="{{route('events.show', $event->short_name)}}" class="btn btn-secondary">
            Back to Event
        </a>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const canvas = document.getElementById('canvas');
            const downloadLink = document.getElementById('downloadLink');
            const containerWidth = canvas.parentElement.offsetWidth;

            const data = JSON.stringify(@json($qrCodeData, JSON_THROW_ON_ERROR));
            const text = @json($event->short_name, JSON_THROW_ON_ERROR);

            const dpr = window.devicePixelRatio || 1;

            // 🧠 Dynamically calculate QR size based on available width
            const qrSize = Math.min(384, containerWidth - 32); // Max 384px, with 16px margin each side
            const textHeight = 28;
            const padding = 0;

            const totalWidth = qrSize + padding * 2;
            const totalHeight = qrSize + textHeight + padding * 2;

            canvas.width = totalWidth * dpr;
            canvas.height = totalHeight * dpr;
            canvas.style.width = `${totalWidth}px`;
            canvas.style.height = `${totalHeight}px`;

            const qrCanvas = document.createElement("canvas");
            qrCanvas.width = qrSize;
            qrCanvas.height = qrSize;

            window.QRCode.toCanvas(qrCanvas, data, {width: qrSize}, function (error) {
                if (error) {
                    console.error(error);
                    return;
                }

                const ctx = canvas.getContext('2d');
                ctx.scale(dpr, dpr);

                // Fill background
                ctx.fillStyle = "white";
                ctx.fillRect(0, 0, totalWidth, totalHeight);

                // Center QR code
                ctx.drawImage(qrCanvas, padding, padding);

                // Draw event short_name centered below QR code
                ctx.fillStyle = "black";
                ctx.font = "bold 20px sans-serif";
                ctx.textAlign = "center";
                ctx.textBaseline = "top";
                ctx.fillText(text, totalWidth / 2, padding + qrSize + 4);

                // Set download link
                downloadLink.href = canvas.toDataURL("image/png");
            });
        });
    </script>


</x-card-layout>
