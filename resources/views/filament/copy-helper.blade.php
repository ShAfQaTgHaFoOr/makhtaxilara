{{-- Global clipboard helper for admin table "Copy message" buttons. --}}
<script>
    window.mktCopy = function (el) {
        var text = (el.closest('[data-copy-text]') || el).dataset.copyText || '';

        var toast = function () {
            try {
                if (window.FilamentNotification) {
                    new window.FilamentNotification().title('Message copied').success().send();
                    return;
                }
            } catch (e) {}
            // Fallback toast if Filament's notification helper is unavailable.
            var t = document.createElement('div');
            t.textContent = '✓ Message copied';
            t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);'
                + 'background:#16a34a;color:#fff;padding:10px 18px;border-radius:8px;font-size:14px;'
                + 'font-weight:600;z-index:999999;box-shadow:0 6px 20px rgba(0,0,0,.25);';
            document.body.appendChild(t);
            setTimeout(function () { t.remove(); }, 2000);
        };

        var fallback = function () {
            var ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.top = '-9999px';
            document.body.appendChild(ta);
            ta.focus();
            ta.select();
            try { document.execCommand('copy'); } catch (e) {}
            ta.remove();
            toast();
        };

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(toast).catch(fallback);
        } else {
            fallback();
        }
    };
</script>
