<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pdf</title>
    <style>
      	p {
				margin-bottom: 0px;
				margin-top: 0px;
			}
        div {
            border: 1px solid gray;
            padding: 5px;
            width: 5cm;
			height: 2.5cm
        }
		@page {
			margin: 0.5cm;
			font-size : 7pt;
		}
</style>
    </style>
</head>
<body>
    <div>
        <table>
				<tr>
					<td>
						<img src="{{ asset('img/sticker.png') }}" alt="" style="width: auto; height: 0.7cm; ">
					</td>
					<td width="2.5cm"  rowspan="5">
                        <img src="data:image/png;base64,{!! base64_encode($qr) !!}" alt="" style="width: auto; height: 2cm; ">						
                    </td>
				</tr>

				<tr>
					<td>
						<p ><strong>CÓDIGO: </strong></p>
					</td>
				</tr>
                <tr>
					<td>
						<p><strong>{{$actual->codigo}}</strong></p>
					</td>
				</tr>
				<tr>
					<td >
						<p ><strong> ACTIVOS FIJOS</strong></p>
					</td>
				</tr>

				<tr>
					<td  height="5px">
						<p ><strong>GESTIÓN:</strong>  2024</p>
					</td>
				</tr>
		</table>
</div>
</body>
</html>