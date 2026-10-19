<x-layout title="Join Room">
    <div class="room-form">

        {{-- Header --}}
        <header class="room-form__header">
            <h1 class="room-form__title">&gt; ENTER ROOM CODE_</h1>
            <p class="room-form__subtitle">
                Input the 6-character code provided by the host.
            </p>
        </header>

        {{-- Code Input (wrapped in form) --}}
        <section class="room-form__code">
            <form id="joinForm" method="POST" action="{{ route('rooms.join.store') }}">
                @csrf

                {{-- Hidden field that receives the merged 6-char code --}}
                <input type="hidden" name="code" id="hiddenCode" value="">

                <div class="code-slots" id="codeInputs">
                    <input type="text" class="code-slot-input" maxlength="1" autocomplete="off" spellcheck="false" inputmode="text" />
                    <input type="text" class="code-slot-input" maxlength="1" autocomplete="off" spellcheck="false" inputmode="text" />
                    <input type="text" class="code-slot-input" maxlength="1" autocomplete="off" spellcheck="false" inputmode="text" />
                    <input type="text" class="code-slot-input" maxlength="1" autocomplete="off" spellcheck="false" inputmode="text" />
                    <input type="text" class="code-slot-input" maxlength="1" autocomplete="off" spellcheck="false" inputmode="text" />
                    <input type="text" class="code-slot-input" maxlength="1" autocomplete="off" spellcheck="false" inputmode="text" />
                </div>
            </form>
        </section>

        {{-- Footer --}}
        <footer class="room-form__footer">
            <a href="{{ route('lobby') }}" class="retro-btn-link">[← BACK]</a>
            <button type="submit" form="joinForm" class="retro-btn-primary">[ PROCEED ]</button>
        </footer>

    </div>

    {{-- Retro Error Modal --}}
    <div id="errorModal" class="retro-modal" hidden>
        <div class="retro-modal__panel">
            <div class="retro-modal__header">
                <span class="prompt-symbol">&gt;</span>
                <span class="retro-modal__title">SYSTEM ALERT_</span>
                <span class="cursor-blink">_</span>
            </div>
            <p class="retro-modal__message" id="modalMessage"></p>
            <button type="button" class="retro-btn-primary" id="modalClose">[ OK ]</button>
        </div>
    </div>

    {{-- Input behavior + form submission --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.code-slot-input');
            const form = document.getElementById('joinForm');
            const hiddenCode = document.getElementById('hiddenCode');
            const modal = document.getElementById('errorModal');
            const modalMessage = document.getElementById('modalMessage');
            const modalClose = document.getElementById('modalClose');

            // ---------- Input behavior (auto-advance, backspace, paste) ----------
            inputs.forEach((input, index) => {
                if (index === 0) input.focus();

                input.addEventListener('input', (e) => {
                    e.target.value = e.target.value.toUpperCase();
                    if (e.target.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.requestSubmit();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasted = (e.clipboardData.getData('text') || '')
                        .replace(/[^A-Za-z0-9]/g, '')
                        .toUpperCase()
                        .slice(0, 6);

                    for (let i = 0; i < pasted.length; i++) {
                        if (inputs[i]) inputs[i].value = pasted[i];
                    }

                    const nextIndex = Math.min(pasted.length, inputs.length - 1);
                    inputs[nextIndex].focus();
                });
            });

            // ---------- Modal close handlers ----------
            modalClose.addEventListener('click', () => {
                modal.hidden = true;
                inputs[0].focus();
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.hidden = true;
                    inputs[0].focus();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.hidden) {
                    modal.hidden = true;
                    inputs[0].focus();
                }
            });

            // ---------- Form submission (fetch) ----------
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Merge the 6 inputs into one code
                const code = Array.from(inputs).map(i => i.value).join('');

                if (code.length !== 6) {
                    modalMessage.textContent = 'Please enter all 6 characters.';
                    modal.hidden = false;
                    return;
                }

                hiddenCode.value = code;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: new FormData(form),
                    });

                    const data = await response.json();

                    // Success — redirect to the room
                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }

                    // Error — show the modal
                    modalMessage.textContent = data.message || 'Something went wrong.';
                    modal.hidden = false;

                } catch (err) {
                    modalMessage.textContent = 'Network error. Please try again.';
                    modal.hidden = false;
                }
            });
        });
    </script>
</x-layout>