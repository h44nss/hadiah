<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $draw->name }} - {{ $event->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            color: white;
        }

        body {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .main-content {
            position: relative;
            z-index: 2;
            padding: 3rem 1rem;
        }

        /* --- Styles tidak berubah dari sebelumnya --- */
        .winner-card {
            animation: fadeInUp 0.8s ease-out;
            animation-fill-mode: both;
        }

        .winner-card:nth-child(1) {
            animation-delay: 0.2s;
        }

        .winner-card:nth-child(2) {
            animation-delay: 0.4s;
        }

        .winner-card:nth-child(3) {
            animation-delay: 0.6s;
        }

        .winner-card:nth-child(4) {
            animation-delay: 0.8s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .crown-animation {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        .rolling-text {
            height: 60px;
            overflow: hidden;
            position: relative;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.2);
            margin: 20px 0;
        }

        .rolling-names {
            animation: rollNames 3s linear infinite;
            line-height: 60px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        @keyframes rollNames {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-300px);
            }
        }

        .drawing-status {
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }
        }

        .countdown {
            font-size: 3rem;
            font-weight: bold;
            animation: countdownPulse 1s ease-in-out infinite;
        }

        @keyframes countdownPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .loading-dots::after {
            content: '';
            animation: dots 2s linear infinite;
        }

        @keyframes dots {

            0%,
            20% {
                content: '';
            }

            40% {
                content: '.';
            }

            60% {
                content: '..';
            }

            80%,
            100% {
                content: '...';
            }
        }

        .particles {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: #ffd700;
            border-radius: 50%;
            animation: float 4s ease-in-out infinite;
        }

        .particle:nth-child(1) {
            width: 8px;
            height: 8px;
            left: 10%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            width: 6px;
            height: 6px;
            left: 30%;
            animation-delay: 1s;
        }

        .particle:nth-child(3) {
            width: 10px;
            height: 10px;
            left: 50%;
            animation-delay: 2s;
        }

        .particle:nth-child(4) {
            width: 7px;
            height: 7px;
            left: 70%;
            animation-delay: 3s;
        }

        .particle:nth-child(5) {
            width: 9px;
            height: 9px;
            left: 90%;
            animation-delay: 0.5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10%,
            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
            }
        }

        .confetti {
            position: fixed;
            top: -10px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
            width: 10px;
            height: 10px;
            animation: confetti-fall 3s linear infinite;
        }

        @keyframes confetti-fall {
            to {
                transform: translateY(100vh) rotate(360deg);
            }
        }
    </style>
</head>

<body
    style="background-image: url('{{ $event && $event->image ? asset('uploads/' . $event->image) : asset('default.jpg') }}');">

    {{-- Overlay --}}
    <div class="overlay"></div>

    {{-- Particles --}}
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    {{-- Main Content --}}
    <div class="main-content container text-center">

        <h1 class="display-4">{{ $event->name }}</h1>
        <h2 class="h3 mb-4">{{ $draw->name }}</h2>

        {{-- Gambar hadiah --}}
        @if ($draw->image)
            <div class="mb-4">
                <img src="{{ asset('uploads/' . $draw->image) }}" alt="Gambar Hadiah" class="img-fluid rounded shadow"
                    style="max-height: 300px;">
            </div>
        @endif

        {{-- Deskripsi hadiah --}}
        @if ($draw->description)
            <p class="lead">{{ $draw->description }}</p>
        @endif

        {{-- Pemenang --}}
        @if ($draw->winners->count() > 0)
            <div class="row justify-content-center">
                @foreach ($draw->winners->sortBy('position') as $winner)
                    <div class="col-md-6 col-lg-4 mb-4 winner-card">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <div class="mb-3">
                                    @if ($winner->position == 1)
                                        <i class="fas fa-crown fa-4x text-warning crown-animation"></i>
                                    @elseif($winner->position == 2)
                                        <i class="fas fa-medal fa-4x text-light"></i>
                                    @elseif($winner->position == 3)
                                        <i class="fas fa-award fa-4x" style="color: #CD7F32;"></i>
                                    @else
                                        <i class="fas fa-trophy fa-4x text-success"></i>
                                    @endif
                                    <div class="position-absolute top-0 start-50 translate-middle">
                                        <span class="badge bg-primary rounded-pill fs-6">Pemenang
                                            #{{ $winner->position }}</span>
                                    </div>
                                </div>
                                <h3 class="card-title">{{ $winner->participant->name }}</h3>
                                @if ($winner->participant->company)
                                    <p class="text-light opacity-75">{{ $winner->participant->company }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="mt-4 text-light opacity-75">
                <i class="fas fa-clock me-2"></i>
                Undian dijalankan pada {{ $draw->winners->first()->drawn_at->format('d F Y, H:i') }} WIB
            </p>
        @else
            {{-- Jika belum ada pemenang --}}
            <div class="card drawing-animation mx-auto" style="max-width: 600px;">
                <div class="card-body py-5">
                    <div id="drawingStatus">
                        <i class="fas fa-cog spinning-wheel fa-4x mb-4"></i>
                        <h3 class="drawing-status loading-dots">Sedang Memilih Pemenang</h3>

                        {{-- Rolling nama --}}
                        @if ($event->participants->count() > 0)
                            <div class="rolling-text">
                                <div class="rolling-names" id="rollingNames">
                                    @foreach ($event->participants->shuffle()->take(20) as $participant)
                                        <div>{{ $participant->name }}</div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-light">Belum ada peserta terdaftar.</p>
                        @endif

                        <div class="countdown mt-3">
                            <i class="fas fa-hourglass-half me-2"></i>
                            <span id="countdownNumber">5</span>
                        </div>

                        <p class="opacity-75 mt-3">Harap tunggu, sistem sedang memproses undian...</p>
                    </div>

                    <div id="waitingStatus" style="display: none;">
                        <i class="fas fa-hourglass-half fa-4x mb-4 opacity-75"></i>
                        <h3>Undian Akan Segera Dimulai</h3>
                        <p class="opacity-75">Menunggu pengumuman pemenang...</p>
                    </div>
                </div>
            </div>
        @endif

    </div>

    {{-- Script JS --}}
    <script>
        function createConfetti() {
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.animationDelay = Math.random() * 3 + 's';
                confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                document.body.appendChild(confetti);
                setTimeout(() => confetti.remove(), 5000);
            }
        }

        function simulateDrawing() {
            const countdownElement = document.getElementById('countdownNumber');
            const drawingStatus = document.getElementById('drawingStatus');
            const waitingStatus = document.getElementById('waitingStatus');
            let count = 5;

            const countdownInterval = setInterval(() => {
                count--;
                countdownElement.textContent = count;
                if (count <= 0) {
                    clearInterval(countdownInterval);
                    createConfetti();
                    setTimeout(() => {
                        drawingStatus.style.display = 'none';
                        waitingStatus.style.display = 'block';
                        waitingStatus.innerHTML = `
                            <i class="fas fa-check-circle fa-4x mb-4 text-success"></i>
                            <h3>Undian Selesai!</h3>
                            <p class="opacity-75">Pemenang telah dipilih. Halaman akan diperbarui...</p>`;
                        setTimeout(() => location.reload(), 3000);
                    }, 2000);
                }
            }, 1000);
        }

        @if ($draw->status == 'pending' || $draw->winners->count() == 0)
            setTimeout(() => simulateDrawing(), 2000);
            setInterval(() => location.reload(), 15000);
        @else
            setTimeout(() => createConfetti(), 1000);
        @endif
    </script>

</body>

</html>
