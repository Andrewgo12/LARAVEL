          <ul class="nav nav-tabs">
          	<li class="active"><a href="#tabla">Informacion detallada</a></li>
          	<li><a href="#formulario">Instrucciones</a></li>
          </ul> 
          <div class="tab-content">
          	<div id="formulario" class="tab-pane fade">
          		<ol>
          			<li>
          				Seleccionar las celdas correspondientes a lo que se pretende modifiar
          			</li>
          			<li>
          				Indicar cual sera el nombre nuevo y la descripcion correspondiente si aplica
          			</li>
          			<li>Presionar enviar para hacer efectivos los cambios</li>
          		</ol>

          	</div>
          	<div id="tabla" class="tab-pane fade in active">
          		<table border="1" class="tbl-depurar-nombres">
          			<thead>
          				<tr>
          					<td>Nombre</td>
          					<td>Cantidad</td>
          					<td></td>
          				</tr>
          			</thead>
          			<tbody>
          				<?php foreach ($listado as $registro): ?>
          					<tr>
          						<td onclick="relaiconar_nombre_destino('<?php echo $registro->name;?>')"><?php echo $registro->name; ?></td>
          						<td><?php echo $registro->cantidad; ?></td>
          						<td><input type="checkbox" name="seleccion[]" value="<?php echo $registro->name;?>"></td>
          					</tr>
          				<?php endforeach ?>
          			</tbody>
          		</table>

          		<div class="row">
          			<div class="col-sm-6">
          				<label for="nombre_equipo_destino">Nombre Nuevo</label>
          				<input required="" type="" name="nombre_equipo_destino" class="form-control nombre_equipo_destino" id="nombre_equipo_destino">
          			</div>
          			<div class="col-sm-6">
          				<label for="descripcion_equipo">Descripcion adicional</label>	
          				<input type="" name="descripcion_equipo" class="form-control descripcion_equipo" id="descripcion_equipo">

          			</div>
          		</div>
          		<p></p>
          		<input type="submit">
          		

          	</div>
          </div>
