@extends('master.master')

@section('title', 'Status Edit')


@section('success')

    {{\Session::get('success')}}

@endsection

@section('error')

    {{\Session::get('error')}}

@endsection

@section('content')
    <script>

        $(document).ready(function (e) {

            $('#btn-Update-Status').on('click',function (e) {

                $('input').removeClass('ui-state-error');

                e.preventDefault();

                let valueArray = [$('#status_name').val()];

                let nameArray = ['#status_name'];

                let errors =CheckNull(valueArray,nameArray);

                if(errors != 'Pass')
                {
                    $(errors).addClass("ui-state-error");

                    $.alert({
                        title: 'Error',
                        content: 'Incomplete Information!',
                    });
                }else{
                    $('#status-update-form').submit();
                }


            });

        });

    </script>

    <div class="container content-body">
        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Status Edit</h4>
            </div>
        </div>
        <form method="POST"  id="status-update-form" action="{{'UpdateStatus'}}">
            {{csrf_field()}}

            <input type="hidden" name="hddStatusIDX" value="{{$Status_data->idx}}">
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>

            <div class="row datatable-content">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="book_name">Status Name:</label>
                            <input type="text" class="form-control" id="status_name" name="status_name" value="{{$Status_data->status_name}}">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="submit" id="btn-Update-Status" class="btn btn-primary form-control">Update</button>
                        </div>
                    </div>

                </div>

            </div>

        </form>
    </div>
@endsection