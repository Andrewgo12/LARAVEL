<table class="table table-bordered tblRelacionGuias">
    <thead>
        <tr>
            <th>resultado</th>
            <th>Cantidad Equipos sin guia</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($relaciones as $relacion)
            <tr>
                <td>{{ $relacion->consulta }}</td>
                <td>{{ $relacion->cuenta }}</td>
                <td><a onclick="enviar_a_formulario('{{ $relacion->name }}', '{{ $relacion->marca }}', '{{ $relacion->modelo }}')" href="#" class="btn btn-warning"><i class="fa fa-random"></i></a></td>
            </tr>
        @endforeach
    </tbody>
</table>
