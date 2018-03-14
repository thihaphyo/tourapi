

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

        });
 
    </script>
    <div class="container content-body">
        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Daily Phone Top-Up Chart</h4>
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
                            <input name="dateRange" class="form-control pull-right" id="dateRange" value="" type="text">
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
                        Daily Phone Top-Up Chart
                    </label>
                </div>
                <div class="table-responsive">
                   
					<div id="temps_div">
		
					</div>
					{!!  \App\Library\CommonFunctions::GenerateChart($lava,'LineChart', 'Temps', 'temps_div') !!}
                </div>
            </div>

        </form>
    </div>
@endsection






