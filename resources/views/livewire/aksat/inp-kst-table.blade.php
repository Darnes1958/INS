
<div class=" gy-1 my-1" style="border:1px solid lightgray;background: white;">
    <table class="table my-0 table-sm table-success table-bordered table-striped table-light "  id="mytable1" >

        <thead class="thead-dark font-size-12">
        <tr>
            <th width="5%">ت</th>
            <th width="20%">ت.الاستحقاق</th>
            <th width="20">ت.الخصم</th>
            <th width="12%">القسط</th>
            <th width="12%">الخصم</th>
            <th width="21%">طريقة الدفع</th>
            <th width="5%"></th>
            <th width="5%"></th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($TableList as $key=>$item)
            <tr class="font-size-12">
                <td > {{ $item->ser }} </td>
                <td > {{ $item->kst_date }} </td>
                <td> {{ $item->ksm_date }} </td>
                <td> {{ $item->kst }} </td>
                <td> {{ $item->ksm }} </td>
                <td> {{ $item->ksm_type_name }} </td>
                <td>
             @if($item->ksm && $item->ksm>0)
                    <i  wire:click="Edit({{ $item->ser }})"
                            class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
             @endif
                </td>
                <td>
                    @if($item->ksm && $item->ksm>0)
                   <i wire:click="Delete({{ $item->ser }})" class="btn btn-outline-danger btn-sm fa fa-times "></i>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>


    </table>
    {{ $TableList->links('custom-pagination-links-view') }}


  @livewire('tools.my-table2',
  ['TableName' => $post2,
  'ColNames' =>['item_no','item_name','quant','price','sub_tot'],
  'ColHeader' =>['رقم الصنف','اسم الصنف','الكمية','السعر','المجموع'],
  'pagno'=>5,
  'haswhereequel' => true,
  'whereequelfield' => 'order_no',
  'whereequelvalue' => 0,
  ])

    <div class="modal fade" id="KstEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="CloseKstEdit" type="button" class="btn-close" ></button>
                    <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">تعديل  فسط </h1>
                </div>
                <div class="modal-body">
                    @livewire('aksat.edit-kst')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="KstDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
                    <button wire:click="CloseKstDelete" type="button" class="close"  >
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>هل أنت متأكد من الإلغاء ?</h5>
                </div>
                <div class="modal-footer">
                    <button  wire:click="CloseKstDelete" type="button" class="btn btn-secondary close-btn" >تراجع</button>
                    <button type="button" wire:click.prevent="DoDelete()" class="btn btn-danger close-modal" data-dismiss="modal">نعم متأكد</button>
                </div>
            </div>
        </div>
    </div>


</div>

@stack('scripts')

@push('scripts')
    <script>
        window.addEventListener('CloseKstEdit', event => {
            $("#KstEdit").modal('hide');
        })
        window.addEventListener('OpenKstEdit', event => {
            $("#KstEdit").modal('show');
        })
        window.addEventListener('OpenKstDelete', event => {
            $("#KstDelete").modal('show');
        })
        window.addEventListener('CloseKstDelete', event => {
            $("#KstDelete").modal('hide');
        })
    </script>
@endpush

