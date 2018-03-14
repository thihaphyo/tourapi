@extends('master.master')

@section('title', 'Book Entry')


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
                <h4 class="h4 heading-blue">Book Entry</h4>
            </div>
        </div>
        <form method="POST"  id="search-form" action="{{'BookSave'}}">
            {{csrf_field()}}


            <div class="row">
                <div class="col-md-12">

                </div>
            </div>

            <div class="row datatable-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="book_id">Book ID:</label>
                            <input type="text" class="form-control" id="book_id" name="book_id">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="book_name">Book Name:</label>
                            <input type="text" class="form-control" id="book_name" name="book_name">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="author_id">Author Name:</label>
                            <select class="form-control select-box" id="author_id" name="author_id">
                                @foreach($publisher_data as $key => $value)
                                    <option value="{{$value->idx}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="book_price">Book Price:</label>
                            <input type="text" class="form-control" id="book_price" name="book_price">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control">Save</button>
                        </div>
                    </div>

                </div>

            </div>

        </form>
    </div>
@endsection