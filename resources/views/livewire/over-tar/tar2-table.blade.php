<div x-data x-show="$wire.TarGet" class="col-md-6 mb-2">
    <label  class="form-label align-right" >الغاء ترجيعات سابقة</label>
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="13%">الرقم الألي</th>
      <th width="13%">التاريخ</th>
      <th width="16%">المبلغ</th>
      <th width="10%"></th>

    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($TableList as  $item)
      <tr class="font-size-12">
        <td>{{$item->wrec_no}}</td>
        <td>{{$item->tar_date}}</td>
        <td>{{$item->kst}}</td>
        <td  style="padding-top: 2px;padding-bottom: 2px; ">
          <i wire:click="selectItem({{ $item->wrec_no }},'delete')"
             class="btn btn-outline-danger btn-sm fa fa-times "></i>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $TableList->links() }}
</div>
