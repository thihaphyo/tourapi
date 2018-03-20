@extends('master.master')

@section('title', 'Status Entry')


@section('success')

    {{\Session::get('success')}}

@endsection

@section('error')

    {{\Session::get('error')}}

@endsection

@section('content')
    <script>

        $(document).ready(function(e){

            $('#btn-Save-Status').on('click',function (e) {

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
                    $('#status-form').submit();
                }


            });

        });

    </script>
    <div class="container content-body">
        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Status Entry</h4>
            </div>
        </div>
        <form method="POST"  id="status-form" action="{{'StatusSave'}}">
            {{csrf_field()}}


            <div class="row">
                <div class="col-md-12">

                </div>
            </div>

            <div class="row datatable-content">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="book_name">Status Name:</label>
                            <input type="text" class="form-control" id="status_name" name="status_name">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="submit" id="btn-Save-Status" class="btn btn-primary form-control">Save</button>
                        </div>
                    </div>

                </div>

            </div>

        </form>
    </div>
@endsection