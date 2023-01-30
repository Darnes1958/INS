
@auth
    @php
        $id = Auth::user()->id;
         $id = Auth::user()->id;
         $admindata = App\Models\User::find($id);
    @endphp
@endauth
    <div id="sidebar"  >
        <ul class="list-unstyled ps-0">
            @canany(['ادخال مشتريات','الغاء مشتريات','تعديل مشتريات'])
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded   border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    &nbsp <i class="fa  fa-cart-arrow-down" aria-hidden="true"></i>&nbsp;  مشتريات</button>
                <div class="collapse " id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        @can('ادخال مشتريات')
                        <li><a href="{{route('order_buy.add')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">فاتورة مشتريات</a></li>
                        @endcan
                        @canany(['الغاء مشتريات','تعديل مشتريات'])
                        <li><a href="{{route('order_buy.edit')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تعديل فاتورة مشتريات</a></li>
                        @endcanany
                    </ul>
                </div>
            </li>
            @endcanany
            @canany(['تعديل مبيعات','الغاء مبيعات','ادخال مبيعات'])
                <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded    border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    &nbsp  <i class="fa fas fa-cart-plus" aria-hidden="true"></i>&nbsp;  مبيعات
                </button>
                <div class="collapse" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        @can('ادخال مبيعات')
                          <li><a href="{{route('order_sell.add',2)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مبيعات بالتقسيط</a></li>
                          <li><a href="{{route('order_sell.add',1)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مبيعات نقدية</a></li>
                        @endcan
                        @canany(['تعديل مبيعات','الغاء مبيعات'])
                          <li><a href="{{route('order_sell.edit')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تعديل والغاء فاتورة</a></li>
                        @endcanany
                    </ul>
                </div>
            </li>
            @endcanany
            @canany(['ادخال ايصالات قبض','ادخال ايصالات دفع','ادخال مصروفات'])
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded    border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#trans-collapse" aria-expanded="false">
                    &nbsp  <i class="fa fas fa-hand-holding-usd" aria-hidden="true"></i>&nbsp;  إيصالات قبض ودفع
                </button>
                <div class="collapse" id="trans-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        @canany(['ادخال ايصالات قبض','ادخال ايصالات دفع'])
                        <li><a href="{{route('trans.input')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">إيصال قبض أو دفع</a></li>
                        @endcanany
                        @can('ادخال مصروفات')
                        <li><a href="{{route('inpmasr')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مصروفات</a></li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany
            @can('ادخال مخازن')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#stores-collapse" aria-expanded="false">
                    &nbsp   <i class="fa  fas fas fas fa-city" aria-hidden="true"></i>&nbsp;  مخازن</button>
                </button>
                <div class="collapse" id="stores-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{route('stores.add',11)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">من مخزن لمخزن</a></li>
                        <li><a href="{{route('stores.add',12)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">من مخزن لصالة</a></li>
                        <li><a href="{{route('stores.add',21)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">من صالة لمخزن</a></li>
                        <li><a href="{{route('stores.add',22)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">من صالة لصالة</a></li>
                        <li><a href="{{route('itemprices')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تغيير أسعار لصنف</a></li>

                    </ul>
                </div>
            </li>
            @endcan

            <li class="border-top my-3"></li>
            @can('ادخال عقود')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#okod-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-file-alt" aria-hidden="true"></i>&nbsp عقود</button>
                <div class="collapse" id="okod-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{route('main.input',1)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ادخال عقد جديد</a></li>
                        <li><a href="{{route('main.edit',1)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تعديل عقد</a></li>
                        <li><a href="{{route('main.edit',2)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">الغاء عقد</a></li>
                        <li><a href="{{route('main.input',2)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ضم عقد</a></li>
                        <li><a href="{{route('over.input','chk')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تسليم صكوك (من القائم)</a></li>
                        <li><a href="{{route('over.input','chk_a')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تسليم صكوك (من الأرشيف)</a></li>
                    </ul>
                </div>
            </li>
            @endcan
            @canany(['ادخال أقساط','ادخال حوافظ'])
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-coins" aria-hidden="true"></i>&nbsp اقساط</button>
                <div class="collapse" id="account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{route('kst.input')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">قسط مصرفي</a></li>
                        <li><a href="{{route('haf.input')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">حافظة </a></li>

                    </ul>
                </div>
            </li>
            @endcanany
            @can('ادخال فائض وترجيع')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#over-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-chart-line" aria-hidden="true"></i>&nbsp فائض وترجيع</button>
                <div class="collapse" id="over-collapse">

                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                        <li><a href="{{route('over.input','over')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">خصم بالفائض</a></li>
                        <li><a href="{{route('over.input','over_a')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">خصم بالفائض من الأرشيف</a></li>
                        <li><a href="{{route('over.input','wrong')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مبلغ وارد بالخطأ</a></li>
                        <li><a href="{{route('over.input','tar_list')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ترجيع مبالغ من الفائض او الخطأ</a></li>
                        <li><a href="{{route('over.input','tar_maksoom')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ترجع مبلغ مخصوم من عقد</a></li>
                        <li><a href="{{route('over.input','stop_kst')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ايقاف خصم</a></li>

                    </ul>
                </div>
            </li>
            @endcan
            @can('مصارف')
                <li class="mb-1">
                    <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#other-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-chart-line" aria-hidden="true"></i>&nbsp زبائن مصارف ...</button>
                    <div class="collapse" id="other-collapse">

                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                            <li><a href="{{route('banksinput','bank')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مصارف</a></li>
                            <li><a href="{{route('banksinput','taj')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مصارف تجميعية</a></li>
                            <li><a href="{{route('inpcust',1)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">زبائن</a></li>
                            <li><a href="{{route('inpcust',2)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">موردين</a></li>

                        </ul>
                    </div>
                </li>
            @endcan
            <li class="border-top my-3"></li>
            @can('عقود')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repokod-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير عقود</button>
                <div class="collapse" id="repokod-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{route('repmain.all')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن عقد</a></li>
                        <li><a href="{{route('repmain.arc')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن عقد من الأرشيف</a></li>
                        <li><a href="{{route('rep.okod','mosdada')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">العقود المسددة</a></li>
                        <li><a href="{{route('rep.okod','kamla')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">العقود الخاملة</a></li>
                        <li><a href="{{route('rep.okod','before')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تجهيز كشف المصرف</a></li>
                        <li><a href="{{route('rep.okod','wrong')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">اقساط واردة بالخظأ</a></li>
                        <li><a href="{{route('rep.okod','stop')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">إيقاف الخصم</a></li>
                        <li><a href="{{route('rep.okod','haf')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">حوافظ</a></li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('مصارف')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repbank-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-school" aria-hidden="true"></i>&nbsp تقارير مصارف</button>
                <div class="collapse" id="repbank-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                       <li><a href="{{route('rep.okod','banksum')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">اجمالي المصارف</a></li>
                       <li><a href="{{route('rep.okod','bankone')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">كشف تقصيلي بالمصرف</a></li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('المخزون')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repmak-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير مخزون</button>
                <div class="collapse" id="repmak-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{route('repamma','mak')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن المخزون</a></li>
                        <li><a href="{{route('repamma','RepStoresTrans')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">الحركة اليومية للمخزون</a></li>
                        <li><a href="{{route('repamma','RepPer')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن اذن صرف</a></li>
                    </ul>
                </div>
            </li>
            @endcan
            @canany(['اليومية','المصروفات','فاتورة مبيعات','فاتورة مشتريات','العملاء','الايصالات'])
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repamma-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير عامة</button>
                <div class="collapse" id="repamma-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        @can('اليومية')
                        <li><a href="{{route('repamma','daily')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">الحركة اليومية</a></li>

                       <li><a href="{{route('repamma','RepKlasa')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">خلاصة الحركة اليومية</a></li>
                       <li><a href="{{route('repamma','itemrep')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن صنف</a></li>
                       <li><a href="{{route('repamma','RepItemTran')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن حركة صنف</a></li>

                        @endcan
                        @can('فاتورة مبيعات')
                        <li><a href="{{route('order_sell.rep')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">فاتورة مبيعات</a></li>
                            @endcan
                        @role('مشتريات')
                       <li><a href="{{route('order_buy.rep')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">فاتورة مشتريات</a></li>
                            @endrole
                       @can('العملاء')
                       <li><a href="{{route('customer.all')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">عرض الزبائن</a></li>
                       <li><a href="{{route('repamma','jehatran')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">حركة زبون</a></li>
                            @endcan
                       @can('الايصالات')
                       <li><a href="{{route('repamma','RepTrans')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن ايصالات القبض والدفع</a></li>
                            @endcan
                       @can('المصروفات')
                       <li><a href="{{route('repamma','RepMas')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن المصروفات</a></li>
                            @endcan
                    </ul>
                </div>
            </li>
            @endcanany

                @role('admin')
                <li class="mb-1">
                    <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repmali-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير مالية</button>
                    <div class="collapse" id="repmali-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('repamma','RepMordeen')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن الموردين</a></li>
                            <li><a href="{{route('repamma','RepMali')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">التقرير المالي</a></li>

                        </ul>
                    </div>
                </li>
                @endrole
                @role('admin')
                <li class="mb-1">
                    <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#manager-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp صلاحيات</button>
                    <div class="collapse" id="manager-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('manager')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">منح الصلاحيات والمستخدمين</a></li>


                        </ul>
                    </div>
                </li>
                @endrole
        </ul>
    </div>
