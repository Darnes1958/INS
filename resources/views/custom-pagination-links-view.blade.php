@if ($paginator->hasPages())
    <div class="d-flex justify-content-sm-between  my-1">

        @if ( ! $paginator->onFirstPage())
            {{-- First Page Link --}}
            <a
                class="mx-.5 px-2 py-1  border text-center  rounded-circle  "
                wire:click="gotoPage(1)"
            >
                <<
            </a>
            @if($paginator->currentPage() > 2)
                {{-- Previous Page Link --}}
                <a
                    class="mx-.5 px-2 py-1  border  text-center rounded-circle"
                    wire:click="previousPage"
                >
                    <
                </a>
            @endif
        @endif

        <!-- Pagination Elements -->
        @foreach ($elements as $element)
            <!-- Array Of Links -->
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <!--  Use three dots when current page is greater than 3.  -->
                    @if ($paginator->currentPage() > 3 && $page === 2)
                        <div class=" mx-.5">
                            <span class="font-weight-bolder">.</span>
                            <span class="font-weight-bolder">.</span>
                            <span class="font-weight-bolder">.</span>
                        </div>
                    @endif

                    <!--  Show active page two pages before and after it.  -->
                    @if ($page == $paginator->currentPage())
                        <span class="mx-.5 px-2 py-1   border  text-center  rounded-circle  ">{{ $page }}</span>
                    @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 ||
                             $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2)
                        <a class="mx-.5 px-2 py-1  text-center  border rounded-circle  "
                           wire:click="gotoPage({{$page}})">{{ $page }}</a>
                    @endif

                    <!--  Use three dots when current page is away from end.  -->
                    @if ($paginator->currentPage() < $paginator->lastPage() - 2
                             && $page === $paginator->lastPage() - 1)
                        <div class=" mx-.5">
                            <span class="font-weight-bolder">.</span>
                            <span class="font-weight-bolder">.</span>
                            <span class="font-weight-bolder">.</span>
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            @if($paginator->lastPage() - $paginator->currentPage() >= 2)
                <a class="mx-.5 px-2 py-1 border text-center border rounded-circle  "
                   wire:click="nextPage"
                   rel="next">
                    >
                </a>
            @endif
            <a
                class="mx-.5 px-2 py-1 border text-center border rounded-circle  "
                wire:click="gotoPage({{ $paginator->lastPage() }})"
            >
                >>
            </a>
        @endif
    </div>
@endif
