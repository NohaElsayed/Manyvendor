<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

</head>
<body>


<!-- Optional JavaScript; choose one of the two! -->
<form action="{{route('deliver.store')}}" method="post">
    @csrf
    <div></div>
    <input name="order_id" value="{{$id}}" type="hidden">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>@translate(Assign)</th>
            <th>@translate(Avatar)</th>
            <th>@translate(Name)</th>
            <th>@translate(Contact)</th>
            <th>@translate(Last Login)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $item)
            <tr class="{{$item->banned == true ? 'table-danger' : 'table-success'}}">
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="deliver_user_id"
                               id="exampleRadios-{{$item->id}}" value="{{$item->id}}">
                        <label class="form-check-label" for="exampleRadios-{{$item->id}}"></label>
                    </div>
                </td>
                <td>
                    <img src="{{filePath($item->avatar)}}" width="80" height="80" class="img-circle">
                </td>
                <td>@translate(Name) : {{$item->name}} <br>
                    <strong>{{$item->gendear}}</strong>
                </td>
                <td> @translate(Email) : <a href="Mail:{{$item->email}}"
                                            class="text-info">{{$item->email}}</a><br>
                    @translate(Phone) : <a href="Tel:{{$item->tel_number}}"
                                           class="text-info">{{$item->tel_number}}</a>
                <td>
                    @if($item->login_time != null)
                        <span class="badge badge-info">{{\Carbon\Carbon::parse($item->login_time)->diffForHumans() ?? ''}}</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>@translate(Assign)</th>
            <th>@translate(Avatar)</th>
            <th>@translate(Name)</th>
            <th>@translate(Contact)</th>
            <th>@translate(Last Login)</th>
        </tr>
        </tfoot>
    </table>
    <button class="btn btn-success" type="submit">@translate(Submit)</button>
</form>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script>


<script>
    $(document).ready(function () {
        var table = $('#example').DataTable({
            lengthChange: false,
        });

    });
</script>


</body>
</html>