<x-card-layout title="LKJSDF">
    <canvas id="canvas"></canvas>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var canvas = document.getElementById('canvas')
            const data = JSON.stringify(@json($registration));
            window.QRCode.toCanvas(canvas, data, function (error) {
                if (error) console.error(error)
                console.log('success!');
            })
        })
    </script>
</x-card-layout>
