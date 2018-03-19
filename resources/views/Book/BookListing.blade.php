@extends('master.master')

@section('title', 'Book Listing')

@section('content')
    <script>
        $('document').ready(function () {



            var oTable = $('#DataTable').DataTable({


                processing: true,
                serverSide: true,
                "order": [[ 0, "desc" ]],
                ajax: {
                    url: 'GetBookList',
                    data: function (d) {
                        d.daterange = "null";
                    }
                },
                columns: [
                    {data: 'book_id', name: 'book_id'},
                    {data: 'book_name', name: 'book_name'},
                    {data: 'pub_name', name: 'pub_name'},
                    {data: 'price' , name : 'price'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });



            $('#btn-add').on('click',function (e) {

                window.location="/BookEntry";
            });


            $('#btn-import').on('click',function (e) {

                window.location="/ExcelImport";
            });

        });

    </script>
    <div class="container content-body">
        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Book Listing</h4>
            </div>
        </div>
        <form method="POST"  id="search-form">
            {{csrf_field()}}




            <div class="row datatable-content">

                <div class="row">
                    <div class="col-md-12">

                        <div class="col-md-12 pull-right">
                            <button type="button" class="btn btn-primary pull-right" id="btn-add">Add New Book</button>
                            <button type="button" class="btn btn-primary pull-right" id="btn-import" style="margin-right: 10px;">Import Book</button>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="control-label">
                        Book List
                    </label>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="DataTable">
                        <thead>
                        <th>Book ID</th>
                        <th>Book Name</th>
                        <th>Publisher Name</th>
                        <th>Price</th>
                        <th>Edit</th>
                        </thead>
                    </table>
                </div>
            </div>

        </form>
    </div>
@endsection