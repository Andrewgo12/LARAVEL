                    <strong style="font-size: 20px;text-transform: uppercase;">Repuestos pendientes</strong><br>
                    <a href="{{ asset('') }}repuesto/Crepuestos/excel_repuestos_pendientes" class="" target="__blank" >Exportar</a>
                    <table style="width: 70%;" class="table table-condensed table-bordered  tbl_repuestos_pendientes">
                     <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Origen</th>
                        <th>Id</th>
                        <th>Equipo</th>
                        <th>Servicio</th>
                        <th>Codigo</th>
                        <th>Repuesto</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($repuestos_pendientes_por_correctivos)): ?>
                        @foreach($repuestos_pendientes_por_correctivos as $repuesto_pendiente_por_correctivo)
                          <tr>
                            <td>{{ $repuesto_pendiente_por_correctivo->fecha_mantenimiento }}</td>
                            <td>Correctivos</td>
                            <td>{{ $repuesto_pendiente_por_correctivo->id }}</td>
                            <td>{{ $repuesto_pendiente_por_correctivo->equipo }}
                            <br>
                            <strong>Codigo: </strong> {{ $repuesto_pendiente_por_correctivo->codigo }}
                            <br>
                            <strong>Serie: </strong> {{ $repuesto_pendiente_por_correctivo->serie }}
                            <br>
                            <strong>Marca: </strong> <?php echo $repuesto_pendiente_por_correctivo->marca ?>
                            <br>
                            <strong>Modelo: </strong> <?php echo $repuesto_pendiente_por_correctivo->modelo ?>
                          </td>
                          <td>{{ $repuesto_pendiente_por_correctivo->servicio }}</td>
                          <td>{{ $repuesto_pendiente_por_correctivo->codigo_cierre_correctivo }}</td>
                          <td>{{ $repuesto_pendiente_por_correctivo->repuesto_por_correctivo }}</td>
                        </tr>            
                      <?php endforeach ?>
                    <?php endif ?>
                    <?php if (!empty($repuestos_pendientes_por_preventivos)): ?>
                      @foreach($repuestos_pendientes_por_preventivos as $repuesto_pendiente_por_preventivo)
                        <tr>
                          <td>{{ $repuesto_pendiente_por_preventivo->fecha_mantenimiento }}</td>
                          <td>Preventivos</td>
                          <td>{{ $repuesto_pendiente_por_preventivo->id }}</td>
                          <td>{{ $repuesto_pendiente_por_preventivo->equipo }}
                          <br>
                          <strong>Codigo: </strong> {{ $repuesto_pendiente_por_preventivo->codigo }}
                          <br>
                          <strong>Serie: </strong> {{ $repuesto_pendiente_por_preventivo->serie }}
                          <br>
                          <strong>Marca: </strong> {{ $repuesto_pendiente_por_preventivo->marca }}
                          <br>
                          <strong>Modelo: </strong> {{ $repuesto_pendiente_por_preventivo->modelo }}
                        </td>
                        <td>{{ $repuesto_pendiente_por_preventivo->servicio }}</td>
                        <td>{{ $repuesto_pendiente_por_preventivo->codigo_cierre_preventivo }}</td>
                        <td>{{ $repuesto_pendiente_por_preventivo->repuesto_por_preventivo }}</td>
                      </tr>            
                    <?php endforeach ?>
                  <?php endif ?>
                  <?php if (!empty($repuestos_pendientes_por_observaciones)): ?>
                    @foreach($repuestos_pendientes_por_observaciones as $repuesto_pendiente_por_observacion)
                      <tr>
                        <td>{{ $repuesto_pendiente_por_observacion->created_at }}</td>
                        <td>Observaciones</td>
                        <td>{{ $repuesto_pendiente_por_observacion->id }}</td>
                        <td>{{ $repuesto_pendiente_por_observacion->equipo }}
                        <br>
                        <strong>Codigo: </strong> {{ $repuesto_pendiente_por_observacion->codigo }}
                        <br>
                        <strong>Serie: </strong> {{ $repuesto_pendiente_por_observacion->serie }}
                        <br>
                        <strong>Marca: </strong> {{ $repuesto_pendiente_por_observacion->marca }}
                        <br>
                        <strong>Modelo: </strong> {{ $repuesto_pendiente_por_observacion->modelo }}
                      </td>
                      <td>{{ $repuesto_pendiente_por_observacion->servicio }}</td>
                      <td></td>
                      <td>{{ $repuesto_pendiente_por_observacion->repuesto_por_observacion }}</td>
                    </tr>             
                  <?php endforeach ?>
                <?php endif ?>
              </tbody>
            </table>    