<script>
(function () {
    function initStepper(form) {
        const panels = Array.from(form.querySelectorAll('[data-step-panel]'));
        if (!panels.length) return;

        const prevBtn = form.querySelector('[data-stepper-prev]');
        const nextBtn = form.querySelector('[data-stepper-next]');
        const submitBtn = form.querySelector('[data-stepper-submit]');
        const counter = form.querySelector('[data-stepper-counter]');
        const indicators = Array.from(form.querySelectorAll('[data-step-indicator]'));

        let index = 0;
        const invalidField = form.querySelector('.is-invalid, .invalid');
        if (invalidField) {
            const invalidPanel = invalidField.closest('[data-step-panel]');
            const panelIndex = panels.indexOf(invalidPanel);
            if (panelIndex >= 0) index = panelIndex;
        }

        function sync() {
            panels.forEach(function (panel, i) {
                panel.style.display = i === index ? '' : 'none';
            });

            indicators.forEach(function (indicator, i) {
                const isActive = i === index;
                indicator.classList.toggle('active', isActive);
                indicator.classList.toggle('border-amber-300/40', isActive);
                indicator.classList.toggle('bg-amber-300/10', isActive);
                indicator.classList.toggle('text-amber-200', isActive);
                indicator.classList.toggle('border-slate-700', !isActive);
                indicator.classList.toggle('text-slate-300', !isActive);
            });

            if (prevBtn) prevBtn.style.display = index === 0 ? 'none' : '';
            if (nextBtn) nextBtn.style.display = index === panels.length - 1 ? 'none' : '';
            if (submitBtn) submitBtn.style.display = index === panels.length - 1 ? '' : 'none';
            if (counter) counter.textContent = 'Step ' + (index + 1) + ' of ' + panels.length;
        }

        function go(delta) {
            const nextIndex = index + delta;
            if (nextIndex < 0 || nextIndex >= panels.length) return;
            index = nextIndex;
            sync();
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        if (prevBtn) prevBtn.addEventListener('click', function () { go(-1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { go(1); });

        sync();
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form[data-stepper-form]').forEach(initStepper);
    });
})();
</script>
