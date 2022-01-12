<table class="table table-bordered table-hover">
    <thead class="thin-border-bottom">
    <tr class="table-background-header">
        {{--<th width="3%" class="text-center"><input type="checkbox" class="check" id="checkAll"></th>--}}
        <th width="30%" class="text-left th_sticky">{{viewLanguage('Chức năng')}}</th>
        <?php
        $with = 70/count($arrActionExecute);
        ?>
        @foreach ($arrActionExecute as $ka => $namea)
            <th width="{{$with}}%" class="text-center th_sticky">{{$namea}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody >
        @if(isset($arrChooseMenu) && !empty($arrChooseMenu))
            @foreach ($arrChooseMenu as $menu_id => $inforMenu)
                    <?php
                    if (isset($arrMenuSystem[$menu_id])){
                        unset($arrMenuSystem[$menu_id]);
                    }
                    ?>
                    <tr style="background-color: #E0F3FF">
                        <td class="text-left middle">[{{$inforMenu['menu_id']}}] {{$inforMenu['menu_name']}}</td>
                        @foreach ($arrActionExecute as $keyAction => $namea)
                            <td class="text-center">
                                <input type="checkbox" name="{{$keyAction}}[][{{$menu_id}}]" id="{{$keyAction}}[{{$menu_id}}]" @if(isset($arrCheckMenu[$menu_id]) && in_array($keyAction,$arrCheckMenu[$menu_id])) checked @endif>
                            </td>
                        @endforeach
                    </tr>
            @endforeach
        @endif
        @if(isset($arrMenuSystem) && !empty($arrMenuSystem))
            @foreach ($arrMenuSystem as $menu_id2 => $inforMenu2)
                <tr>
                    <td class="text-left middle">[{{$inforMenu2['menu_id']}}] {{$inforMenu2['menu_name']}}</td>
                    @foreach ($arrActionExecute as $keyAction2 => $namea2)
                        <td class="text-center">
                            <input type="checkbox" name="{{$keyAction2}}[][{{$menu_id2}}]" id="{{$keyAction2}}[{{$menu_id2}}]">
                        </td>
                    @endforeach
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
