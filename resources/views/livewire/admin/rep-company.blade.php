<div x-data x-show="$wire.Show" class="col-md-8">
  <div class="card">
    <div class="card-header">عرض لبيانات الشركات</div>
     <div class="card-body">
        <table class="table-sm table-bordered " width="100%"  id="perlist" >
          <thead>
          <tr>
            <th width="15%">رقم الشركة</th>
            <th width="20%">اسم الشركة </th>
            <th width="50%">بيان الشركة</th>
            <th width="15%">قاعدة البيانات</th>
          </tr>
          </thead>
          <tbody id="addRow" class="addRow">
          @foreach($Tabledata as  $item)
            <tr>
              <td > {{ $item->id }} </td>
              <td > {{ $item->CompanyName }} </td>
              <td> {{ $item->CompanyNameSuffix }} </td>
              <td> {{ $item->Company }} </td>
            </tr>
          @endforeach
          </tbody>
          <br>
        </table>

     </div>
  </div>
</div>
