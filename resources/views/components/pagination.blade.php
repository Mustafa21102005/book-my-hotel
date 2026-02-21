<div class="thmv-room-pagination">
    <nav aria-label="...">
        <ul class="pagination justify-content-center">

            {{-- Previous Page --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
            </li>

            {{-- Page Numbers --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                <li
                    class="page-item {{ $paginator->currentPage() == $page ? 'active' : '' }} {{ $page > 3 ? 'd-none d-md-block' : '' }} {{ $page > 4 ? 'd-none d-lg-block' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Next Page --}}
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
            </li>

        </ul>
    </nav>
</div>
