<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $draw->name }} - {{ $event->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* === GLOBAL STYLES === */
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            min-height: 100vh;
        }

        /* Improved background responsiveness */
        @media (max-width: 768px) {
            body {
                background-attachment: scroll;
                background-size: cover;
            }
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5));
            z-index: 1;
        }

        .main-content {
            position: relative;
            z-index: 2;
            padding: 3rem 1rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* === CARD STYLES === */
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        /* === WINNER CARD ANIMATIONS === */
        .winner-card {
            animation: fadeInUp 0.8s ease-out;
            animation-fill-mode: both;
        }

        .winner-card:nth-child(1) { animation-delay: 0.2s; }
        .winner-card:nth-child(2) { animation-delay: 0.4s; }
        .winner-card:nth-child(3) { animation-delay: 0.6s; }
        .winner-card:nth-child(4) { animation-delay: 0.8s; }

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

        /* === CROWN ANIMATION === */
        .crown-animation {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        /* === ROLLING TEXT ANIMATION === */
        .rolling-text {
            height: 60px;
            overflow: hidden;
            position: relative;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            background: rgba(0, 0, 0, 0.3);
            margin: 20px 0;
        }

        .rolling-names {
            animation: rollNames 2s linear infinite;
            line-height: 60px;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        @keyframes rollNames {
            0% { transform: translateY(0); }
            100% { transform: translateY(-300px); }
        }

        /* === DRAWING STATUS ANIMATIONS === */
        .drawing-status {
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }

        .spinning-wheel {
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* === COUNTDOWN ANIMATION === */
        .countdown {
            font-size: 3rem;
            font-weight: bold;
            animation: countdownPulse 1s ease-in-out infinite;
        }

        @keyframes countdownPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        /* === LOADING DOTS === */
        .loading-dots::after {
            content: '';
            animation: dots 1.5s linear infinite;
        }

        @keyframes dots {
            0%, 20% { content: ''; }
            40% { content: '.'; }
            60% { content: '..'; }
            80%, 100% { content: '...'; }
        }

        /* === PARTICLES ANIMATION === */
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
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        .particle:nth-child(1) { width: 8px; height: 8px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 6px; height: 6px; left: 30%; animation-delay: 1s; }
        .particle:nth-child(3) { width: 10px; height: 10px; left: 50%; animation-delay: 2s; }
        .particle:nth-child(4) { width: 7px; height: 7px; left: 70%; animation-delay: 3s; }
        .particle:nth-child(5) { width: 9px; height: 9px; left: 90%; animation-delay: 0.5s; }

        @keyframes float {
            0%, 100% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10%, 90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
            }
        }

        /* === CONFETTI ANIMATION === */
        .confetti {
            position: fixed;
            top: -10px;
            width: 10px;
            height: 10px;
            animation: confetti-fall 3s linear infinite;
        }

        .confetti:nth-child(odd) {
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
        }

        .confetti:nth-child(even) {
            background: linear-gradient(45deg, #45b7d1, #96ceb4);
        }

        @keyframes confetti-fall {
            to {
                transform: translateY(100vh) rotate(360deg);
            }
        }

        /* === RESPONSIVE DESIGN === */
        @media (max-width: 768px) {
            .main-content {
                padding: 2rem 1rem;
            }
            
            .countdown {
                font-size: 2rem;
            }
            
            .rolling-names {
                font-size: 1.2rem;
            }
        }

        /* === BUTTON STYLES === */
        .admin-controls {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .btn-draw {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            border: none;
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        .btn-draw:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
        }

        .btn-draw:disabled {
            background: linear-gradient(45deg, #6c757d, #5a6268);
            transform: none;
            box-shadow: none;
        }

        /* === STATUS INDICATORS === */
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-waiting { background: #ffc107; animation: pulse 2s infinite; }
        .status-drawing { background: #17a2b8; animation: spin 1s linear infinite; }
        .status-completed { background: #28a745; }
    </style>
</head>

<body style="background-image: url('{{ $event && $event->image ? asset('uploads/' . $event->image) : asset('default.jpg') }}');">

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

        <h1 class="display-4 mb-3">{{ $event->name }}</h1>
        <h2 class="h3 mb-4 text-warning">{{ $draw->name }}</h2>

        {{-- Prize Image --}}
        @if ($draw->image)
            <div class="mb-4">
                <img src="{{ asset('uploads/' . $draw->image) }}" 
                     alt="Gambar Hadiah" 
                     class="img-fluid rounded shadow-lg"
                     style="max-height: 300px; border: 3px solid rgba(255, 255, 255, 0.3);">
            </div>
        @endif

        {{-- Prize Description --}}
        @if ($draw->description)
            <p class="lead mb-4 text-light">{{ $draw->description }}</p>
        @endif

        {{-- Winners Display --}}
        <div id="winnersContainer">
            @if ($draw->winners->count() > 0)
                <div class="row justify-content-center">
                    @foreach ($draw->winners->sortBy('position') as $winner)
                        <div class="col-md-6 col-lg-4 mb-4 winner-card">
                            <div class="card h-100 text-center">
                                <div class="card-body position-relative">
                                    <div class="position-absolute top-0 start-50 translate-middle">
                                        <span class="badge bg-primary rounded-pill fs-6">
                                            Pemenang #{{ $winner->position }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-3 mt-3">
                                        @if ($winner->position == 1)
                                            <i class="fas fa-crown fa-4x text-warning crown-animation"></i>
                                        @elseif($winner->position == 2)
                                            <i class="fas fa-medal fa-4x text-light"></i>
                                        @elseif($winner->position == 3)
                                            <i class="fas fa-award fa-4x" style="color: #CD7F32;"></i>
                                        @else
                                            <i class="fas fa-trophy fa-4x text-success"></i>
                                        @endif
                                    </div>
                                    
                                    <h3 class="card-title mb-2">{{ $winner->participant->name }}</h3>
                                    @if ($winner->participant->company)
                                        <p class="text-light opacity-75 mb-0">{{ $winner->participant->company }}</p>
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
            @endif
        </div>

        {{-- Drawing Interface --}}
        <div id="drawingInterface" style="display: {{ $draw->winners->count() > 0 ? 'none' : 'block' }};">
            <div class="card drawing-animation mx-auto" style="max-width: 600px;">
                <div class="card-body py-5">
                    
                    {{-- Waiting Status --}}
                    <div id="waitingStatus">
                        <i class="fas fa-hourglass-half fa-4x mb-4 text-warning"></i>
                        <h3 class="mb-3">
                            <span class="status-indicator status-waiting"></span>
                            Loading
                        </h3>
                        <p class="opacity-75">Silakan tunggu, akan segera memulai proses undian...</p>
                    </div>

                    {{-- Drawing Status --}}
                    <div id="drawingStatus" style="display: none;">
                        <i class="fas fa-cog spinning-wheel fa-4x mb-4 text-info"></i>
                        <h3 class="drawing-status loading-dots mb-3">
                            <span class="status-indicator status-drawing"></span>
                            Sedang Memilih Pemenang
                        </h3>

                        {{-- Rolling Names --}}
                        @if ($event->participants->count() > 0)
                            <div class="rolling-text">
                                <div class="rolling-names" id="rollingNames">
                                    @foreach ($event->participants->shuffle()->take(15) as $participant)
                                        <div>{{ $participant->name }}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="countdown mt-3">
                            <i class="fas fa-dice fa-2x me-2"></i>
                            <span id="countdownNumber">3</span>
                        </div>

                        <p class="opacity-75 mt-3">
                            Sistem sedang memproses undian secara acak...
                        </p>
                    </div>

                    {{-- Result Status --}}
                    <div id="resultStatus" style="display: none;">
                        <i class="fas fa-check-circle fa-4x mb-4 text-success"></i>
                        <h3 class="mb-3">
                            <span class="status-indicator status-completed"></span>
                            Pemenang Telah Dipilih!
                        </h3>
                        <p class="opacity-75">Halaman akan diperbarui otomatis...</p>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- Admin Controls (Only visible to admin) --}}
    @if(auth()->user() && auth()->user()->role == 'admin')
        <div class="admin-controls">
            <button id="startDrawBtn" class="btn btn-draw">
                <i class="fas fa-play me-2"></i>
                Mulai Undian
            </button>
        </div>
    @endif

    {{-- JavaScript --}}
    <script>
        class LotterySystem {
            constructor() {
                this.isDrawing = false;
                this.drawId = {{ $draw->id ?? 'null' }};
                this.eventId = {{ $event->id ?? 'null' }};
                this.checkInterval = null;
                this.refreshInterval = null;
                this.rollingInterval = null;
                
                this.init();
            }

            init() {
                this.bindEvents();
                this.startRealtimeCheck();
                
                // Auto-refresh participants for rolling animation
                this.updateRollingNames();
            }

            bindEvents() {
                const startBtn = document.getElementById('startDrawBtn');
                if (startBtn) {
                    startBtn.addEventListener('click', () => this.startDraw());
                }
            }

            async startDraw() {
                if (this.isDrawing) return;
                
                this.isDrawing = true;
                const btn = document.getElementById('startDrawBtn');
                
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sedang Mengundi...';
                }

                this.showDrawingInterface();
                
                try {
                    // Simulate API call to start draw
                    const response = await fetch(`/api/draws/${this.drawId}/start`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                        }
                    });
                    
                    if (response.ok) {
                        this.startCountdown();
                    } else {
                        throw new Error('Failed to start draw');
                    }
                } catch (error) {
                    console.error('Error starting draw:', error);
                    this.resetDrawButton();
                }
            }

            showDrawingInterface() {
                document.getElementById('waitingStatus').style.display = 'none';
                document.getElementById('drawingStatus').style.display = 'block';
                this.startRollingAnimation();
            }

            startRollingAnimation() {
                const rollingNames = document.getElementById('rollingNames');
                if (!rollingNames) return;

                this.rollingInterval = setInterval(() => {
                    this.updateRollingNames();
                }, 2000);
            }

            stopRollingAnimation() {
                if (this.rollingInterval) {
                    clearInterval(this.rollingInterval);
                    this.rollingInterval = null;
                }
            }

            async updateRollingNames() {
                try {
                    const response = await fetch(`/api/events/${this.eventId}/participants`);
                    const participants = await response.json();
                    
                    const rollingNames = document.getElementById('rollingNames');
                    if (rollingNames && participants.length > 0) {
                        // Shuffle and take 15 participants
                        const shuffled = participants.sort(() => 0.5 - Math.random()).slice(0, 15);
                        rollingNames.innerHTML = shuffled.map(p => `<div>${p.name}</div>`).join('');
                    }
                } catch (error) {
                    console.error('Error updating rolling names:', error);
                }
            }

            startCountdown() {
                const countdownElement = document.getElementById('countdownNumber');
                let count = 3;

                const countdownInterval = setInterval(() => {
                    count--;
                    if (countdownElement) {
                        countdownElement.textContent = count;
                    }
                    
                    if (count <= 0) {
                        clearInterval(countdownInterval);
                        this.stopRollingAnimation();
                        this.showResult();
                    }
                }, 1000);
            }

            showResult() {
                this.createConfetti();
                
                setTimeout(() => {
                    document.getElementById('drawingStatus').style.display = 'none';
                    document.getElementById('resultStatus').style.display = 'block';
                    
                    // Stop intervals and reload page after showing result
                    setTimeout(() => {
                        this.stopAllIntervals();
                        window.location.reload();
                    }, 3000);
                }, 1000);
            }

            startRealtimeCheck() {
                // Check for updates every 3 seconds
                this.checkInterval = setInterval(async () => {
                    await this.checkForUpdates();
                }, 3000);
                
                // Also set up periodic page refresh every 15 seconds as backup
                this.refreshInterval = setInterval(() => {
                    if (!this.isDrawing) {
                        window.location.reload();
                    }
                }, 15000);
            }

            async checkForUpdates() {
                try {
                    const response = await fetch(`/api/draws/${this.drawId}/status`);
                    const data = await response.json();
                    
                    // Check if new winners found
                    if (data.winners && data.winners.length > 0) {
                        // Stop all intervals before reload
                        this.stopAllIntervals();
                        
                        // Show confetti first, then reload
                        this.createConfetti();
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                        return;
                    }
                    
                    // Update drawing status if admin started drawing from another session
                    if (data.status === 'drawing' && !this.isDrawing) {
                        this.isDrawing = true;
                        this.showDrawingInterface();
                        this.startCountdown();
                    }
                    
                    // If drawing is completed but no winners yet, keep checking
                    if (data.status === 'completed' && !this.isDrawing) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                    
                } catch (error) {
                    console.error('Error checking for updates:', error);
                    // On error, refresh page after 5 seconds
                    setTimeout(() => {
                        window.location.reload();
                    }, 5000);
                }
            }

            stopAllIntervals() {
                if (this.checkInterval) {
                    clearInterval(this.checkInterval);
                    this.checkInterval = null;
                }
                if (this.refreshInterval) {
                    clearInterval(this.refreshInterval);
                    this.refreshInterval = null;
                }
                if (this.rollingInterval) {
                    clearInterval(this.rollingInterval);
                    this.rollingInterval = null;
                }
            }

            createConfetti() {
                for (let i = 0; i < 100; i++) {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.animationDelay = Math.random() * 3 + 's';
                    confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                    
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => {
                        confetti.remove();
                    }, 5000);
                }
            }

            resetDrawButton() {
                const btn = document.getElementById('startDrawBtn');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-play me-2"></i>Mulai Undian';
                }
                this.isDrawing = false;
            }

            destroy() {
                this.stopAllIntervals();
            }
        }

        // Initialize lottery system when page loads
        document.addEventListener('DOMContentLoaded', () => {
            window.lotterySystem = new LotterySystem();
            
            // Show confetti if there are already winners
            @if($draw->winners->count() > 0)
                setTimeout(() => {
                    window.lotterySystem.createConfetti();
                }, 1000);
            @endif
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (window.lotterySystem) {
                window.lotterySystem.destroy();
            }
        });
    </script>

</body>

</html>
