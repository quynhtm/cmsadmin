<div class="modal-content" id="form_id_popup" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_id_popup">
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body">
            <div class="form_group">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                        <th width="50%" class="text-center middle">{{viewLanguage('File name')}}</th>
                        <th width="22%" class="text-center middle">{{viewLanguage('Xem file')}}</th>
                        <th width="22%" class="text-center middle">{{viewLanguage('Tải file')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td class="text-center middle">{{$key+1}}</td>
                            <td class="text-left middle">@if(isset($item->FILE_NAME)){{$item->FILE_NAME}}@endif</td>
                            <td class="text-center middle">
                                <a href="@if(isset($item->LINK_FILE)){{$item->LINK_FILE}}@else#@endif"target="_blank" title="chi tiết file">Xem file</a>
                            </td>
                            <td class="text-center middle">
                                <a href="@if(isset($item->LINK_FILE)){{$item->LINK_FILE.'?download=true'}}@else#@endif" title="tải file">Tải file</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        //var date_time = $('.input-date').datepicker({dateFormat: 'dd-mm-yy h:i'});
    });
</script>