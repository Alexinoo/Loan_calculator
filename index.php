<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="./fontawesome-free-5.12.1-web/css/all.min.css"/>

    <!-- JQuery UI css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">

    <!-- JQuery Datatable CSS -->
    <!-- <link rel="stylesheet" href="././css/jqwidgets/jqx.base.css"> -->

    <!-- JQuery Datatable CSS -->
    <link rel="stylesheet" href="https:////cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">



    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/custom.css">    

    <title>Loan Calculator</title>    
  </head>
  <body> 
    <div class="container">
        <h1 class="text-center">Loan Calculator</h1>
        <hr>
        <div class="box">
            <h3 class="text-center">Loan Details</h3>
            <hr>
            <form method="post" id="myForm">                
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-2">
                        <label for="amount">Loan Amount</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="amount" id="amount" class="form-control numeric">
                    </div>
                </div>
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-2">
                        <label for="frequency">Payment Frequency</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="frequency" id="frequency" class="form-control">
                    </div>
                </div>               
                <div class="row g-3 align-items-center mb-3"> 
                    <div class="col-2">
                         <label for="period">Loan Period (Years)</label>                            
                    </div>
                    <div class="col-8">
                         <input type="number" name="period" id="period" class="form-control" >
                    </div>
                </div>
                <div class="row g-3 align-items-center mb-3"> 
                    <div class="col-2">
                         <label for="start_date">Start date</label>
                    </div>           
                    <div class="col-8">
                         <input type="text" name="start_date" id="start_date" class="form-control date">
                    </div> 
                </div> 
                 <div class="row g-3 align-items-center mb-3">  
                    <div class="col-2">
                         <label for="interest_type">Interest Type</label>
                    </div>    
                    <div class="col-8">
                         <input type="text" name="interest_type" id="interest_type" class="form-control autocomplete" >
                    </div> 
                </div>                  
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary " >Calculate</button>
                </div>              
            </form>
        </div>

        <div class="box loan_summary" style="visibility: hidden;">
            <div class="row">
                    <div class="col-6 loan_summary_a"></div> 
                    <div class="col-6 loan_summary_b"></div> 
                </div>
            </div>  
            
        <div class="box" style="visibility: hidden;" id="output">
        <div class="row">
            <div class="col-lg-6">
                 <h4 class="text-center"> Bank-A Amortization schedule</h4>
            <hr>
            <table id="BankA" class="table">
            <thead>
                <tr>
                    <th>Emi</th>
                    <th>Interest</th>
                    <th>Principal</th>
                    <th>Balance</th>
                </tr>
              </thead>               
             </table>
            </div>
            <div class="col-lg-6">
                <h4 class="text-center"> Bank-B Amortization schedule</h4>
            <hr>
            <table id="BankB" class="table">
            <thead>
                <tr>
                    <th>Emi</th>
                    <th>Interest</th>
                    <th>Principal</th>
                    <th>Balance</th>
                </tr>
            </thead>               
            </table>
            </div>
        </div>
           
        </div> 
       
        </div>
        
    </div>

    <!-- Validation Alert -->
  <div class="alert_div">
	<p id="alert_message"></p>
</div>
    
    <!-- Bootstrap min bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- JQuery UI CDN - js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <!-- JQuery Datatable - js -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- JQuery Datatable Export/Download/CSV/Buttons- js -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>






    <!-- Local JS Files -->
    <script src="./js/jquery.number.min.js"></script>
    <script src="./js/common_functions.js"></script>
    <script src="./js/autocomplete_extension.js"></script>

   <!-- Main JS File -->
    <script src="./js/main.js"></script>
  </body>
</html>