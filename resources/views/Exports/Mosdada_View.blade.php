<label style="font-size: 24pt; margin-right: 12px;" >{{$cus->CompanyName}}</label>
<br>
<label style="font-size: 18pt; margin-right: 12px;">{{$cus->CompanyNameSuffix}}</label>
<br>
<br>


    <label style="font-size: 10pt;">{{$RepTable[0]->bank_name}}</label>
    <label style="font-size: 14pt;margin-right: 12px;" >المصرف : </label>
<br>

<table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <caption style="font-size: 14pt; margin: 8px;">كشف بالعقود المسددة بتاريخ </caption>

    <thead class="font-size-12">
    <tr>
        <th style="width: 60pt;">المطلوب</th>
        <th style="width: 60pt;">المسدد</th>
        <th style="width: 60pt;">القسط</th>
        <th style="width: 60pt;">عدد الاقساط</th>
        <th style="width: 60pt;">اجمالي التقسيط</th>
        <th style="width: 60pt;">دفعة</th>
        <th style="width: 60pt;">اجمالي الفاتورة</th>
        <th style="width: 60pt;" > تاريخ العقد </th>
        <th style="width: 200pt;" > الاسم </th>
        <th style="width: 100pt;" > رقم الحساب </th>
        <th style="width: 60pt;" > رقم العقد </th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
          @foreach($RepTable as $key=>$item)
            <tr class="font-size-12">
                <td> {{ $item->raseed }} </td>
                <td> {{ $item->sul_pay }} </td>
                <td> {{ $item->kst }} </td>
                <td> {{ $item->kst_count }} </td>
                <td> {{ $item->sul }} </td>
                <td> {{ $item->dofa }} </td>
                <td> {{ $item->sul_tot }} </td>
                <td style="text-align: center"> {{ $item->sul_date }} </td>
                <td> {{ $item->name }} </td>
                <td style="text-align: right"> {{ $item->acc }} </td>
                <td > {{ $item->no }} </td>
            </tr>
        @endforeach

    </tbody>
</table>
