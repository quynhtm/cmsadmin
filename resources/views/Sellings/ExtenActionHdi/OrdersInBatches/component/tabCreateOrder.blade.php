<?php
$formName = 'creat_order';
?>
<div class="ibox">
    {{----Block 1----}}
    @include('Sellings.ExtenActionHdi.OrdersInBatches.component._blockCrearOrder1')

    {{----Block 2----}}
    @include('Sellings.ExtenActionHdi.OrdersInBatches.component._blockCrearOrder2')

    {{----table kết quả----}}
    <div class="form-group display-none-block" id="block_table_result_create_order">
        <table class="table table-bordered table-hover">
            <thead class="thin-border-bottom">
            <tr class="table-background-header">
                <th width="5%" class="text-center middle">{{viewLanguage('STT')}}</th>
                <th width="35%" class="text-center middle">{{viewLanguage('Gói')}}</th>

                <th width="20%" class="text-center middle">{{viewLanguage('Số đơn đã cấp thành công')}}</th>
                <th width="20%" class="text-center middle">{{viewLanguage('Số email đã gửi')}}</th>
                <th width="20%" class="text-center middle">{{viewLanguage('Tổng doanh thu')}}</th>
            </tr>
            </thead>
            <tbody>
            @for($x = 1; $x < 6; $x++)
                <tr>
                    <td class="text-center middle">{{$x}}</td>
                    <td class="text-left middle">Gói {{$x}}</td>

                    <td class="text-center middle">{{numberFormat(rand(10,99))}}</td>
                    <td class="text-center middle">{{numberFormat(rand(10,99))}}</td>
                    <td class="text-center middle">{{numberFormat(rand(100000,999999))}}</td>
                </tr>
            @endfor
            </tbody>
        </table>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        var config = {
            '.chosen-select'           : {width: "100%"},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });

</script>




