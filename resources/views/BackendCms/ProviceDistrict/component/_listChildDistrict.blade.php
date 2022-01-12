<div id="blockListDistrict{{$object_id}}" data-children=".itemDistrict">
    <div class="itemDistrict row">
        @foreach ($dataDistrict as $key => $item)
        <li role="treeitem" aria-selected="false" class="fancytree-lastsib col-lg-6">
            [{{$item->id}}]
            <button type="button" aria-expanded="false" aria-controls="" data-toggle="collapse" href="#childListDistrict{{$item->id}}" class="m-0 p-0 btn btn-link" onclick="clickGetChild('{{$item->id}}',2,'getWardsByDistrictId','{{$urlPostData}}')">
                <b>{{$item->title}}</b>
            </button>
            <div data-parent="#blockListDistrict{{$object_id}}" id="childListDistrict{{$item->id}}" class="collapse">
                <ul role="group" style="" id="groupListWards{{$item->id}}">
                    {{-----Call Ajax hiển thị danh sách con----}}
                </ul>
            </div>
        </li>
        @endforeach
    </div>
</div>
