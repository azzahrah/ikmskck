<html>
    <head>
        <meta charset="UTF-8">
        <title>GPS Tracking System</title>
        <link rel="stylesheet" type="text/css" href="js/jquery-easyui/themes/bootstrap/easyui.css">
        <link rel="stylesheet" type="text/css" href="js/jquery-easyui/themes/icon.css?v=1.0.22">
        <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0.22">
        <style>
            /* Basics */
            html, body {
                font-family: "Helvetica Neue", Helvetica, sans-serif;
                color: #000;
                text-decoration:none;
                -webkit-font-smoothing: antialiased;
            }
            .finish{
                background-color: #ff9900;
            }
            .cancel{
                background-color: #ff0000;
            }
            #container {
                position: fixed;
                width: 250px;
                height: 90px;
                top: 50%;
                left: 50%;
                margin-top: -150px;
                margin-left: -170px;
                background: #fff;
                border-radius: 3px;
                border: 1px solid #ccc;
                box-shadow: 0 1px 2px rgba(0, 0, 0, .1);

            }
            #container2 {
                margin: 0 auto;
                margin-top: 20px;
            }
            label {
                color: #555;
                display: inline-block;
                margin-left: 30px;
                margin-top:5px;
                padding-top: 14px;
                font-size: 14px;
                float:left;
            }
            img {
                color: #555;
                display: inline-block;
                margin-left: 25px;
                padding-top: 10px;
                font-size: 14px;
                float:left;
            }            
        </style>     

        <script type="text/javascript" src="js/jquery-easyui/jquery.min.js?v=1.0.0"></script>
        <script type="text/javascript" src="js/jquery-easyui/jquery.easyui.min.js?v=1.0.0"></script>
        <script type="text/javascript" src="js/chartjs/Chart.bundle.js"></script>
        <script type="text/javascript" src="js/app.js?v=1.0.0"></script>
    </head>

    <body id="main" class="easyui-layout">
        <div data-options="region:'north',height:70" style="background:#0052A3;color:#fff;">
            <center><h1>Index Kepuasan Pelayanan Masyarakat (SKCK)</h1></center>
        </div>
        <div data-options="region:'south',height:200,split:true" style="background:#0052A3;color:#fff;">
            <table id="grid" class="easyui-datagrid" data-options="fit:true,ctrlSelect:true,pagination:true,singleSelect:false,toolbar:'#toolbar',url:'php_script/table_polling.php'">
                        <thead>
                            <tr>
                                
                                <th data-options="field:'id',width:60,checkbox:true">No</th>
                                <th data-options="field:'tdate',width:150">Tanggal/Jam</th>
                                <th data-options="field:'polling',width:150,formatter:format_polling,styler:styler_polling">Pilihan</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="toolbar" style="padding:5px;">
                        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-reload'" onclick="reload();">Reload</a>
                        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onclick="delete_rows();">Delete</a>                        
                    </div>
        </div>
        <div data-options="region:'center'">
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>


    </body>
</html>
