<strong>RESUMEN DE REPUESTOS INSTALADOS</strong>
  <table id="tbl_resumen_por_repuesto" class="table table-bordered table-condensed tbl_resumen_por_repuesto datatable-repuesto-consolidado">
    <thead>
      <tr>
        <th>Año</th>
        <th>Mes</th>
        <th>Repuesto</th>
        <th>Costo</th>
      </tr>
    </thead>
    <tbody>
      @foreach($consolidado_anio_mes as $registro)
        <tr>
          <td>{{ $registro->anio }}</td>
          <td>{{ $registro->mes }}</td>
          <td>
            {{ $registro->repuesto }}
            <br>
            <strong>CANTIDAD INSTALADA:</strong>
            {{ $registro->cantidad }}

          </td>
          <td>
           <strong>COSTO UNITARIO: </strong>{{ $registro->costo_unidad }}
           <br>
           <strong>COSTO TOTAL: </strong>{{ $registro->costo_total }}
         </td>
       </tr>
     @endforeach
   </tbody>
 </table>
