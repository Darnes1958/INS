<div >
  <div class="d-flex justify-content-sm-between  my-1">
    <input wire:model="search"   type="search"  style="width: 100%" placeholder="ابحث هنا .......">
    @if($Favorite==1)
      <i wire:click="selectFav(0)"
           class="btn btn-outline-success btn-sm  fas fa-star editable-input" style="margin-left: 2px;"></i>
    @else
        <i wire:click="selectFav(1)"
           class="btn btn-outline-warning btn-sm  far fa-star editable-input" style="margin-left: 2px;"></i>
    @endif
  </div>
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th>رقم الزبون</th>
      <th>الاسم</th>

    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($TableList as  $item)
      <tr class="font-size-12">
        <td><a wire:click="selectItem({{ $item->jeha_no }})" href="#">{{$item->jeha_no}}</a> </td>
        <td><a wire:click="selectItem({{ $item->jeha_no }})" href="#">{{$item->jeha_name}}</a></td>

      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $TableList->links('custom-pagination-links-view') }}


</div>