@foreach ($dataWards as $key => $item)
    <li role="treeitem" aria-selected="false" class="fancytree-lastsib">[{{$item->id}}] - {{$item->title}}</li>
@endforeach
