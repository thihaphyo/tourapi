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


    </script>

    <div class="container content-body">
        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Status Edit</h4>
            </div>
        </div>
        <form method="POST"  id="search-form" action="{{'UpdateStatus'}}">
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
                            <button type="submit" class="btn btn-primary form-control">Update</button>
                        </div>
                    </div>

                </div>

            </div>

        </form>
    </div>
@endsection