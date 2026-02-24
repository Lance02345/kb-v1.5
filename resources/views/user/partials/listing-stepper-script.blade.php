<script>
(function () {
    function initUploadUX(form) {
        const inputs = Array.from(form.querySelectorAll('input[type="file"]'));
        inputs.forEach(function (input) {
            if (input.dataset.uploadEnhanced === '1') return;
            input.dataset.uploadEnhanced = '1';

            const host = input.closest('label, .card, [data-upload-host]') || input.parentElement;
            if (!host) return;

            host.classList.add('listing-upload-dropzone');
            let preview = host.querySelector('.listing-upload-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'listing-upload-preview';
                host.appendChild(preview);
            }

            function render(files) {
                preview.innerHTML = '';
                if (!files || !files.length) return;

                Array.from(files).slice(0, 4).forEach(function (file) {
                    const item = document.createElement('div');
                    item.className = 'listing-upload-item';

                    if (file.type && file.type.indexOf('image/') === 0) {
                        const img = document.createElement('img');
                        img.alt = file.name;
                        img.src = URL.createObjectURL(file);
                        img.onload = function () {
                            URL.revokeObjectURL(img.src);
                        };
                        item.appendChild(img);
                    }

                    const name = document.createElement('span');
                    name.textContent = file.name;
                    item.appendChild(name);
                    preview.appendChild(item);
                });
            }

            ['dragenter', 'dragover'].forEach(function (eventName) {
                host.addEventListener(eventName, function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    host.classList.add('drag-over');
                });
            });

            ['dragleave', 'drop'].forEach(function (eventName) {
                host.addEventListener(eventName, function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    host.classList.remove('drag-over');
                });
            });

            host.addEventListener('drop', function (event) {
                const dropped = event.dataTransfer && event.dataTransfer.files ? event.dataTransfer.files : null;
                if (!dropped || !dropped.length) return;
                try {
                    input.files = dropped;
                } catch (e) {
                    return;
                }
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            input.addEventListener('change', function () {
                render(input.files);
            });
        });
    }

    function initStepper(form) {
        const panels = Array.from(form.querySelectorAll('[data-step-panel]'));
        if (!panels.length) return;

        const prevBtn = form.querySelector('[data-stepper-prev]');
        const nextBtn = form.querySelector('[data-stepper-next]');
        const submitBtn = form.querySelector('[data-stepper-submit]');
        const counter = form.querySelector('[data-stepper-counter]');
        const progressBar = form.querySelector('[data-stepper-progress]');
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
                const isComplete = i < index;
                const raw = indicator.dataset.rawTitle || indicator.textContent.trim();
                indicator.dataset.rawTitle = raw;
                indicator.classList.add('listing-step-indicator');
                indicator.innerHTML = '<span class="listing-step-dot">' + (i + 1) + '</span>' + raw;

                indicator.classList.toggle('active', isActive);
                indicator.classList.toggle('completed', isComplete);
                indicator.classList.toggle('border-amber-300/40', isActive);
                indicator.classList.toggle('bg-amber-300/10', isActive);
                indicator.classList.toggle('text-amber-200', isActive);
                indicator.classList.toggle('border-slate-700', !isActive && !isComplete);
                indicator.classList.toggle('text-slate-300', !isActive && !isComplete);
            });

            if (prevBtn) prevBtn.style.display = index === 0 ? 'none' : '';
            if (nextBtn) nextBtn.style.display = index === panels.length - 1 ? 'none' : '';
            if (submitBtn) submitBtn.style.display = index === panels.length - 1 ? '' : 'none';
            if (counter) counter.textContent = 'Step ' + (index + 1) + ' of ' + panels.length;
            if (progressBar) {
                const percent = panels.length > 1 ? (index / (panels.length - 1)) * 100 : 100;
                progressBar.style.width = percent + '%';
            }
        }

        function validateCurrentPanel() {
            const currentPanel = panels[index];
            if (!currentPanel) return true;

            const requiredFields = Array.from(currentPanel.querySelectorAll('input[required], select[required], textarea[required]'));
            for (let i = 0; i < requiredFields.length; i += 1) {
                if (!requiredFields[i].checkValidity()) {
                    requiredFields[i].reportValidity();
                    return false;
                }
            }
            return true;
        }

        function go(delta) {
            const nextIndex = index + delta;
            if (nextIndex < 0 || nextIndex >= panels.length) return;
            if (delta > 0 && !validateCurrentPanel()) return;
            index = nextIndex;
            sync();
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        if (prevBtn) prevBtn.addEventListener('click', function () { go(-1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { go(1); });

        sync();
        initUploadUX(form);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form[data-stepper-form]').forEach(initStepper);
    });
})();
</script>
