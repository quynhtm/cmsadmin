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
            <div class="col-sm-12 col-lg-6">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-cloud-download icon-gradient bg-happy-itmeo"></i>
                            Thông tin khách hàng
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <input type="text" placeholder="Tên khách hàng" id="product_price_market" name="product_price_sell" class="text-left form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <input type="text" placeholder="Số điện thoại" id="product_price_market" name="product_price_sell" class="text-left form-control">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Email" id="product_price_market" name="product_price_sell" class="text-left form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <input type="text" placeholder="Địa chỉ" id="product_price_market" name="product_price_sell" class="text-left form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                {{--<label for="NAME" class="text-right control-label">{{viewLanguage('Ghi chú')}}</label>--}}
                                <textarea type="text" placeholder="Ghi chú" rows="2" id="product_price_market" name="product_price_sell" class="text-left form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="card-hover-shadow-2x mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-lighter icon-gradient bg-amy-crisp"></i>
                            Thông tin khách hàng
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái đơn hàng')}}</label><span class="red"> (*)</span>
                                <select  class="form-control input-sm" name="category_id" id="category_id" required>
                                    {!! $optionStatusOrder !!}
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label for="NAME" class="text-right control-label">{{viewLanguage('Đơn hàng từ')}}</label>
                                <select  class="form-control input-sm" name="category_id" id="category_id" required>
                                    {!! $optionStatusOrder !!}
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="NAME" class="text-right control-label">{{viewLanguage('Tình trạng vận chuyển')}}</label><span class="red"> (*)</span>
                                <select  class="form-control input-sm" name="category_id" id="category_id" required>
                                    {!! $optionStatusOrder !!}
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <textarea type="text" placeholder="Ghi chú Admin" rows="2" id="product_price_market" name="product_price_sell" class="text-left form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                    <i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"></i>
                    Thông tin sản phẩm đơn hàng
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        <th width="5%" class="text-center">STT</th>
                        <th width="10%" class="text-center">ID Sản phẩm</th>
                        <th width="50%" class="text-center">Sản phẩm</th>
                        <th width="15%" class="text-right">Giá bán</th>
                        <th width="10%" class="text-center">Số lượng</th>
                        <th width="20%" class="text-right">Tổng tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                    </tr>
                    <tr>
                        <td>Garrett Winters</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>63</td>
                        <td>2011/07/25</td>
                        <td>$170,750</td>
                    </tr>
                    <tr>
                        <td>Ashton Cox</td>
                        <td>Junior Technical Author</td>
                        <td>San Francisco</td>
                        <td>66</td>
                        <td>2009/01/12</td>
                        <td>$86,000</td>
                    </tr>
                    <tr>
                        <td>Cedric Kelly</td>
                        <td>Senior Javascript Developer</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>2012/03/29</td>
                        <td>$433,060</td>
                    </tr>
                </table>
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
