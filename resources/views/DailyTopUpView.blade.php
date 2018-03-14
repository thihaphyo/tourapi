@extends('master.master')

@section('title', 'Daily Phone Top-Up Count')

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
                    url: 'GetDailyTopUpCount',
                    data: function (d) {
                        d.daterange = $('#dateRange').val();
                    }
                },
                columns: [
                    {data: 'payment_date', name: 'payment_date'},
                    {data: 'total', name: 'total'},
                    {data: 'ooredoo_pay', name: 'ooredoo_pay'},
                    {data: 'mpt_pay', name: 'mpt_pay'},
                    {data: 'telenor_pay', name: 'telenor_pay'},
                    {data: 'unknown_pay', name: 'unknown_pay'},
                    {data: 'mec_pay' , name:'mec_pay'}
                ]
            });

            $('#search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });



        });

    </script>
    <div class="container content-body">
        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Daily Phone Top-Up Count</h4>
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
                        Daily Phone Top-Up Count
                    </label>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="DataTable">
                        <thead>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Ooreedoo Payment</th>
                        <th>MPT Payment</th>
                        <th>Telenor Payment</th>
                        <th>Unknown Payment</th>
                        <th>MEC Payment</th>
                        </thead>
                    </table>
                </div>
            </div>

        </form>
    </div>
@endsection