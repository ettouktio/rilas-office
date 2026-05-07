@if ($paginator->hasPages())
    <div class="pager">
        @if ($paginator->onFirstPage())
            <span class="btn btn-ghost disabled">{{ __('ui.common.previous') }}</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-ghost">{{ __('ui.common.previous') }}</a>
        @endif

        <span class="pager-text">{{ __('ui.common.page', ['number' => $paginator->currentPage()]) }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-ghost">{{ __('ui.common.next') }}</a>
        @else
            <span class="btn btn-ghost disabled">{{ __('ui.common.next') }}</span>
        @endif
    </div>
@endif
