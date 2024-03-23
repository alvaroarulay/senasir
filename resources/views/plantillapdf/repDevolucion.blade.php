

<html>
<head>
	<style>
	@page {
		margin: 0cm 0cm;
	}
	body{
		font-family: 'arial', sans-serif;
		margin-top: 3.5cm;
		margin-left: 2cm;
		margin-right: 2cm;
		margin-bottom: 2cm;
		width: 24.5cm;
	}
	hr{
		margin: 0;
		border-top: 1px solid rgb(0, 0, 0);
	}
	#customers {
		border-collapse: collapse;
		font-size: 6pt;
	}
	#customers td, #customers th {
		padding: 5px;
	}
	#customers th {
		text-align: left;
		background-color: #ddd;
		color: black;
	}
	.eslogan{
		font-size: xx-small;
		font-style: italic;
	}
	#cabecera tr td{
		margin:0;
		padding:0;
	}
	header {
		position: fixed;
		top: 1cm;
		left: 1cm;
		right: 1cm;
		height: 3cm;
		}

		/** Definir las reglas del pie de página **/
	footer {
		position: fixed;
		bottom: 0cm;
		left: 1.5cm;
		right: 0cm;
		height: 2cm;
	}
	.page-break {
	    page-break-after: always;
	}
</style>
</head>
<body>
<!-- Defina bloques de encabezado y pie de página antes de su contenido -->
<header>
<div style="width: 26cm; height: 2.2cm;">
	<table>
		<tr>
			<td>
				<div style="width: 5cm; height: 2.5cm; text-align: center;">
					<img src="{{ asset('img/mindef.jpg') }}" alt="" style="width: auto; height: 2cm; ">
				</div>
			</td>
			<td>
				<div style="width: 14.5cm; height: 2cm;">
				<p style="margin-top: 0.5cm; text-align: center;" ><b>ACTA DE DEVOLUCIÓN DE BIENES</b></p>
				<p style="font-size: xx-small; margin: 0; text-align: center;">AL: {{$fechaTitulo}}</p>
			</div>
			</td>
			<td>
				<div style="width: 4cm; height: 1cm; ">
					<p style="font-size: xx-small; margin: 0.1cm; text-align: right;"><b>Página:</b></p>
					<p style="font-size: xx-small; margin: 0.1cm; text-align: right;"><b>Fecha de Impresión:</b></p>
					
				</div>
			</td>
			<td>
				<div style="width: 2cm; height: 1cm;">
					<p style="font-size: xx-small; margin: 0.1cm;"><br></p>
					<p style="font-size: xx-small; margin: 0.1cm;">{{$fechaDerecha}}</p>
					
				</div>
			</td>
		</tr>
	</table>
</div>
<hr>
</header>
<!-- Envuelva el contenido de su PDF dentro de una etiqueta principal -->
<main>
	<table id="cabecera">
		<tr style=" height: .5cm;">
			<td >
				<p style="font-size: xx-small; margin: 0.1cm; text-align: right;"><b>ENTIDAD:</b></p>
			</td>
			<td style=" height: .5cm; width:7cm;">
				<p style="font-size: xx-small; margin: 0.1cm;">Ministerio de Defensa</p>
			</td>
			<td>
			<p style="font-size: xx-small;  margin: 0.1cm;"><b>UNIDAD:</b> MD01</p>
			</td>
			<td>
			<p style="font-size: xx-small;  margin: 0.1cm;">MINISTERIO DE DEFENSA</p>
			</td>
		</tr>
		<tr style=" height: .5cm;">
			<td >
			<p style="font-size: xx-small; margin: 0.1cm; text-align: right;"><b>RESPONSABLE:</b></p>
			</td>
			<td >
			<p style="font-size: xx-small; margin: 0.1cm;">{{$responsable->nomresp}}</p>
			</td>
			<td><div style="width: 3cm;  height: .5cm; text-align: right; font-size: xx-small; margin: 0.1cm;">C.I.</div></td>
			<td><div style="width: 2cm;  height: .5cm; font-size: xx-small; margin: 0.1cm; ">{{$responsable->ci}}</div> </td>
			<td><div style="width: 6cm;  height: .5cm; font-size: xx-small; margin: 0.1cm; ">{{$responsable->sigla}}</div></td>
		</tr>
		<tr style=" height: .5cm;" >
			<td>
			<p style="font-size: xx-small; margin: 0.1cm; text-align: right;"><b>CARGO:</b></p>
			</td>
			<td>
			
			<p style="font-size: xx-small; margin: 0.1cm;">{{$responsable->cargo}}</p>
			</td>
		</tr>
		<tr style=" height: .5cm;">
			<td>
			<p style="font-size: xx-small; margin: 0.1cm; text-align: right;"><b>OFICINA:</b></p>
			</td>
			<td>
			<p style="font-size: xx-small; margin: 0.1cm;">{{$responsable->codofic.' - '.$responsable->nomofic}}</p>
			</td>
		</tr>
	</table>
	<table id="customers">
		<tr style="border: 1px solid ;">
		<th style="width: 3.3cm;">CÓDIGO</th>
		<th style="width: 5.5cm;">AUXILIAR</th>
		<th style="width: 13cm;">DESCRIPCIÓN DE ACTIVO</th>
		<th style="width: 2.7cm;">ESTADO</th>
		</tr>
		@foreach ($datos as $dato)
		<tr>
		<td>{{$dato->codigo}}</td>
		<td>{{$dato->codaux.' - '.$dato->nomaux}}</td>
		<td>{{$dato->descripcion}}</td>
		<td>{{$dato->nomestado}}</td>
		</tr>
		@endforeach
		
	</table>
	<hr>
	<p style="font-size: xx-small;"><b>Cantidad: </b>{{$total}}</p>
	<p class="eslogan">Para ser liberado de la responsabilidad, el servidor público deberá devolver a la Unidad o Responsable de Activos Fijos, el o los bienes que estaban a su cargo, debiendo recabar la conformidad
		escrita de esta Unidad o Responsable. Mientras no lo haga, estará sujeto al régimen de Responsabilidad por la Función Pública establecida en la Ley N° 1178 y sus reglamentos </p>
	<p class="eslogan">En señal de conformidad y aceptación se firma el presente acta.</p>


</main>
<footer>
<table>
	<tr>
		<td>
			<div style=" text-align: center; width: 8.66cm;">
				<p style="margin: 0.1cm; text-align: center;">__________________________</p>
				<p style="font-size: xx-small; margin: 0.1cm;">Autorizacion de Asignación</p>
			</div>
		</td>
		<td>
			<div style=" text-align: center; width: 8.66cm;">
				<p style="margin: 0.1cm; text-align: center;">_____________________________</p>
				<p style="font-size: xx-small; margin: 0.1cm;">Responsable de Activos Fijos</p>
			</div>
		</td>
		<td>
			<div style=" text-align: center; width: 8.66cm;">
				<p style="margin: 0.1cm; text-align: center;">_____________________</p>
				<p style="font-size: xx-small; margin: 0.1cm;">Funcionario</p>
			</div>
		</td>
	</tr>
</table>
</footer>
<script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "NORMAL");
                $pdf->text(705, 52, "$PAGE_NUM de $PAGE_COUNT", $font, 7);
            ');
        }
    	</script>
</body>
</html>