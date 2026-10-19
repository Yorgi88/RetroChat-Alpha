<footer class="retro-footer">
    <div class="retro-footer__left">
        <span class="status-dot"></span>
        <span>SYSTEM ONLINE</span>
    </div>

    <div class="retro-footer__center">
        &copy; {{ date('Y') }} // EPHEMERAL CHAT PROTOCOL v1.0
    </div>

    <div class="retro-footer__right">
        <span
            x-data
            x-init="
             const tick = () => $el.textContent = new Date().toLocaleTimeString('en-GB');
             tick();
             const id = setInterval(tick, 1000);
             return () => clearInterval(id);
           "
        ></span>
    </div>
</footer>