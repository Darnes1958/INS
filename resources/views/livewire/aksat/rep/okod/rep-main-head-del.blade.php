<div x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >

    <div x-data  class="col-md-12 my-1">
        <div class="row">

          @role('info')
            <div class="col-md-4">
                <input  wire:model="search" wire:click="OpenTable" placeholder="عقد , حساب , زبون , فاتورة ... "  class="form-control"   type="text" id="search" autofocus>
            </div>
            <div class="col-md-3">
                <input  wire:model="no" wire:keydown.enter="ChkNoAndGo" placeholder="او أدخل رقم العقد هنا"  class="form-control"   type="text" id="No" autofocus>
            </div>
            <div   class="col-md-4" >

            @livewire('bank.bank-select')
            </div>
           <div class="col-md-1">
              <button wire:click="$emit('CloseOkod')"  type="button" class="btn btn-outline-danger btn-sm far fa-window-close" ></button>
           </div>
           @else
                <div class="col-md-4">
                    <input  wire:model="search" wire:click="OpenTable" placeholder="عقد , حساب , زبون , فاتورة ..."  class="form-control"   type="text" id="search" autofocus>
                </div>
                <div class="col-md-3">
                    <input  wire:model="no" wire:keydown.enter="ChkNoAndGo" placeholder="او أدخل رقم العقد هنا"  class="form-control"   type="text" id="No" autofocus>
                </div>
                <div   class="col-md-5" >
                   @livewire('bank.bank-select')
                </div>

           @endrole
        </div>


        <div x-show="$wire.IsSearch">
            <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
                <thead class="font-size-12">
                <tr>
                    <th>رقم العقد</th>
                    <th>رقم الحساب</th>
                    <th>الاسم</th>
                    <th>اجمالي التقسيط</th>
                    <th>القسط</th>
                </tr>
                </thead>
                <tbody id="addRow" class="addRow">
                @foreach($TableList as  $item)
                    <tr class="font-size-12">
                        <td > <a wire:click="selectItem({{ $item->no }})" href="#">{{$item->no}}</a>
                        <td > <a wire:click="selectItem({{ $item->no }})" href="#">{{$item->acc}}</a>
                        <td > <a wire:click="selectItem({{ $item->no }})" href="#" >{{$item->name}}</a>
                        <td > <a wire:click="selectItem({{ $item->no }})" href="#" >{{$item->sul}}</a>
                        <td > <a wire:click="selectItem({{ $item->no }})" href="#" >{{$item->kst}}</a>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $TableList->links('custom-pagination-links-view') }}
        </div>
    </div>



</div>

@push('scripts')
    <script>
        $(document).ready(function ()
        {
            $('#Bank_L').select2({
                closeOnSelect: true
            });
            $('#Bank_L').on('change', function (e) {
                var data = $('#Bank_L').select2("val");
            @this.set('bankno', data);
            @this.set('TheBankListIsSelectd', 1);
            });
        });
        window.livewire.on('bank-change-event',()=>{
            $('#Bank_L').select2({
                closeOnSelect: true
            });
        });
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

    <script>


        $(document).ready(function ()
        {
            $('#Main_L_All').select2({
                closeOnSelect: true
            });
            $('#Main_L_All').on('change', function (e) {
                var data = $('#Main_L_All').select2("val");
            @this.set('no', data);

            });
        });
        window.livewire.on('main-change-event',()=>{
            $('#Main_L_All').select2({
                closeOnSelect: true
            });

        });
    </script>
@endpush


