<div id="compare-drawer" class="pointer-events-none fixed bottom-6 left-1/2 z-50 hidden w-[min(94vw,680px)] -translate-x-1/2 rounded-2xl border border-slate-800 bg-slate-900/90 p-4 shadow-2xl transition duration-300">
    <div class="flex items-center justify-between">
        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-200">Compare shortlist</p>
        <div class="flex items-center gap-2">
            <button type="button" id="compare-drawer-clear" class="text-xs text-slate-400 hover:text-white opacity-40 cursor-not-allowed">Clear</button>
            <button type="button" id="compare-drawer-close" class="text-xs text-slate-400 hover:text-white">Close</button>
        </div>
    </div>
    <ul id="compare-drawer-list" class="mt-3 flex flex-wrap gap-3 text-[11px]"></ul>
    <div class="mt-3 flex items-center justify-between">
        <span id="compare-drawer-count" class="text-[11px] text-slate-400"></span>
        <a id="compare-drawer-button" href="#" class="rounded-full bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200" target="_blank" rel="noopener">Compare now</a>
    </div>
</div>
