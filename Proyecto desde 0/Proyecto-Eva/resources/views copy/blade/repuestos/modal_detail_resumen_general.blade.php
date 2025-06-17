<strong>RESUMEN DE REPUESTOS INSTALADOS</strong>
            <table class="table table-bordered table-condensed tbl_resumen_general">
              <thead>
                <tr>
                  <th>Año</th>
                  <th>Mes</th>
                  <th>Cantidad repuestos instalados</th>
                  <th>Costo total COP</th>
                </tr>
              </thead>
              <tbody>
                @foreach($consolidado_anio_mes_general as $registro)
                  <tr>
                    <td>{{ $registro->anio }}</td>
                    <td>{{ $registro->mes }}</td>
                    <td>
                      {{ $registro->cantidad }}
                    </td>
                    <td>
                     {{ $registro->costo_total }}
                   </td>
                 </tr>
               @endforeach
             </tbody>
           </table>
