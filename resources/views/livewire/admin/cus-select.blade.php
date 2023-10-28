<div  >

    <select   wire:model="CusNo" id="CusNo_L" class="CusNo_L" >
        <option value="">اختيار من القائمة</option>
        @foreach($CusList as  $s)
            <option value="{{ $s->id }}">{{ $s->CompanyName }}</option>
        @endforeach
    </select>
</div>

