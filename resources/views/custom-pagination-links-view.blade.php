@if ($paginator->hasPages())
    <div class="d-flex justify-content-sm-between  my-1">

        @if ( ! $paginator->onFirstPage())
            {{-- First Page Link --}}
            <a role="button"
                class="mx-.5 px-2 py-1  border text-center  rounded-circle  "
                wire:click="gotoPage(1)"
            >
                <<
            </a>
            @if($paginator->currentPage() > 2)
                {{-- Previous Page Link --}}
                <a role="button"
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
                    @if ($paginator->currentPage() > 4 && $page === 1)
                        <div class=" mx-.5">
                            <span class="font-weight-bolder">.</span>
                            <span class="font-weight-bolder">.</span>
                            <span class="font-weight-bolder">.</span>
                        </div>
                    @endif

                    <!--  Show active page two pages before and after it.  -->
                    @if ($page == $paginator->currentPage())
                        <span role="button" class="mx-.5 px-1 py-1  bg-white text-center    " style="border: solid 1px grey; height: 30px;min-width: 30px;">{{ $page }}</span>
                    @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() + 3 || $page === $paginator->currentPage() + 4 ||
                             $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2 || $page === $paginator->currentPage() - 3 || $page === $paginator->currentPage() - 4)
                        <span role="button" class="mx-.5 px-1 py-1  text-center  bg-soft-success border-1   " style="border: solid 1px grey; height: 30px;min-width: 30px;"
                           wire:click="gotoPage({{$page}})">{{ $page }} </span>
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
                <a class="mx-.5 px-2 py-1 border text-center border rounded-circle  " role="button"
                   wire:click="nextPage"
                   rel="next">
                    >
                </a>
            @endif
            <a role="button"
                class="mx-.5 px-2 py-1 border text-center border rounded-circle  "
                wire:click="gotoPage({{ $paginator->lastPage() }})"
            >
                >>
            </a>
        @endif
    </div>
  <span class="mx-2">صفحة رقم  <strong style="color: #bf800c"> {{$paginator->currentPage()}}</strong > من <strong style="color: #bf800c">{{$paginator->lastPage()}}</strong> صفحة </span>
@endif
