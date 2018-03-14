@extends('master.master')

@section('title', 'Daily Question Count')

@section('content')
    <script>
       $('document').ready(function () {
           //Date range picker
           $('#dateRange').daterangepicker(
               {
                   locale: {
                       format: 'MM/DD/YYYY'
                   }
               },
               function(start, end, label) {

               });

           var oTable = $('#DataTable').DataTable({
                          processing: true,
                          serverSide: true,
                          "order": [[ 0, "desc" ]],
                          ajax: {
                            url: 'GetDailyQuestionCount',
                            data: function (d) {
                            d.daterange = $('#dateRange').val();
                          }
                    },
                    columns: [
                      {data: 'question_date', name: 'question_date'},
                      {data: 'total', name: 'total'},
                      {data: 'status_zero', name: 'status_zero'},
                      {data: 'status_one', name: 'status_one'},
                      {data: 'status_two', name: 'status_two'},
                      {data: 'status_three', name: 'status_three'},
                      {data: 'status_four', name: 'status_four'},
                      {data: 'status_five', name: 'status_five'},
                      {data: 'status_six', name: 'status_six'},
                      {data: 'status_seven', name: 'status_seven'},
                      {data: 'status_eight', name: 'status_eight'},
                      {data: 'status_nine', name: 'status_nine'},
                      {data: 'status_ten', name: 'status_ten'},
                      {data: 'status_eleven', name: 'status_eleven'},
                      {data: 'status_twelve', name: 'status_twelve'},
                      {data: 'status_thirteen', name: 'status_thirteen'},
                      {data: 'status_fourteen', name: 'status_fourteen'},
                      {data: 'status_fiftheen', name: 'status_fiftheen'},
                      {data: 'status_sixtheen', name: 'status_sixtheen'},
                      {data: 'status_seventheen', name: 'status_seventheen'},
                     ]
           });

           $('#search-form').on('submit', function(e) {
                    oTable.draw();
                    e.preventDefault();
           });

       })
    </script>
   <div class="container content-body">
       <!--For Heading-->
       <div class="row">
           <div class="col-md-12">
               <h4 class="h4 heading-blue">Daily Question Count</h4>
           </div>
       </div>
       <form method="POST"  id="search-form">
       {{csrf_field()}}


       <div class="row">
           <div class="col-md-12">
               <div class="form-group col-md-4">
                   <label>Date range:</label>
                   <div class="input-group">
                       <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                       </div>
                       <input name="dateRange" class="form-control pull-right" id="dateRange" value="{{is_null($DateRange)?date('m/d/Y').' - '.date('m/d/Y'):$DateRange}}" type="text">
                       <span class="input-group-btn">
                            <button class="btn btn-info btn-flat" type="submit" id="go">Search</button>
                        </span>
                   </div>
                   <!-- /.input group-->

               </div>
           </div>
       </div>

       <div class="row datatable-content">
           <div>
               <label class="control-label">
                   Daily Question Counts
               </label>
           </div>
           <div class="table-responsive">
               <table class="table table-bordered table-striped" id="DataTable">
                   <thead>
                       <th>Date</th>
                       <th>Total</th>
                       <th>status_zero</th>
                       <th>Ph Contact Finish</th>
                       <th>Payment Finish</th>
                       <th>Question Send To Astrologer</th>
                       <th>Answer Reply From Astrologer</th>
                       <th>Audio and Text Edit Finish</th>
                       <th>CMS Finished</th>
                       <th>Confirmed</th>
                       <th>No Pickup</th>
                       <th>Can Contact</th>
                       <th>Busy</th>
                       <th>Wrong Number</th>
                       <th>Out of Service Area</th>
                       <th>Power Off</th>
                       <th>Oversea Number</th>
                       <th>Unsuccessful</th>
                       <th>Wrong Topup Code</th>
                       <th>Check and reply</th>
                   </thead>
               </table>
           </div>
       </div>

       </form>
   </div>
@endsection