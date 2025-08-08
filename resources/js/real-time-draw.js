class RealTimeDraw {
    constructor(drawId, options = {}) {
        this.drawId = drawId;
        this.options = {
            updateInterval: 5000,
            onStatusChange: null,
            onWinnersUpdate: null,
            ...options,
        };
        this.currentStatus = null;
        this.currentWinnersCount = 0;
        this.isRunning = false;
    }

    start() {
        if (this.isRunning) return;

        this.isRunning = true;
        this.checkStatus();
        this.interval = setInterval(() => {
            this.checkStatus();
        }, this.options.updateInterval);
    }

    stop() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
        this.isRunning = false;
    }

    async checkStatus() {
        try {
            const response = await fetch(`/api/draw/${this.drawId}/status`);
            const data = await response.json();

            // Check for status change
            if (this.currentStatus !== data.status) {
                this.currentStatus = data.status;
                if (this.options.onStatusChange) {
                    this.options.onStatusChange(data.status, data);
                }
            }

            // Check for winners update
            if (this.currentWinnersCount !== data.current_winners) {
                this.currentWinnersCount = data.current_winners;
                if (this.options.onWinnersUpdate) {
                    this.options.onWinnersUpdate(data.winners, data);
                }
            }

            // Auto-stop if draw is completed
            if (data.status === "completed") {
                this.stop();
            }
        } catch (error) {
            console.error("Error checking draw status:", error);
        }
    }

    async executeDraw() {
        try {
            const response = await fetch(`/api/draw/${this.drawId}/execute`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.error || "Failed to execute draw");
            }

            return await response.json();
        } catch (error) {
            console.error("Error executing draw:", error);
            throw error;
        }
    }
}

// Usage example
document.addEventListener("DOMContentLoaded", function () {
    const drawId = document.querySelector("[data-draw-id]")?.dataset.drawId;

    if (drawId) {
        const realTimeDraw = new RealTimeDraw(drawId, {
            onStatusChange: function (status, data) {
                console.log("Status changed to:", status);
                updateDrawStatus(status, data);
            },
            onWinnersUpdate: function (winners, data) {
                console.log("Winners updated:", winners);
                updateWinnersList(winners);
            },
        });

        realTimeDraw.start();

        // Execute draw button
        const executeBtn = document.querySelector("[data-execute-draw]");
        if (executeBtn) {
            executeBtn.addEventListener("click", async function (e) {
                e.preventDefault();

                if (
                    !confirm(
                        "Yakin ingin menjalankan undian ini? Proses tidak dapat dibatalkan."
                    )
                ) {
                    return;
                }

                try {
                    executeBtn.disabled = true;
                    executeBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin me-1"></i>Menjalankan...';

                    await realTimeDraw.executeDraw();

                    executeBtn.innerHTML =
                        '<i class="fas fa-check me-1"></i>Undian Selesai';
                } catch (error) {
                    alert("Error: " + error.message);
                    executeBtn.disabled = false;
                    executeBtn.innerHTML =
                        '<i class="fas fa-play me-1"></i>Jalankan Undian';
                }
            });
        }
    }
});

function updateDrawStatus(status, data) {
    const statusBadge = document.querySelector("[data-status-badge]");
    if (statusBadge) {
        statusBadge.className = `badge bg-${
            status === "completed" ? "success" : "warning"
        }`;
        statusBadge.textContent =
            status === "completed" ? "Selesai" : "Belum Dijalankan";
    }
}

function updateWinnersList(winners) {
    const winnersContainer = document.querySelector("[data-winners-container]");
    if (!winnersContainer) return;

    if (winners.length === 0) {
        winnersContainer.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-hourglass-half fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada pemenang</h5>
            </div>
        `;
        return;
    }

    winnersContainer.innerHTML = winners
        .map(
            (winner) => `
        <div class="col-md-6 mb-3 winner-card" style="animation-delay: ${
            winner.position * 0.2
        }s">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <div class="position-relative">
                        ${getWinnerIcon(winner.position)}
                        <div class="position-absolute top-0 start-0">
                            <span class="badge bg-primary rounded-pill">${
                                winner.position
                            }</span>
                        </div>
                    </div>
                    <h5 class="card-title">${winner.participant.name}</h5>
                    ${
                        winner.participant.company
                            ? `<p class="text-muted mb-1">${winner.participant.company}</p>`
                            : ""
                    }
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Terpilih: ${formatDateTime(winner.drawn_at)}
                    </small>
                </div>
            </div>
        </div>
    `
        )
        .join("");
}

function getWinnerIcon(position) {
    switch (position) {
        case 1:
            return '<i class="fas fa-crown fa-3x text-warning mb-2"></i>';
        case 2:
            return '<i class="fas fa-medal fa-3x text-secondary mb-2"></i>';
        case 3:
            return '<i class="fas fa-award fa-3x mb-2" style="color: #CD7F32;"></i>';
        default:
            return '<i class="fas fa-trophy fa-3x text-success mb-2"></i>';
    }
}

function formatDateTime(dateTime) {
    const date = new Date(dateTime);
    return (
        date.toLocaleDateString("id-ID") +
        " " +
        date.toLocaleTimeString("id-ID")
    );
}
