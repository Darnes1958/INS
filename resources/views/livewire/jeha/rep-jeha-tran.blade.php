
<div  >
    <div class="row">
        <div class="col-md-1">
            <label  for="jehano" class="form-label-me">رقم الزبون</label>

        </div>
        <div class="col-md-2">

            <input wire:model="jeha_no" wire:keydown.enter="JehaKeyDown"
                   class="form-control"  type="number"  id="jehano" autofocus>
        </div>
        <div class="col-md-1" >
            <button wire:click="OpenJehaSerachModal" type="button" class="btn btn-outline-primary btn-sm fa fa-arrow-alt-circle-down" data-bs-toggle="modal"></button>
        </div>
        <div class="col-md-4">
           <input wire:model="jeha_name"  class="form-control  "   type="text"  id="jehaname" readonly>
        </div>
        <div class="col-md-3">
            <input wire:model="tran_date" wire:keydown.enter="DateKeyDown" class="form-control  "   type="date"  id="tran_date">
        </div>
    </div>

    <div class="modal fade" id="ModalRepjeha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="CloseJehaSerachModal" type="button" class="btn-close" ></button>
                </div>
                <div class="modal-body">
                    @livewire('jeha.cust-search')
                </div>
            </div>
        </div>
    </div>
    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>
            <th >البيان</th>
            <th style="width: 14%">التاريخ</th>
            <th style="width: 14%">مدين</th>
            <th style="width: 14%">دائن</th>
            <th style="width: 20%">رقم المستند</th>
            <th style="width: 20%">طريقة الدفع</th>

        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($RepTable as $key=> $item)
            <tr class="font-size-12">
                <td > {{ $item->data }} </td>
                <td > {{ $item->order_date }} </td>
                <td> {{ $item->mden }} </td>
                <td> {{ $item->daen }} </td>
                <td> {{ $item->order_no }} </td>
                <td> {{ $item->type_name }} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $RepTable->links('custom-pagination-links-view') }}

</div>

@push('scripts')


    <script type="text/javascript">
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
        Livewire.on('gotonext',postid=>  {
            if (postid=='tran_date') {  $("#tran_date").focus();$("#tran_date").select(); };
            if (postid=='jehano') {  $("#jehano").focus(); $("#jehano").select();};
        })

        window.addEventListener('ClosejehaModal', event => {
            $("#ModalRepjeha").modal('hide');
        })
        window.addEventListener('OpenjehaModal', event => {
            $("#ModalRepjeha").modal('show');
        })
    </script>


@endpush

