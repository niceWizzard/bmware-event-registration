<x-card-layout title="LKJSDF">
    <section class="flex flex-col justify-center items-center gap-2">
        <h3 class="text-2xl font-bold">Registered!</h3>
        <canvas id="canvas" class="w-full"></canvas>
        <p class="text-base text-on-surface text-center">
            <span class="font-bold">Keep this QR Code.</span>
            <br>
            You can show this to the attendee on the day of the event.
        </p>
        <!-- This will be your "Download QR Code" link -->
        <a id="downloadLink"
           class="btn primary w-full text-center"
           download="qr-code.png">
            Download QR Code
        </a>
        <a href="{{route('events.show', $event->slug)}}" class="btn secondary w-full text-center">
            Back to Event
        </a>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const canvas = document.getElementById('canvas');
            const data = JSON.stringify(@json($registration, JSON_THROW_ON_ERROR));
            const downloadLink = document.getElementById('downloadLink');

            window.QRCode.toCanvas(canvas, data, function (error) {
                if (error) {
                    console.error(error);
                    return;
                }

                console.log('QR code generated!');

                const ctx = canvas.getContext('2d');
                const text = @json($event->short_name);

                // Font settings
                ctx.font = "bold 20px sans-serif";
                ctx.textAlign = "center";
                ctx.textBaseline = "middle";

                const textWidth = ctx.measureText(text).width;
                const textHeight = 24; // approximate height
                const padding = 10;

                const rectX = (canvas.width - textWidth) / 2 - padding;
                const rectY = (canvas.height - textHeight) / 2 - padding / 2;
                const rectWidth = textWidth + padding * 2;
                const rectHeight = textHeight + padding;

                // Draw background rectangle
                ctx.fillStyle = "white";
                ctx.fillRect(rectX, rectY, rectWidth, rectHeight);

                // Draw text
                ctx.fillStyle = "black";
                ctx.fillText(text, canvas.width / 2, canvas.height / 2);

                // Set download link
                downloadLink.href = canvas.toDataURL("image/png");
                downloadLink.style.display = 'inline-block';
            });
        });
    </script>

</x-card-layout>
