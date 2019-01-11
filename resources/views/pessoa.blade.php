<div class="container">
        <div class="card">
            <table class="table" id="allTickets">
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
                        <!--<th>Interactions</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>DateCreate</th>
                            <th>Sender</th>                            -->
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
                                <!--<td>{{$value["Interactions"][0]["Subject"]}}</td>
                                <td>{{$value["Interactions"][0]["Message"]}}</td>
                                <td>{{$value["Interactions"][0]["DateCreate"]}}</td>
                                <td>{{$value["Interactions"][0]["Sender"]}}</td>                      -->                
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>