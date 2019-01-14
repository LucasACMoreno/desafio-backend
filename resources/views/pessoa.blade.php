<html>
    <title>TICKET</title>
    <head>
        <meta charset="UTF-8">

        <script
          src="https://code.jquery.com/jquery-3.3.1.min.js"
          integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
          crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  

    </head>
    <body>
            <h2 class="margin-top-0 text-primary">Tickets Info</h2>
            <br>
                <table id="datatable" class="mdl-data-table">
                    <thead>
                        <tr>
                            <th>Index</th>
                            <th>TicketID</th>
                            <th>CategoryID</th>
                            <th>CustomerID</th>
                            <th>CustomerName</th>
                            <th>CustomerEmail</th>
                            <th>DateCreate</th>
                            <th>DateUpdate</th>
                            <th>TicketPriority</th>
                        </tr>
                    </thead>
                    <tbody>            
                        @foreach ($tickets as $key => $value)
                            <tr class="tickets" id={{$key}}">
                                <td>{{$key}}</td>
                                <td>{{$value["TicketID"]}}</td>
                                <td>{{$value["CategoryID"]}}</td>
                                <td>{{$value["CustomerID"]}}</td>
                                <td>{{$value["CustomerName"]}}</td>
                                <td>{{$value["CustomerEmail"]}}</td>
                                <td>{{$value["DateCreate"]}}</td>
                                <td>{{$value["DateUpdate"]}}</td>  
                                <td>{{$value["ticketPriority"][0]}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>                    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script type="text/javascript">

    $(document).ready( function () {
    $('#datatable').DataTable( {
        "info" : false,
        "search" : true,
        "paging": true,
        language: {
            searchPlaceholder: "Search..."
        },          
        columnDefs: [
            {
                className: 'mdl-data-table__cell--non-numeric'
            }
        ]
    } );
    } );    
</script>
    </body>
</html>

