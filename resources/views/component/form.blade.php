<form class="form-horizontal" id="frmCalendar">
    <fieldset>
        <legend>Generate calendar</legend>
        <div class="form-group">
            <label for="date" class="col-lg-2 control-label">Start date</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="date" name="date" placeholder="mm/dd/YYYY">
            </div>
        </div>
        <div class="form-group">
            <label for="days" class="col-lg-2 control-label">Number of days</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="days" name="days" placeholder="1">
            </div>
        </div>
        <div class="form-group">
            <label for="code" class="col-lg-2 control-label">Country code</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="code" name="code" placeholder="US">
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <a href="#" class="btn btn-primary" id="btnSubmit">Generate calendar</a>
            </div>
        </div>
    </fieldset>
</form>

@push('scripts')
    <script>
        $(function() {
            $('#btnSubmit').on('click',function(e){
                e.preventDefault();
                var data = $('#frmCalendar').serialize();
                $.ajax({
                    url: "{{route('calendar.validate')}}",
                    data: data,
                    method: "post",
                    success:function(data) {
                        if(data.status=='ok'){
                            showAlert('success','Generating calendar','processing values...');
                            showCalendar(data.values);
                        }else if(data.status == 'error'){
                            showAlert('danger','Verify the values' ,data.message);
                        }else{
                            showAlert('info','Unexpected','Unexpected data result');
                        }
                    },
                });
                return false;
            });
        });

        function showAlert(type,title,alert){
            $.ajax({
                url: "{{route('app.alert')}}",
                data: {type:type,title:title,message:alert},
                method: "post",
                success:function(data) {
                    $('#results').html(data.html);
                },
            });
        }

        function showCalendar(values){
            $.ajax({
                url: "{{route('calendar.generate')}}",
                data: values,
                method: "post",
                success:function(data) {
                    $('#results').html(data.html);
                    setTooltips();
                },
            });
        }

        function setTooltips(){
            new Tippy('.day-tooltip', {
                position: 'top',
                size:'big',
                theme:'light',
                popperOptions: {
                    modifiers: {
                        flip: {
                            behavior: ['right', 'bottom']
                        }
                    }
                }
            });
        }
    </script>
@endpush
