@if ($paginator->hasPages())
  <ul class="d-flex justify-content-sm-between  my-1">
    <!-- prev -->
    @if ($paginator->onFirstPage())
      <a class="w-16 px-2 py-1 text-center  rounded-circle border bg-gray-200">Prev</a>
    @else
      <a class="w-16 px-2 py-1 text-center  rounded-circle border shadow bg-white pe-auto" wire:click="previousPage">Prev</a>
    @endif
    <!-- prev end -->

    <!-- numbers -->
    @foreach ($elements as $element)
      <div class="d-flex ">
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <a class="mx-2 w-10 px-2 py-1 text-center  rounded-circle border shadow bg-blue-500 text-white pe-auto" role="button" wire:click="gotoPage({{$page}})">{{$page}}</a>
            @else
              <a class="mx-2 w-10 px-2 py-1 text-center  rounded-circle shadow bg-white pe-auto" role="button" wire:click="gotoPage({{$page}})">{{$page}}</a>
            @endif
          @endforeach
        @endif
      </div>
    @endforeach
    <!-- end numbers -->


    <!-- next  -->
    @if ($paginator->hasMorePages())
      <a class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer" wire:click="nextPage">Next</a>
    @else
      <a class="w-16 px-2 py-1 text-center rounded border bg-gray-200">Next</a>
    @endif
    <!-- next end -->
  </ul>
@endif
