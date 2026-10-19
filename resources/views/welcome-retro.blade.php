<x-layout title="Welcome">
    <div style="text-align: center; padding: 60px 20px;">

        <h1 style="font-size: 48px; font-weight: 800; letter-spacing: 2px; margin-bottom: 8px;">
            RETRO<span style="color: #6366f1;">::</span>CHAT
        </h1>

        <p style="color: #6b7280; font-size: 16px; letter-spacing: 1px; margin-bottom: 40px;">
            SYSTEM READY
        </p>

        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">

            <a href="{{ route('rooms.create') }}" class="btn" style="font-size: 16px; padding: 14px 32px;">
               + Create Room
           </a>

           <a href="{{ route('rooms.join') }}" class="btn" style="font-size: 16px; padding: 14px 32px; background: #1f2937;">
              → Join Room
           </a>

        </div>

    <div id="retro-lines" style="margin-top: 60px; color: #9ca3af; font-size: 16px; min-height: 60px;">
    <p class="retro-line" style="opacity: 0; transition: opacity 0.6s ease;">We don't care what you discuss.</p>
    <p class="retro-line" style="opacity: 0; transition: opacity 0.6s ease;">We don't give a shit...</p>
    <p class="retro-line" style="opacity: 0; transition: opacity 0.6s ease; color: #6366f1; font-weight: bold;">You have 44 minutes.</p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const lines = [
            { text: "We don't care what you discuss.", color: "#9ca3af", weight: "normal" },
            { text: "We don't give a shit...", color: "#9ca3af", weight: "normal" },
            { text: "You have forty-four minutes.", color: "#6366f1", weight: "bold" }
        ];

        const container = document.getElementById('retro-lines');
        container.innerHTML = '';

        let lineIndex = 0;
        let charIndex = 0;
        let currentP = null;

        function typeNext() {
            if (lineIndex >= lines.length) return;

            if (!currentP) {
                currentP = document.createElement('p');
                currentP.style.margin = '4px 0';
                currentP.style.color = lines[lineIndex].color;
                currentP.style.fontWeight = lines[lineIndex].weight;
                currentP.style.fontSize = '13px';
                container.appendChild(currentP);
            }

            const line = lines[lineIndex];

            if (charIndex < line.text.length) {
                currentP.textContent += line.text[charIndex];
                charIndex++;
                setTimeout(typeNext, 40); // 40ms per character
            } else {
                // Line finished — pause, then move to next
                lineIndex++;
                charIndex = 0;
                currentP = null;
                setTimeout(typeNext, 800); // pause between lines
            }
        }

        setTimeout(typeNext, 800); // initial delay
    });
</script>

    </div>
</x-layout>