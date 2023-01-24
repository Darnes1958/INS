<div x-data>
    <!-- CSS -->


    <div x-trap.noscroll="$wire.showdiv" class="search-box " >
        <input  class="form-control " type='text' id="search_box" autocomplete="off"

               x-bind:disabled="!$wire.BankGeted" wire:model="search"
                wire:keyup="searchResult" @keydown.down="$focus.focus(div1)">

        <!-- Search result list -->
        @if($showdiv)

            <div class="position-relative" >
                <div  class=" w-100 border" >

          @if(!empty($records))

             @if(count($records)>0)
             <div id="div1" @keydown.down="$focus.focus(div2)" @keydown.up="$focus.focus(div5)" style="background: lightgray"
                  wire:click="fetchEmployeeDetail({{ $records[0]->no }})"
                  wire:keydown.enter="fetchEmployeeDetail({{ $records[0]->no }})"> {{ $records[0]->acc}} | {{ $records[0]->name}}| {{ $records[0]->kst}}</div>
            @endif
            @if(count($records)>1)
            <div id="div2" @keydown.down="$focus.focus(div3)" @keydown.up="$focus.focus(div1)"
                 wire:click="fetchEmployeeDetail({{ $records[1]->no }})"
                 wire:keydown.enter="fetchEmployeeDetail({{ $records[1]->no }})"> {{ $records[1]->acc}} | {{ $records[1]->name}}| {{ $records[1]->kst}}</div>
            @endif
            @if(count($records)>2)
            <div id="div3" @keydown.down="$focus.focus(div4)" @keydown.up="$focus.focus(div2)" style="background: lightgray"
                 wire:click="fetchEmployeeDetail({{ $records[2]->no }})"
                 wire:keydown.enter="fetchEmployeeDetail({{ $records[2]->no }})"> {{ $records[2]->acc}} | {{ $records[2]->name}}| {{ $records[2]->kst}}</div>
            @endif
            @if(count($records)>3)
            <div id="div4" @keydown.down="$focus.focus(div5)" @keydown.up="$focus.focus(div3)"
                 wire:click="fetchEmployeeDetail({{ $records[3]->no }})"
                 wire:keydown.enter="fetchEmployeeDetail({{ $records[3]->no }})"> {{ $records[3]->acc}} | {{ $records[3]->name}}| {{ $records[3]->kst}}</div>
            @endif
            @if(count($records)>4)
            <div id="div5" @keydown.down="$focus.focus(div1)" @keydown.up="$focus.focus(div4)" style="background: lightgray"
                 wire:click="fetchEmployeeDetail({{ $records[4]->no }})"
                 wire:keydown.enter="fetchEmployeeDetail({{ $records[4]->no }})"> {{ $records[4]->acc}} | {{ $records[4]->name}}| {{ $records[4]->kst}}</div>
            @endif
           @endif
                </div>
            </div>
            <div class="clear"></div>
        @endif

    </div>
</div>
@push('scripts')


    <script type="text/javascript">
        Livewire.on('gotobox',postid=>  {



              $("#search_box").focus();
              $("#search_box").select();

        })



    </script>
@endpush

