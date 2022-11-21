<div>
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="10%">ت</th>
      <th width="20%">رقم العقد</th>
      <th width="20%">رقم الحساب</th>
      <th width="30%">الاسم</th>
      <th width="10%">القسط</th>
      <th width="10%">الحالة</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
       @foreach($HafithaTable as $item)
         <tr class="font-size-12">
          <td > {{ $item->ser_in_hafitha }} </td>
          <td > {{ $item->no }} </td>
          <td> {{ $item->acc }} </td>
          <td> {{ $item->name }} </td>
          <td> {{ $item->kst }} </td>
          <td> {{ $item->kst_type_name }} </td>
          <td style="padding-top: 2px;padding-bottom: 2px; ">
            <i  class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
          </td>
          <td style="padding-top: 2px;padding-bottom: 2px; ">
            <i  class="btn btn-outline-danger btn-sm fa fa-times "></i>
          </td>
        </tr>
      @endforeach
     </tbody>
  </table>
  {{ $HafithaTable->links('custom-pagination-links-view') }}
</div>

