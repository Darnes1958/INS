<div x-data>
    <!-- CSS -->


    <div x-trap.noscroll="$wire.showdiv" class="search-box " >
        <input  class="form-control " type='text' id="search_box" autocomplete="off"

               x-bind:disabled="!$wire.ActiveSearch" wire:model="search"
                @keyup="$wire.searchResult" @keydown.down="$focus.focus(div1)"
                @keydown.enter="$wire.ChkItem"
        >

        <!-- Search result list -->
        @if($showdiv)

            <div class="position-relative" >
                <div  class=" w-100 border" >

          @if(!empty($records))

             @if(count($records)>1)
             <div id="div1" @keydown.down="$focus.focus(div2)" @keydown.up="$focus.focus(div5)" style="background: lightgray"
                  wire:click="fetchEmployeeDetail({{ $records[0]->item_no }})"
                  wire:keydown.enter="fetchEmployeeDetail({{ $records[0]->item_no }})">{{$records[0]->item_no}} | {{$records[0]->item_name}}</div>
            @endif
            @if(count($records)>2)
            <div id="div2" @keydown.down="$focus.focus(div3)" @keydown.up="$focus.focus(div1)"
                 wire:click="fetchEmployeeDetail({{ $records[1]->item_no }})"
                 wire:keydown.enter="fetchEmployeeDetail({{ $records[1]->item_no }})"> {{$records[1]->item_no}} | {{$records[1]->item_name}}</div>
            @endif
            @if(count($records)>3)
            <div id="div3" @keydown.down="$focus.focus(div4)" @keydown.up="$focus.focus(div2)" style="background: lightgray"
                 wire:click="fetchEmployeeDetail({{ $records[2]->item_no }})"
                 wire:keydown.enter="fetchEmployeeDetail({{ $records[2]->item_no }})"> {{$records[2]->item_no}} | {{$records[2]->item_name}}</div>
            @endif
            @if(count($records)>4)
            <div id="div4" @keydown.down="$focus.focus(div5)" @keydown.up="$focus.focus(div3)"
                 wire:click="fetchEmployeeDetail({{ $records[3]->item_no }})"
                 wire:keydown.enter="fetchEmployeeDetail({{ $records[3]->item_no }})"> {{$records[3]->item_no}} | {{$records[3]->item_name}}</div>
            @endif
            @if(count($records)>5)
            <div id="div5" @keydown.down="$focus.focus(div1)" @keydown.up="$focus.focus(div4)" style="background: lightgray"
                 wire:click="fetchEmployeeDetail({{ $records[4]->item_no }})"
                 wire:keydown.enter="fetchEmployeeDetail({{ $records[4]->item_no }})"> {{$records[4]->item_no}} | {{$records[4]->item_name}}</div>
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
        Livewire.on('gotoitembox',postid=>  {



              $("#search_box").focus();
              $("#search_box").select();

        })



    </script>
@endpush

