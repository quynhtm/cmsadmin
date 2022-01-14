{{----Edit và thêm mới----}}
<div class="formDetailItem" >
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$urlPostData}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataDetail)}}">

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_MOT}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        <input type="hidden" id="actionUpdate" name="actionUpdate" value="updateData">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-sm-12 col-lg-8 paddingRight-unset">
                <div class="card mb-3">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon pe-7s-cart icon-gradient bg-happy-itmeo"></i>
                            Danh sách sản phẩm
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="table-background-header">
                                <th width="3%" class="text-center">TT</th>
                                <th width="55%" class="text-left">Sản phẩm</th>
                                <th width="14%" class="text-right">Giá bán</th>
                                <th width="10%" class="text-center">SL</th>
                                <th width="18%" class="text-right">Tổng tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center text-middle">1</td>
                                <td class="text-left text-middle">tên sản phẩm</td>
                                <td class="text-right text-middle">10.000.000</td>
                                <td class="text-center text-middle"><input class="form-control input-sm text-right" type="text" name="numberProduct" value="1"></td>
                                <td class="text-right text-middle red">10.000</td>
                            </tr>

                            <tr>
                                <td class="text-right text-middle" colspan="4">Tổng số lượng hàng</td>
                                <td class="text-right text-middle paddingR10"><b>1</b></td>
                            </tr>
                            <tr>
                                <td class="text-right text-middle" colspan="4">Tiền hàng</td>
                                <td class="text-right text-middle paddingR10"><b>10.000</b></td>
                            </tr>
                            <tr>
                                <td class="text-right text-middle" colspan="4">Tiền giảm giá</td>
                                <td class="text-right text-middle"><input class="form-control input-sm text-right font-bold" type="text" name="numberProduct" value="5.000" style="padding-right: 2px!important;"></td>
                            </tr>
                            <tr>
                                <td class="text-right text-middle" colspan="4">Tiền ship</td>
                                <td class="text-right text-middle"><input class="form-control input-sm text-right font-bold" type="text" name="numberProduct" value="5.000" style="padding-right: 2px!important;"></td>
                            </tr>
                            <tr>
                                <td class="text-right text-middle" colspan="4"><b>Tổng tiền thanh toán</b></td>
                                <td class="text-right text-middle paddingR10"><b class="red">10.00.000</b></td>
                            </tr>
                            <tr>
                                <td class="text-right text-middle" colspan="5">
                                    <button class="btn btn-primary"><i class="pe-7s-diskette"></i> Cập nhật đơn hàng</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="card marginB15">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon pe-7s-id icon-gradient bg-happy-itmeo"></i>
                            Thông tin khách hàng
                        </div>
                    </div>
                    <div class="card-body paddingB10">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <input type="text" placeholder="Tên khách hàng" id="product_price_market" name="product_price_sell" class="text-left form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <input type="text" placeholder="Số điện thoại" id="product_price_market" name="product_price_sell" class="text-left form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <input type="text" placeholder="Email" id="product_price_market" name="product_price_sell" class="text-left form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <input type="text" placeholder="Địa chỉ" id="product_price_market" name="product_price_sell" class="text-left form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                {{--<label for="NAME" class="text-right control-label">{{viewLanguage('Ghi chú')}}</label>--}}
                                <textarea type="text" placeholder="Ghi chú" rows="2" id="product_price_market" name="product_price_sell" class="text-left form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon pe-7s-note2 icon-gradient bg-happy-itmeo"></i>
                            Thông tin đơn hàng
                        </div>
                    </div>
                    <div class="card-body paddingB10">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái đơn hàng')}}</label><span class="red"> (*)</span>
                                <select  class="form-control input-sm" name="category_id" id="category_id" required>
                                    {!! $optionStatusOrder !!}
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="NAME" class="text-right control-label">{{viewLanguage('Đơn hàng từ')}}</label>
                                <select  class="form-control input-sm" name="category_id" id="category_id" required>
                                    {!! $optionStatusOrder !!}
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="NAME" class="text-right control-label">{{viewLanguage('Tình trạng vận chuyển')}}</label><span class="red"> (*)</span>
                                <select  class="form-control input-sm" name="category_id" id="category_id" required>
                                    {!! $optionStatusOrder !!}
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <textarea type="text" placeholder="Ghi chú Admin" rows="2" id="product_price_market" name="product_price_sell" class="text-left form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        showDataIntoForm('{{$formName}}');
    });
</script>
