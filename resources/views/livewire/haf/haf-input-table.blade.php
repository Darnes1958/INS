<div x-data>

    <div class="modal fade" id="ModalManyNo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button wire:click="CloseManyNoModal" type="button" class="btn-close" ></button>
                    <h1 class="modal-title text-info fs-5 w-100" id="exampleModalLabel">تعديل الإزدواجية في أرقام العقود</h1>
                </div>
                <div class="modal-body">
                    @livewire('haf.haf-many-no')
                </div>
            </div>
        </div>
    </div>
    <div class="form-check form-check-inline">
        <input wire:model="search"  type="search"  style="margin: 5px;" placeholder="ابحث هنا .......">
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="DisRadio"
              name="inlineRadioOptions" id="inlineRadio1" value="DisAll">
        <label class="form-check-label" for="inlineRadio1">الكل</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="DisRadio"
               name="inlineRadioOptions" id="inlineRadio2" value="DisMe">
        <label class="form-check-label" for="inlineRadio2">ادخالاتي فقط</label>
    </div>
    <div class="form-check form-check-inline">
        <button x-show="$wire.HaveManyNo != 0"
                wire:click.prevent="OpenManyNo"
                class="border-0 text-danger"
                type="search"  style="margin: 5px;" > ({{$HaveManyNo}})ازدواجية</button>
    </div>

      <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>
          <th width="6%"><a wire:click="DoIndex('ser_in_hafitha')" href="#">ت</a></th>
          <th width="12%"><a wire:click="DoIndex('no')" href="#">رقم العقد</a></th>
          <th width="16%"><a wire:click="DoIndex('acc')" href="#">رقم الحساب</a></th>
          <th width="24%"><a wire:click="DoIndex('name')" href="#">الاسم</a></th>
          <th width="12%">التاريخ</th>
          <th width="8%">القسط</th>
          <th width="8%">الباقي</th>
          <th width="8%">الحالة</th>
          <th width="8%">&nbsp;</th>
          <th width="8%">&nbsp;</th>

        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
           @foreach($HafithaTable as $item)
             <tr class="font-size-12">
              <td > {{ $item->ser_in_hafitha }} </td>
              <td > {{ $item->no }} </td>
              <td> {{ $item->acc }} </td>
              <td> {{ $item->name }} </td>
              <td> {{ $item->ksm_date }} </td>
              <td> {{ $item->kst }} </td>
              <td> {{ $item->baky }} </td>
              @if($item->kst_type==5)
                 <td> أرشيف </td>
                 @else
                     <td> {{ $item->kst_type_name }} </td>
                 @endif
              <td style="padding-top: 2px;padding-bottom: 2px; ">
                @if($item->kst_type!=3)
                <i  class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"
                    wire:click="SelectItem({{ $item->no }},{{ $item->acc }},{{ $item->ser_in_hafitha }}, 'update')" ></i>
                @endif
              </td>
              <td style="padding-top: 2px;padding-bottom: 2px; ">
                <i  class="btn btn-outline-danger btn-sm fa fa-times "
                    wire:click="SelectItem({{ $item->no }},{{ $item->acc }},{{ $item->ser_in_hafitha }}, 'delete')"></i>
              </td>
            </tr>

          @endforeach
         </tbody>
      </table>
        <div class="modal fade" id="ModalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button wire:click="CloseUpdate" type="button" class="btn-close" ></button>
                        <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">تعديل قسط</h1>
                    </div>
                    <div class="modal-body">
                        @livewire('haf.update-kst')
                    </div>
                </div>
            </div>
        </div>

      {{ $HafithaTable->links() }}

</div>

@push('scripts')
<script type="text/javascript">
    window.addEventListener('delkst',function(e){
        MyConfirm.fire({
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Livewire.emit('DoDelete');
            }
        })
    });
    window.addEventListener('mmsg',function(e){
        MyMsg.fire({
            confirmButtonText:  e.detail,
        })
    });
</script>
<script>
    window.addEventListener('CloseUpdateModal', event => {
        $("#ModalUpdate").modal('hide');
    })
    window.addEventListener('OpenUpdateModal', event => {
        $("#ModalUpdate").modal('show');
    })
    window.addEventListener('CloseManyNoModal', event => {
        $("#ModalManyNo").modal('hide');
    })
    window.addEventListener('OpenManyNoModal', event => {
        $("#ModalManyNo").modal('show');
    })

</script>

@endpush

