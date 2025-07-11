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

            window.QRCode.toCanvas(canvas, data, function (error) {
                if (error) {
                    console.error(error);
                    return;
                }

                console.log('QR code generated!');

                // Generate PNG data from canvas
                const dataUrl = canvas.toDataURL("image/png");

                // Make the download link visible and set its href
                const downloadLink = document.getElementById('downloadLink');
                downloadLink.href = dataUrl;
                downloadLink.style.display = 'inline-block'; // show the link
            });
        });
    </script>
</x-card-layout>
