<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>jquery.Thailand.js</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/css/uikit.css">
    <link rel="stylesheet" href="./jquery.Thailand.js/dist/jquery.Thailand.min.css">
    
    <style>
        a, h1, h2, .h2{
            font-family: 'Kanit', sans-serif !important;
            line-height: 1.6em;
        }
        a{
            font-size: 1.4em;
        }
        label{
            font-size: 1.6em;
            display: block;
        }
    </style>
</head>
<body>

    <div class="uk-container uk-padding">
        <form id="demo1" class="demo" style="display:none;" autocomplete="off" uk-grid >

            <div class="uk-width-1-2@m">
                <label class="h2">ตำบล / แขวง</label>
                <input name="district" class="uk-input uk-width-1-1" type="text">
            </div>

            <div class="uk-width-1-2@m">
				<label class="h2">อำเภอ / เขต</label>
				<input name="amphoe" class="uk-input uk-width-1-1" type="text">
            </div>

            <div class="uk-width-1-2@m">
                <label class="h2">จังหวัด</label>
                <input name="province" class="uk-input uk-width-1-1" type="text">
            </div>

            <div class="uk-width-1-2@m">
                <label class="h2">รหัสไปรษณีย์</label>
                <input name="zipcode" class="uk-input uk-width-1-1" type="text">
            </div>

        </form>
        <!-- END DEMO 1 -->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/js/uikit.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- dependencies for zip mode -->
	<script type="text/javascript" src="{{asset('jquery.Thailand.js/dependencies/zip.js/zip.js')}}"></script>
    <!-- / dependencies for zip mode -->

	<script type="text/javascript" src="{{asset('jquery.Thailand.js/dependencies/JQL.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('jquery.Thailand.js/dependencies/typeahead.bundle.js')}}"></script>
    
	<script type="text/javascript" src="{{asset('jquery.Thailand.js/dist/jquery.Thailand.min.js')}}"></script>
    
    <script type="text/javascript">

        $.Thailand({
            database: './jquery.Thailand.js/database/db.json', 

            $district: $('#demo1 [name="district"]'),
            $amphoe: $('#demo1 [name="amphoe"]'),
            $province: $('#demo1 [name="province"]'),
            $zipcode: $('#demo1 [name="zipcode"]'),

            onDataFill: function(data){
                console.info('Data Filled', data);
            },

            onLoad: function(){
                console.info('Autocomplete is ready!');
                $('#loader, .demo').toggle();
            }
        });

        // watch on change

        $('#demo1 [name="district"]').change(function(){
            console.log('ตำบล', this.value);
        });
        $('#demo1 [name="amphoe"]').change(function(){
            console.log('อำเภอ', this.value);
        });
        $('#demo1 [name="province"]').change(function(){
            console.log('จังหวัด', this.value);
        });
        $('#demo1 [name="zipcode"]').change(function(){
            console.log('รหัสไปรษณีย์', this.value);
        });

    </script>
    
</body>
</html>