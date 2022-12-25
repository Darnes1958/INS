<div class="col-md-12" >

    <select   wire:model="EmpNo" id="Emp_L" class="Emp_L" >
        <option value="">اختيار من القائمة</option>
        @foreach($ItemList as  $s)
            <option value="{{ $s->EMP_NO }}">{{ $s->EMP_NAME }}</option>
        @endforeach
    </select>
</div>
