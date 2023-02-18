<div x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >

    <div x-data="{isTyped: @entangle('ShowSearch')}" x-trap.noscroll="isTyped" >
        <div class="row my-1">
            <div class="col-md-6">
                <input type="text" autofocus
                       placeholder="{{__('بحث عن الزبون ...')}}"
                       x-on:input.debounce.200ms="isTyped = ($event.target.value != '')"
                       autocomplete="off"
                       wire:model.debounce.300ms="search"
                       @keydown.enter="isTyped =false"

                       wire:keydown.enter="SearchEnter"
                       @keydown.down="$focus.focus(div1)"
                       aria-label="Search input" />
            </div>
            @role('info')

            <div class="col-md-1">
                <button wire:click="$emit('CloseOkodAll')"  type="button" class="btn btn-outline-danger btn-sm far fa-window-close" ></button>
            </div>
            @endrole
            {{-- search box --}}
            <div x-show="isTyped" x-cloak class="col-md-12">
                @if(count($records)>0)
                    <div class="position-relative" >
                        <div  class=" w-100 border" >
                            @if(count($records)>0)
                                <div id="div1" @keydown.down="$focus.focus(div2)" @keydown.up="$focus.focus(div5)" style="background: lightgray"
                                     wire:click="fetchEmployeeDetail({{ $records[0]->jeha_no }})" @click="isTyped =false"
                                     wire:keydown.enter="fetchEmployeeDetail({{ $records[0]->jeha_no }})" @keydown.enter="isTyped =false">
                                    {{ $records[0]->jeha_no}} | {{ $records[0]->jeha_name}}
                                </div>
                            @endif
                            @if(count($records)>1)
                                <div id="div2" @keydown.down="$focus.focus(div3)" @keydown.up="$focus.focus(div1)"
                                     wire:click="fetchEmployeeDetail({{ $records[1]->jeha_no }})" @click="isTyped =false"
                                     wire:keydown.enter="fetchEmployeeDetail({{ $records[1]->jeha_no }})" @keydown.enter="isTyped =false">
                                    {{ $records[1]->jeha_no}} | {{ $records[1]->jeha_name}}

                                </div>
                            @endif
                            @if(count($records)>2)
                                <div id="div3" @keydown.down="$focus.focus(div4)" @keydown.up="$focus.focus(div2)" style="background: lightgray"
                                     wire:click="fetchEmployeeDetail({{ $records[2]->jeha_no }})" @click="isTyped =false"
                                     wire:keydown.enter="fetchEmployeeDetail({{ $records[2]->jeha_no }})" @keydown.enter="isTyped =false"> {{ $records[2]->jeha_no}} | {{ $records[2]->jeha_name}}</div>
                            @endif
                            @if(count($records)>3)
                                <div id="div4" @keydown.down="$focus.focus(div5)" @keydown.up="$focus.focus(div3)"
                                     wire:click="fetchEmployeeDetail({{ $records[3]->jeha_no }})" @click="isTyped =false"
                                     wire:keydown.enter="fetchEmployeeDetail({{ $records[3]->jeha_no }})" @keydown.enter="isTyped =false"> {{ $records[3]->jeha_no}} | {{ $records[3]->jeha_name}}</div>
                            @endif
                            @if(count($records)>4)
                                <div id="div5" @keydown.down="$focus.focus(div6)" @keydown.up="$focus.focus(div4)" style="background: lightgray"
                                     wire:click="fetchEmployeeDetail({{ $records[4]->jeha_no }})" @click="isTyped =false"
                                     wire:keydown.enter="fetchEmployeeDetail({{ $records[4]->jeha_no }})" @keydown.enter="isTyped =false"> {{ $records[4]->jeha_no}} | {{ $records[4]->jeha_name}}</div>
                            @endif
                            @if(count($records)>5)
                                <div id="div6" @keydown.down="$focus.focus(div7)" @keydown.up="$focus.focus(div5)"
                                     wire:click="fetchEmployeeDetail({{ $records[5]->jeha_no }})" @click="isTyped =false"
                                     wire:keydown.enter="fetchEmployeeDetail({{ $records[5]->jeha_no }})" @keydown.enter="isTyped =false"> {{ $records[5]->jeha_no}} | {{ $records[5]->jeha_name}}</div>
                            @endif
                            @if(count($records)>6)
                                <div id="div7" @keydown.down="$focus.focus(div1)" @keydown.up="$focus.focus(div6)" style="background: lightgray"
                                     wire:click="fetchEmployeeDetail({{ $records[6]->jeha_no }})" @click="isTyped =false"
                                     wire:keydown.enter="fetchEmployeeDetail({{ $records[6]->jeha_no }})" @keydown.enter="isTyped =false"> {{ $records[6]->jeha_no}} | {{ $records[6]->jeha_name}}</div>
                            @endif
                        </div>
                    </div>


                @endif


            </div>
        </div>

    </div>
    <div >
            <table class="table table-sm  table-bordered table-striped table-light " width="100%"   >
                <thead class="font-size-11">
                <tr>
                    <th>رقم العقد</th>
                    <th>اجمالي العقد</th>
                    <th>القسط</th>
                    <th>البيان</th>
                </tr>
                </thead>
                <tbody id="addRow" class="addRow">
                @foreach($TableList as  $item)
                    <tr class="font-size-11">
                        <td > <a wire:click="selectItem({{ $item->no }},'{{$item->MainOrArc}}')" href="#">{{$item->no}}</a>
                        <td > <a wire:click="selectItem({{ $item->no }},'{{$item->MainOrArc}}')" href="#">{{$item->sul_tot}}</a>
                        <td > <a wire:click="selectItem({{ $item->no }},'{{$item->MainOrArc}}')" href="#" >{{$item->kst}}</a>
                        <td > <a wire:click="selectItem({{ $item->no }},'{{$item->MainOrArc}}')" href="#" >{{$item->MainOrArc}}</a>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $TableList->links() }}
        </div>
</div>

@push('scripts')
    <script>

        window.addEventListener('CloseKstManyModal', event => {
            $("#ModalKstMany").modal('hide');
        })
        window.addEventListener('OpenKstManyModal', event => {
            $("#ModalKstMany").modal('show');
        })
    </script>
    <script type="text/javascript">
        Livewire.on('ksthead_goto',postid=>  {

            if (postid=='no') {  $("#no").focus();$("#no").select(); }
            if (postid=='acc') {  $("#acc").focus();$("#acc").select(); }
        })
    </script>
@endpush


