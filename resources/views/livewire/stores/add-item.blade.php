<div class="col-md-7 col-lg-8">

    <form >
        <div class="row g-3">
            <div class="col-sm-4">
                <label for="item_no" class="form-label">رقم الصنف</label>
                <input type="text" class="form-control" id="item_name" placeholder="" value="" >
            </div>

            <div class="col-sm-8">
                <label for="item_name" class="form-label">اسم الصنف</label>
                <input type="text" class="form-control" id="item_name" placeholder="ادخال اسم المستخدم" >
            </div>

            <div class="col-sm-4">
                <label for="item_type" class="form-label">نوع الصنف</label>
                <input type="text" class="form-control" id="item_type" placeholder="النوع" >
            </div>
            <div class="col-sm-8">
            </div>

            <div class="col-6">
                <label for="price_buy" class="form-label">سعر الشراء</label>
                <input type="text" class="form-control" id="price_buy" placeholder="" >
            </div>
            <div class="col-6">
                <label for="price_sell" class="form-label">سعر البيع</label>
                <input type="text" class="form-control" id="price_sell" placeholder="" >
            </div>

        </div>
        <br>
        <button wire:click.prevent="SaveItem" class="w-100 btn btn-primary btn-lg" type="submit">تخزين بيانات الصنف</button>
        <br>
    </form>
</div>
