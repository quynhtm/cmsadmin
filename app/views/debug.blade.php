<div id="debug-log" style="border-top: 2px solid red; padding-top: 20px; padding-bottom: 100px;word-wrap: break-word;">
    <h3> Tổng thời gian gọi API: {{$total_time}}</h3>
    <ul>
        @foreach ($api_query as $query)
            <li> URL API: <a href="{{ $query['url']}}" target="_blank" style="color: #15c">{{ $query['url']}}</a> - METHOD: <span style="color:#4cae4c; font-weight: bold; ">[{{ $query['method']}}]</span> - TIME <span style="color: red; font-weight: bold">[{{ $query['time']}}]</span> </li>
        @endforeach
    </ul>
</div>

