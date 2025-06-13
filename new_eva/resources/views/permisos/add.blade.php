@extends('layouts.app')

@section('content')
			


	<div class="content">
		<div class="box box-solid">
			<div class="box-body">
				<div class="container">
					<div class="table-responsive">
						<form action="{{ url('/'); }}administrador/Cpermisos/save" method="POST" class="form-group">
							<div class="row">
								<div class="form-group">

									@if($this->session->flashdata("error"))
										<div class="alert alert-danger alert-dimissible">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<p> <i class="icon fa fa-ban">
												{{ $this->session->flashdata("error") }}
											</i></p>
										</div>
									<?php endif ?>

									<label for="menu_id" class="col-sm-2">Menu</label>
									<select name="menu_id" id="menu" required="required" style="width: 70%" class="form-control col-sm-7">
										<option value="">--SELECCIONE--</option>
										@foreach($menus as $menu)
											<option value={{ $menu->id; }} >{{ $menu->nombre }}</option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="form-group">
									<label for="rol_id" class="col-sm-2">Rol</label>
									<select name="rol_id" id="rol" required="required" style="width: 70%" class="form-control col-sm-7">
										<option value="">--SELECCIONE--</option>
										@foreach($roles as $rol)
											<option value={{ $rol->id; }} >{{ $rol->nombre }}</option>
										<?php endforeach ?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label for="read">Leer:</label>
								<label class="radio-inline">
									<input type="radio" name="read" value="1" checked="checked">Si
								</label>
								<label class="radio-inline">
									<input type="radio" name="read" value="0" >No
								</label>
							</div>						
							<div class="form-group">
								<label for="insert">Agregar:</label>
								<label class="radio-inline">
									<input type="radio" name="insert" value="1" checked="checked">Si
								</label>
								<label class="radio-inline">
									<input type="radio" name="insert" value="0" >No
								</label>
							</div>						
							<div class="form-group">
								<label for="update">Actualizar:</label>
								<label class="radio-inline">
									<input type="radio" name="update" value="1" checked="checked">Si
								</label>
								<label class="radio-inline">
									<input type="radio" name="update" value="0" >No
								</label>
							</div>						
							<div class="form-group">
								<label for="delete">Eliminar:</label>
								<label class="radio-inline">
									<input type="radio" name="delete" value="1" checked="checked">Si
								</label>
								<label class="radio-inline">
									<input type="radio" name="delete" value="0" >No
								</label>
							</div>	
							<div class="form-group">
								<label for="asignar">Asignar:</label>
								<label class="radio-inline">
									<input type="radio" name="asignar" value="1" checked="checked">Si
								</label>
								<label class="radio-inline">
									<input type="radio" name="asignar" value="0" >No
								</label>
							</div>	
							<div class="form-group">
								<button type="submit" class="btn btn-success"><span class="fa fa-save"></span>Guardar</button>
							</div>					
							
						</form>				
					</div>
				</div>
			</div>
		</div>
	</div>			
</div>

@endsection