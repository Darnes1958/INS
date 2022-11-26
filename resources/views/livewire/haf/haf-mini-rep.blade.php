<div>
    <div class="form-check form-check-inline">
        <input wire:model="search"  type="search"  style="margin: 5px;" placeholder="ابحث هنا .......">
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="DisRadio"
               name="inlineRadioOptions" id="inlineRadio1" value="DisAll">
        <label class="form-check-label" for="inlineRadio1">عرض الكل</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="DisRadio"
               name="inlineRadioOptions" id="inlineRadio2" value="DisMe">
        <label class="form-check-label" for="inlineRadio2">عرض ادخالاتي فقط</label>
    </div>

    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>
            <th width="6%">ت</th>
            <th width="14%">رقم العقد</th>
            <th width="18%">رقم الحساب</th>
            <th width="28%">الاسم</th>
            <th width="10%">القسط</th>
            <th width="10%">الباقي</th>



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
                <td> {{ $item->baky }} </td>


            </tr>
        @endforeach
        </tbody>
    </table>


    {{ $HafithaTable->links('custom-pagination-links-view') }}

</div>

@push('scripts')



@endpush

