$(document).ready(() => {
  let vArrData = [];
  let vArrData_bankB = [];
  // Format Numeric inputs
  $('.numeric').number(true, 2);

  // Format Date
  $('.date').datepicker({
    dateFormat: 'dd/mm/yy',
    maxDate: 0,
  });

  // AUTOCOMPLETE FOR PAYMENT FREQUENCY//////////////////////////////////////////////////////
  $('#frequency').autocomplete({
    source: ['Annually', 'Quarterly', 'Monthly', 'Every 6 Months'],
    minLength: 0,
    select: function (event, ui) {
      $('#frequency').val(ui.item.value);
    },
    change: function (e, ui) {
      if (!ui.item) {
        $(this).val('');
        $('#frequency').val('');
      }
    },
  });
  $('#frequency').on('focus', function () {
    $(this).autocomplete('search', '');
  });
  // AUTOCOMPLETE FOR INTEREST TYPE //////////////////////////////////////////////////////
  $('#interest_type').autocomplete({
    source: ['Flat Rate', 'Reducing Balance'],
    minLength: 0,
    select: function (event, ui) {
      $('#interest_type').val(ui.item.value);
    },
    change: function (e, ui) {
      if (!ui.item) {
        $(this).val('');
        $('#interest_type').val('');
      }
    },
  });
  $('#interest_type').on('focus', function () {
    $(this).autocomplete('search', '');
  });

  // ON  SUBMIT ////////////////////////////////////////////////////////////
  $('#myForm').on('submit', (e) => {
    e.preventDefault();

    const nAmount = $.trim($('#amount').val());
    const vFrequency = $.trim($('#frequency').val());
    const nPeriod = $.trim($('#period').val());
    const dStart_date = $.trim($('#start_date').val());
    const vInterest_type = $.trim($('#interest_type').val());

    // CHECK EMPTY FIELDS
    if (nAmount === '') {
      $('#amount').focus();
      openalert('Amount cannot be blank.');
      return false;
    }
    if (vFrequency === '') {
      $('#frequency').focus();
      openalert('Frequency cannot be blank.');
      return false;
    }

    if (nPeriod === '') {
      $('#period').focus();
      openalert('Loan period cannot be blank.');
      return false;
    }

    if (dStart_date === '') {
      $('#start_date').focus();
      openalert('Start Date cannot be blank.');
      return false;
    }

    // Validate Date
    if (!isValidDate(dStart_date)) {
      $('#start_date').focus();
      openalert('Invalid Date');
      return false;
    }

    if (vInterest_type === '') {
      $('#interest_type').focus();
      openalert('Interest type cannot be blank.');
      return false;
    }

    const data = {
      bank: ['Bank A', 'Bank B'],
      loan_amount: nAmount,
      payment_frequency: vFrequency,
      loan_period: nPeriod,
      payment_date: dStart_date,
      interest_type: vInterest_type,
    };

    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*',
      },
      body: JSON.stringify(data),
    };

    // Fetch API - Send Data to Laravel API and Receive Response
    fetch(
      'http://localhost:8000/api/loan_details/emi_calculation',
      requestOptions
    )
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        $('.loan_summary_a').html('');
        $('.loan_summary_b').html('');

        $.each(data, (index, value) => {
          let {
            bank,
            emi,
            loan_amount,
            frequency,
            interest,
            period,
            actual_interest,
            processing_fees,
            excise_duty,
            legal_fees,
            take_home_amount,
            interest_type,
          } = value;

          var rows = '';

          if (bank === 'Bank A') {
            let balance = loan_amount;

            rows += `<br><h5 class="text-center">${bank}</h5>
                            <h6>Loan Summary</h6>
                            <hr>
                            <p class ="bold">Amount Borrowed : <span class="amount_borrowed">${loan_amount}</span> </p>
                            <p class ="bold">Interest Rate (%) : <span class="interest_rate">${interest} %p.a</span> </p>
                            <p class ="bold">Number of ${frequency} Payments : <span class="no_of_emi">${period}</span> </p>
                            <p class ="bold">Payment Frequency : <span class="no_of_emi">${frequency}</span> </p>
                            <hr>
                            <p class ="bold">Monthly Payments : <span class="emi">${emi.toFixed(
                              2
                            )}</span> </p>
                            <p class ="bold">Total payment : <span class="total_payment"> ${(
                              emi * period
                            ).toFixed(2)}</span> </p>
                            <p class ="bold">Total Interest : <span class="total_interest_a"></span> </p>
                             <hr>
                            <h6>Additional Charges</h6>
                            <hr>
                            <p class="bold"> 3% Processing Fees : <span class="processing_fees">${processing_fees}</span></p>
                            <p class="bold"> 20% Excise Duty of Processing Fees : <span class="excise_duty">${excise_duty}</span></p>
                            <p class="bold"> Legal Fees : <span class="legal_fees">${legal_fees}</span></p>
                            <p class="bold"> Take Home Amount : <span class="take_home_amount">${take_home_amount}</span></p>
                            <hr>`;
            let total_interest = 0;
            if (interest_type == 'Reducing Balance') {
              for (let index = 1; index <= period; index++) {
                let interest_rate = actual_interest * balance;
                let principal = Number(emi) - interest_rate;
                balance -= principal;
                total_interest += interest_rate;

                vArrData.push({
                  Emi: emi.toFixed(2),
                  Interest: interest_rate.toFixed(2),
                  Principal: principal.toFixed(2),
                  Balance: balance < 0 ? 0 : balance.toFixed(2),
                });
              }
            } else {
              for (let index = 1; index <= period; index++) {
                let interest_rate = actual_interest * loan_amount;
                let principal = Number(emi) - interest_rate;
                balance -= principal;
                total_interest += interest_rate;

                vArrData.push({
                  Emi: emi.toFixed(2),
                  Interest: interest_rate.toFixed(2),
                  Principal: principal.toFixed(2),
                  Balance: balance < 0 ? 0 : balance.toFixed(2),
                });
              }
            }

            loadDataBankA(vArrData);
            $('.loan_summary_a').append(rows);
            $('.total_interest_a').text(total_interest.toFixed(2));
            $('.loan_summary').css('visibility', 'visible');
          } else {
            var rows = '';
            let balance = loan_amount;
            rows += `<br><h5 class="text-center">${bank}</h5>
                            <h6>Loan Summary</h6>
                            <hr>
                            <p class ="bold">Amount Borrowed : <span class="amount_borrowed">${loan_amount}</span> </p>
                            <p class ="bold">Interest Rate (%) : <span class="interest_rate">${interest}%p.a</span> </p>
                            <p class ="bold">Number of ${frequency} Payments : <span class="no_of_emi">${period}</span> </p>
                            <p class ="bold">Payment Frequency : <span class="no_of_emi">${frequency}</span> </p>
                            <hr>
                            <p class ="bold">Monthly Payments : <span class="emi">${emi.toFixed(
                              2
                            )}</span> </p>
                            <p class ="bold">Total payment : <span class="total_payment"> ${(
                              emi * period
                            ).toFixed(2)}</span> </p>
                            <p class ="bold">Total Interest : <span class="total_interest_b"></span> </p>
                            <hr>
                            <h6>Additional Charges</h6>
                            <hr>
                            <p class="bold"> 3% Processing Fees : <span class="processing_fees">${processing_fees}</span></p>
                            <p class="bold"> 20% Excise Duty of Processing Fees : <span class="excise_duty">${excise_duty}</span></p>
                            <p class="bold"> Legal Fees : <span class="legal_fees">${legal_fees}</span></p>
                            <p class="bold"> Take Home Amount : <span class="take_home_amount">${take_home_amount}</span></p>
                            <hr>`;
            let total_interest = 0;
            if (interest_type == 'Reducing Balance') {
              for (let index = 1; index <= period; index++) {
                let interest_rate = actual_interest * balance;
                let principal = Number(emi) - interest_rate;
                balance -= principal;
                total_interest += interest_rate;

                vArrData_bankB.push({
                  Emi: emi.toFixed(2),
                  Interest: interest_rate.toFixed(2),
                  Principal: principal.toFixed(2),
                  Balance: balance < 0 ? 0 : balance.toFixed(2),
                });
              }
            } else {
              for (let index = 1; index <= period; index++) {
                let interest_rate = actual_interest * loan_amount;
                let principal = Number(emi) - interest_rate;
                balance -= principal;
                total_interest += interest_rate;

                vArrData_bankB.push({
                  Emi: emi.toFixed(2),
                  Interest: interest_rate.toFixed(2),
                  Principal: principal.toFixed(2),
                  Balance: balance < 0 ? 0 : balance.toFixed(2),
                });
              }
            }
            loadDataBankB(vArrData_bankB);
            $('.loan_summary').css('visibility', 'visible');
            $('.loan_summary_b').append(rows);
            $('.total_interest_b').text(total_interest.toFixed(2));
          }
        }); //.each

        // Clear Fields
        $('#myForm')[0].reset();
        $('.calculate').hide();
      }) //.then
      .catch((error) => openalert(error));
  });
});

// Initialize Datatable
function loadDataBankA(arr) {
  $('#output').css('visibility', 'visible');
  $('#BankA').DataTable({
    processing: true,
    dom: 'Bfrtip',
    data: arr,
    columns: [
      { data: 'Emi' },
      { data: 'Interest' },
      { data: 'Principal' },
      { data: 'Balance' },
    ],
    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
    pageLength: 10,
  });
}

// Initialize Datatable
function loadDataBankB(arr) {
  $('#output').css('visibility', 'visible');
  $('#BankB').DataTable({
    processing: true,
    dom: 'Bfrtip',
    data: arr,
    columns: [
      { data: 'Emi' },
      { data: 'Interest' },
      { data: 'Principal' },
      { data: 'Balance' },
    ],
    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
  });
}

const Email_schedule = (obj) => {
  var table = $(obj).siblings('table').html();
  $.ajax({
    url: 'mypage.php',
    method: 'POST',
    data: { data: table },
    dataType: 'html',
    success: function (data) {
      openalert(data);
    },
    error: function (error) {
      openalert(error);
    },
  });
};
