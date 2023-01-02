

<!doctype html>

<html lang="ar" dir="rtl">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link href="https://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet" />
  <style>
      #content {
          align-items: center;
          display: inline-flex;
      }
      #towlabel {

          display: inline;
      }
      .float-container {
          border: 3px solid #fff;
          padding: 20px;
      }

      .float-child {

          float: right;
          padding: 2px;

      }
      float-child2 {
          width: 60%;
          float: left;
          padding: 2px;

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
          content: counter(page);
      }
      #footer .pageplus1:after {
          content:  counter(pageplus1);
      }
      @page {
          size: 21cm 29.7cm ;
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
          text-align: center;
          border: 1pt solid  lightgray;
          font-size: 12px;
      }
      td {
          text-align: right;
          border: 1pt solid  lightgray;
      }
  </style>
</head>
<body  >
<div  >
  <label style="font-size: 24pt; margin-right: 12px;" >{{$cus->CompanyName}}</label>
  <br>
  <label style="font-size: 18pt; margin-right: 12px;">{{$cus->CompanyNameSuffix}}</label>
  <br>
  <br>

  @yield('mainrep')




</div>
</body>
</html>

