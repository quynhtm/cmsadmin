<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thin-border-bottom">
        <tr class="table-background-header">
            <th width="2%" class="text-center middle">STT</th>
            <th width="8%" class="text-center middle">{{viewLanguage('Thao tác')}}</th>

            <th width="60%" class="text-center middle">{{viewLanguage('Loại tài liệu')}}</th>
            <th width="20%" class="text-center middle">{{viewLanguage('File')}}</th>
<!--            <th width="13%" class="text-center middle">{{viewLanguage('Nộp bản cứng')}}</th>-->
        </tr>
        </thead>
        <tbody>

        @if(isset($listFileAttach) && !empty($listFileAttach))
            @foreach($listFileAttach as $key3 => $item3)
            <tr>
                <td class="text-left middle" colspan="5"><h4>{{$item3['GROUP_NAME']}}</h4></td>
            </tr>
            @foreach($item3['ARR_LIST'] as $key_item2 => $item_chi2)
                <tr>
                    <td class="text-center middle">{{$key_item2+1}}</td>
                    <td class="text-center middle">
                        <i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
                        <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                    </td>
                    <td class="text-left middle">{{$item_chi2['GROUP_FILE_NAME']}}</td>
                    <td class="text-center middle">
                        <a href="{{$urlServiceFile.$item_chi2['FILE_ID']}}" title="xem file" target="_blank">Xem file</a>
                    </td>
                    <!--<td class="text-center middle"><input type="checkbox"></td>-->
                </tr>
            @endforeach
            @endforeach
        @endif
        </tbody>
    </table>
</div>