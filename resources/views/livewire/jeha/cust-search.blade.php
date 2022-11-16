<div >
  <div class="d-flex justify-content-sm-between  my-1"> <input wire:model="search"   type="search"  style="width: 100%" placeholder="ابحث هنا ......."> </div>
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th>رقم الزبون</th>;
      <th>الاسم</th>;
      <th>اختيار</th>;
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($TableList as  $item)
      <tr class="font-size-12">
        <td>{{$item->jeha_no}}</td>
        <td>{{$item->jeha_name}}</td>
        <td  style="padding-top: 2px;padding-bottom: 2px; ">
          <i wire:click="selectItem({{ $item->jeha_no }})" class="btn btn-outline-primary btn-sm far fa-arrow-alt-circle-down editable-input" style="margin-left: 2px;"></i>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $TableList->links('custom-pagination-links-view') }}


</div>