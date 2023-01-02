

<!doctype html>

<html lang="ar" dir="rtl">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet" />

  <style>

      #content {
          display: table;
      }


      body {
          counter-increment: pageplus1 page;
          counter-reset: pageplus1 1;
          direction: rtl;
          font-family: Amiri ;
      }
      #footer {
          height: 30px;
          position: fixed;

          margin: 5px;
          bottom: 0;
          text-align: center;
      }
      #footer .page:after {
          content:   counter(page);
      }
      #footer .pageplus1:after {
          content:  counter(pageplus1);
      }

      @page {
          size: 21cm 29.7cm;
          margin: 4px;
      }
      table {
          width: 96%;
          border-collapse: collapse;
          border: 1pt solid  lightgray;

          margin-right: 12px;
          font-size: 12px;
      }

      tr {
          border: 1pt solid  lightgray;
      }
      th {
          border: 1pt solid  lightgray;
      }
      td {
          border: 1pt solid  lightgray;
      }
  </style>
</head>
<body  >
<div  >


        <label style="font-family: Amiri; font-size: 24pt; margin-right: 12px;" >{{$cus->CompanyName}}</label>
    <br>
        <label style="font-family: Amiri; font-size: 18pt;margin-right: 12px;">{{$cus->CompanyNameSuffix}}</label>

    <br>
    <br>
    <br>
    <label style="margin-right: 12px;"> فاتورة رقم :  {{$res->order_no}}</label>
    <div >
        <label style="font-size: 12px;">{{$res->order_date}}</label>
        <label style="margin-right: 12px;" >بتاريخ : </label>
    </div>
    <div >
        <label >{{$jeha_name}}</label>
        <label style="margin-right: 12px;" >اسم المورد : </label>
    </div>
    <div >
        <label >{{$place_name}}</label>
        <label style="margin-right: 12px;">صدرت من : </label>
    </div>
    <br>
  <table  width="100%"   align="right" >

    <thead style=" font-family: DejaVu Sans, sans-serif; margin-top: 8px;" >
    <tr  style="background: #9dc1d3;" >
        <th width="18%">المجموع</th>
        <th width="15%">السعر </th>
        <th width="10%">الكمية</th>
        <th>اسم الصنف </th>
        <th  width="15%">رقم الصنف</th>
    </tr>
    </thead>
    <tbody style="margin-bottom: 40px; ">
    @foreach($orderdetail as $key => $item)
      <tr >
          <td style=" text-align: right;"> {{ $item['sub_tot'] }}</td>
          <td style=" text-align: right;"> {{ $item['price'] }} </td>
          <td style="text-align: center;"> {{ $item['quant'] }} </td>
          <td style=" text-align: right;"> {{ $item['item_name'] }} </td>
          <td style="color: #0c63e4; text-align: center;"> {{ $item['item_no'] }} </td>
      </tr>
      <div id="footer" style="height: 50px; width: 100%; margin-bottom: 0px; margin-top: 10px;
                              display: flex;  justify-content: center;">
          <label class="page"></label>
          <label> صفحة رقم </label>
      </div>
    @endforeach
    </tbody>
      <tbody>
      <tr  >
          <td style="font-weight: bold;text-align: right;">{{$res->tot1}}</td>
          <td style="padding: 4px;" > إجمالي الفاتورة </td>
          <td ></td>
          <td ></td>
          <td ></td>
      </tr>
      <tr >
          <td style="font-weight: bold;text-align: right;">{{$res->ksm}}</td>
          <td style="padding: 4px;" >الخصم </td>
          <td style="font-weight: bold;text-align: right;">{{$res->cash}}</td>
          <td style="padding: 4px;">المدفوع </td>
          <td ></td>

      </tr>
      <tr >
          <td style="font-weight: bold;text-align: right;">{{$res->tot}}</td>
          <td style="padding: 4px;">الصافي </td>
          <td style="font-weight: bold;text-align: right;">{{$res->not_cash}}</td>
          <td style="padding: 4px;">المتبقي </td>
          <td ></td>

      </tr>

      </tbody>
  </table>

    <br>


</div>
</div>


</body>
</html>
