<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-5">
                <label for="user_email">Số chứng nhận</label>
                <input type="text" class="form-control input-sm" id="p_file_code" name="p_file_code" placeholder="" @if(isset($search['p_file_code']))value="{{$search['p_file_code']}}"@endif>
            </div>
            <div class=" col-lg-2">
                <label for="user_email">Từ ngày tạo</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_from_date" id="p_from_date" @if(isset($search['p_from_date']))value="{{$search['p_from_date']}}"@endif>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class=" col-lg-2">
                <label for="user_email">Đến ngày tạo</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_to_date" id="p_to_date" @if(isset($search['p_to_date']))value="{{$search['p_to_date']}}"@endif >
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-3 marginT20 text-right">
                <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                <button class="btn-transition btn btn-outline-success btn-search-right" type="button" name="search_ava" value="2"><i class="fa fa-search"></i> {{viewLanguage('Tạo ký số')}}</button>
            </div>
        </div>
    </div>
</div>

@if(isset($error) && in_array($error,[0,1]))
    @if($error == 1)
        <div class="alert alert-success fade show" role="alert">
            <p><b>Tạo ký số thành công</b></p>
        </div>
    @else
        <div class="alert alert-danger fade show" role="alert">
            <p><b>Có lỗi tạo ký số. Hãy nhập lại</b></p>
        </div>
    @endif
@endif

<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                        <tr class="table-background-header">
                            <th width="5%" class="text-center middle">STT</th>
                            <th width="15%" class="text-center middle">{{viewLanguage('Mã đơn')}}</th>
                            <th width="30%" class="text-left middle">{{viewLanguage('Xem file')}}</th>
                            <th width="30%" class="text-left middle">{{viewLanguage('Download file')}}</th>
                            <th width="20%" class="text-center middle">{{viewLanguage('Ngày tạo')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td class="text-center middle">
                                {{$stt+$key+1}}
                            </td>
                            <td class="text-center middle">@if(isset($item->FILE_CODE)){{$item->FILE_CODE}}@endif</td>

                            <td class="text-left middle">
                                <a href="{{$item->URL}}" target="_blank" title="Xem file">Xem file</a>
                            </td>
                            <td class="text-left middle">
                                <a href="{{$item->URL}}?download=true" target="_blank" title="Xem file">Download file</a>
                            </td>
                            <td class="text-center middle">@if(isset($item->CREATE_DATE)){{$item->CREATE_DATE}}@endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="paging_simple_numbers">
                {!! $paging !!}
            </div>
        @else
            <div class="alert">
                Không có dữ liệu
            </div>
        @endif
    </div>
</div>

<script type="text/javascript">
    var hdisdk=null;
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        $("#checkAllOrder").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
            changeColorButton();
        });

        //detail đơn
        /*$('.sys_show_order_insurance').dblclick(function () {
            var contract_code = $(this).attr('data-contract-code');
            var category = $(this).attr('data-category');
            clickApplicationInsurance(category,contract_code,'Cập nhật đơn bảo hiểm')
        });*/

    });
    function changeColorButton(){
        var changeColor = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                changeColor = 1;
            }
        });
        if(changeColor == 1){
            $('#show_button_approval_order').removeClass("display-none-block");
            $("#approval_order").addClass("btn-success");
            $("#approval_order").removeClass("btn-light");
        }else {
            $('#show_button_approval_order').addClass("display-none-block");
            $("#approval_order").removeClass("btn-success");
            $("#approval_order").addClass("btn-light");
        }
    }
    function clickApprovalOrderList(url_ajax){
        var dataId = [];
        var dataAmount = [];
        var i = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                dataAmount[i] = $(this).attr('data-amount');
                i++;
            }
        });
        if (dataId.length == 0 || dataAmount.length == 0) {
            alert('Bạn chưa chọn đơn để thao tác.');
            return false;
        }

        var msg = 'Bạn có muốn phê duyệt các đơn này?';
        jqueryCommon.isConfirm(msg).then((confirmed) => {
            $('#loader').show();
            $.ajax({
                type: "post",
                url: url_ajax,
                data: {dataId: dataId, dataAmount: dataAmount},
                dataType: 'json',
                success: function (res) {
                    $('#loader').hide();
                    if (res.success == 1) {
                        jqueryCommon.showMsg('success',res.message);
                        window.location.reload();
                    } else {
                        jqueryCommon.showMsgError(res.success,res.message);
                    }
                }
            });
        });
    }

</script>



