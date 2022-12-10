@php
    $id = Auth::user()->id;
    $admindata = App\Models\User::find($id);
@endphp

        <div id="sidebar"  >

            <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                <svg class="bi pe-none me-2" width="30" height="24"><use xlink:href="#bootstrap"/></svg>

            </a>
            <ul class="list-unstyled ps-0">
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded   border-0 collapsed"
                            data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                        &nbsp <i class="fa  fa-cart-arrow-down" aria-hidden="true"></i>&nbsp;  مشتريات</button>
                    <div class="collapse " id="home-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('order_buy.add')}}" class="link-dark d-inline-flex text-decoration-none rounded">فاتورة مشتريات</a></li>
                            <li><a href="{{route('order_buy.edit')}}" class="link-dark d-inline-flex text-decoration-none rounded">تعديل فاتورة مشتريات</a></li>

                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded    border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                        &nbsp  <i class="fa fas fa-cart-plus" aria-hidden="true"></i>&nbsp;  مبيعات
                    </button>
                    <div class="collapse" id="dashboard-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('order_sell.add')}}" class="link-dark d-inline-flex text-decoration-none rounded">مبيعات بالتقسيط</a></li>
                            <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Weekly</a></li>
                            <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Monthly</a></li>
                            <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Annually</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded    border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#trans-collapse" aria-expanded="false">
                        &nbsp  <i class="fa fas fa-cart-plus" aria-hidden="true"></i>&nbsp;  إيصالات قبض ودفع
                    </button>
                    <div class="collapse" id="trans-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('trans.input')}}" class="link-dark d-inline-flex text-decoration-none rounded">إيصال قبض أو دفع</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                        &nbsp   <i class="fa  fas fa-restroom" aria-hidden="true"></i>&nbsp;  عملاء</button>
                    </button>
                    <div class="collapse" id="orders-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('customer.all')}}" class="link-dark d-inline-flex text-decoration-none rounded">عرض الزبائن</a></li>
                            <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Processed</a></li>
                            <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Shipped</a></li>
                            <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Returned</a></li>
                        </ul>
                    </div>
                </li>
                <li class="border-top my-3"></li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#okod-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-restroom" aria-hidden="true"></i>&nbsp عقود</button>
                    <div class="collapse" id="okod-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('main.input')}}" class="link-dark d-inline-flex text-decoration-none rounded">ادخال عقد جديد</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-restroom" aria-hidden="true"></i>&nbsp اقساط</button>
                    <div class="collapse" id="account-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('kst.input')}}" class="link-dark d-inline-flex text-decoration-none rounded">قسط مصرفي</a></li>
                            <li><a href="{{route('haf.input')}}" class="link-dark d-inline-flex text-decoration-none rounded">حافظة </a></li>

                        </ul>
                    </div>
                </li>
                <li class="border-top my-3"></li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repokod-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير عقود</button>
                    <div class="collapse" id="repokod-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                            <li><a href="{{route('repmain.all')}}" class="link-dark d-inline-flex text-decoration-none rounded">تقرير عن عقد</a></li>
                            <li><a href="{{route('repmain.arc')}}" class="link-dark d-inline-flex text-decoration-none rounded">تقرير عن عقد من الأرشيف</a></li>
                            <li><a href="{{route('rep.okod','mosdada')}}" class="link-dark d-inline-flex text-decoration-none rounded">العقود المسددة</a></li>
                            <li><a href="{{route('rep.okod','kamla')}}" class="link-dark d-inline-flex text-decoration-none rounded">العقود الخاملة</a></li>
                        </ul>
                    </div>
                </li>

                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repbank-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-school" aria-hidden="true"></i>&nbsp تقارير مصارف</button>
                    <div class="collapse" id="repbank-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                           <li><a href="{{route('rep.okod','banksum')}}" class="link-dark d-inline-flex text-decoration-none rounded">اجمالي المصارف</a></li>
                           <li><a href="{{route('rep.okod','bankone')}}" class="link-dark d-inline-flex text-decoration-none rounded">كشف تقصيلي بالمصرف</a></li>
                        </ul>
                    </div>
                </li>


                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repmak-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير مخزون</button>
                    <div class="collapse" id="repmak-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('repamma','mak')}}" class="link-dark d-inline-flex text-decoration-none rounded">تقرير عن المخزون</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repamma-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير عامة</button>
                    <div class="collapse" id="repamma-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('repamma','daily')}}" class="link-dark d-inline-flex text-decoration-none rounded">الحركة اليومية</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>






    <!-- Page Content  -->





