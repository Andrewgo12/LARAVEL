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
      <?php foreach ($consolidado_anio_mes as $registro): ?>
        <tr>
          <td><?php echo $registro->anio; ?></td>
          <td><?php echo $registro->mes; ?></td>
          <td>
            <?php echo $registro->repuesto; ?>
            <br>
            <strong>CANTIDAD INSTALADA:</strong>
            <?php echo $registro->cantidad; ?>

          </td>
          <td>
           <strong>COSTO UNITARIO: </strong><?php echo $registro->costo_unidad; ?>
           <br>
           <strong>COSTO TOTAL: </strong><?php echo $registro->costo_total; ?>
         </td>
       </tr>
     <?php endforeach ?>
   </tbody>
 </table>