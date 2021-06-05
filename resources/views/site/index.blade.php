<a href="{{route('sites.create')}}">Add Site</a>
<table>
    <tr>
        <th>Name</th>
        <th>Domain</th>
    </tr>

    @foreach($sites as $site)
        <tr>
            <td>{{$site->name}}</td>
            <td>{{$site->domain}}</td>
        </tr>
    @endforeach

</table>
