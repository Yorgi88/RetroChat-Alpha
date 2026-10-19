<x-layout title="Create Room">
    <div class="room-form">

        {{-- Header --}}
        <header class="room-form__header">
            <h1 class="room-form__title">&gt; CREATE ROOM CODE_</h1>
            <p class="room-form__subtitle">
                Share this code with the other loser
            </p>
        </header>

        {{-- Code Display --}}
        <section class="room-form__code">
            <div class="code-slots" id="codeSlots">
                {{-- JS will inject the 6 characters here --}}
                 @foreach (str_split($code) as $char)
                    <div class="code-slot">{{ $char }}</div>
                 @endforeach
            </div>

            <button type="button" class="retro-copy-btn" id="copyBtn">
                [ COPY CODE ]
            </button>
        </section>

        {{-- Footer --}}
        <footer class="room-form__footer">
            <a href="{{ route('lobby') }}" class="retro-btn-link">[← BACK]</a>

          <form method="POST" action="{{ route('rooms.store') }}">
             @csrf
             <input type="hidden" name="code" value="{{ $code }}">
             <button type="submit" class="retro-btn-primary">[ PROCEED ]</button>
          </form>
        </footer>

    </div>

    
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const code = @json($code);

        const copyBtn = document.getElementById('copyBtn');
        copyBtn.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(code);
                copyBtn.textContent = '[ COPIED! ]';
                setTimeout(() => copyBtn.textContent = '[ COPY CODE ]', 1500);
            } catch (err) {
                copyBtn.textContent = '[ COPY FAILED ]';
                setTimeout(() => copyBtn.textContent = '[ COPY CODE ]', 1500);
            }
        });
    });
</script>
</x-layout>