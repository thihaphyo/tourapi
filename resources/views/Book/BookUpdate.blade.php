@extends('master.master')

@section('title', 'Book Edit')


@section('success')

    {{\Session::get('success')}}

@endsection

@section('error')

    {{\Session::get('error')}}

@endsection

@section('content')
    <script>

        $(document).ready(function () {

            $('#btn-Update-Book').on('click',function (e) {

                $('input').removeClass('ui-state-error');

                e.preventDefault();

                let valueArray = [$('#book_id').val(),$('#book_name').val() ,$('#book_price').val()];

                let nameArray = ['#book_id','#book_name','#book_price'];

                let errors =CheckNull(valueArray,nameArray);

                if(errors != 'Pass')
                {
                    $(errors).addClass("ui-state-error");

                    $.alert({
                        title: 'Error',
                        content: 'Incomplete Information!',
                    });
                }else{
                    $('#book-update-form').submit();
                }


            });
        });

    </script>

    <div class="container content-body">
        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Book Edit</h4>
            </div>
        </div>
        <form method="POST"  id="book-update-form" action="{{'UpdateBook'}}">
            {{csrf_field()}}

            <input type="hidden" name="hddBookIDX" value="{{$book_data->idx}}">
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>

            <div class="row datatable-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="book_id">Book ID:</label>
                            <input type="text" class="form-control" id="book_id" name="book_id" value="{{$book_data->book_uniq_idx}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="book_name">Book Name:</label>
                            <input type="text" class="form-control" id="book_name" name="book_name" value="{{$book_data->book_name}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="author_id">Author Name:</label>
                            <select class="form-control select-box" id="author_id" name="author_id">
                                @foreach($publisher_data as $key => $value)
                                    <option value="{{$value->idx}}" {{$value->idx == $book_data ->publisher_id ? "selected" : ""}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="book_price">Book Price:</label>
                            <input type="text" class="form-control" id="book_price" name="book_price" value="{{$book_data->price}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="submit" id="btn-Update-Book" class="btn btn-primary form-control">Update</button>
                        </div>
                    </div>

                </div>

            </div>

        </form>
    </div>
@endsection