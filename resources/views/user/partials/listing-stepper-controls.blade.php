<div class="listing-stepper-controls mt-4 rounded-xl border border-slate-700/70 bg-slate-950/50 px-4 py-3">
    <div class="mb-3 flex items-center justify-between gap-3">
        <div class="text-xs text-slate-400" data-stepper-counter></div>
        <div class="text-[11px] text-slate-500">Complete each step to unlock submit</div>
    </div>

    <div class="listing-step-progress mb-3">
        <span data-stepper-progress></span>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3">
        <button type="button" data-stepper-prev class="rounded-lg border border-slate-600 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-400">
            Back
        </button>

        <div class="flex gap-2">
            <button type="button" data-stepper-next class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">
                Continue
            </button>
            <button type="submit" data-stepper-submit class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">
                {{ $submitText ?? 'Submit Listing' }}
            </button>
        </div>
    </div>
</div>
