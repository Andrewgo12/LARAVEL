
<?php 
error_reporting(0);
?>
<!DOCTYPE HTML>
<html lang="es">

<head>
  <title>HUV</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
   <link rel="stylesheet" href="<?php echo base_url();?>/style/style.css" type="text/css"></link>
    </head>
    

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
      
        <div id="logo_text">
          <h1><a href="Cequipos_industriales"><span class="logo_colour"> Equipos Industriales </span></a></h1>
          <h2>Hospital Universitario del Valle</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <li class="selected"><a href="Cequipos_industriales">Equipos Industriales</a></li>
        </ul>
      </div>
    </div>
    <div id="content_header"></div>
    <div id="site_content">


      <div id="content">
          <h2>Base de datos: Equipos industriales</h2>
          <?php
             foreach ($datos as $dato)
                    {
                       $dato->nombre;
                       $dato->marca;
                       $dato->serial;
                       $dato->servicio_id;
                       $dato->periodicidad_id;
                       $dato->imagen;
                }

          ?>
          <!--style="width:60%; border-spacing:0;position: relative;-->
          <table style="width:500px; border-spacing:0";>
          <tr><th>Datos</th>  <th>Descripcion</th></tr> 
          <tr><td>Nombre :   </td><td><?php echo "".$dato->nombre; ?></td></tr>      
          <tr><td>Marca  :   </td><td><?php echo "".$dato->marca; ?></td></tr>
          <tr><td>Serial :   </td><td><?php echo "".$dato->serial; ?></td></tr>
          <tr><td>Servicio : </td><td><?php echo "".$dato->name; ?></td></tr>
          <tr><td>Periodicidad Mantenimiento : </td><td><?php echo "".$dato->namem; ?></td></tr>
         </table>
           

         <form style="border-spacing:10px; top: 215px; right: 35%;position: absolute;">

         <h1>Equipo Industrial</h1>
         <img src="<?php echo base_url();?>/style/imagenes_equipos_industriales/<?php echo $dato->imagen ?>" style="width:274px;height:190px;"> 
         </form>
          
         
             

          <form   method = "post" action="Cequipos_industriales" style="width:230px;height:210px; top: 240px; right: 14%;position: absolute;" >
          <h2>Busqueda de equipos </h2><br>
           Nombre del equipo:<br>
                <input type="text" name="nombre" value=""><br><br>
              Marca:<br>
                <input type="text" name="marca" value=""><br><br>
              Serial:<br>
                <input type="text" name="serial" value=""><br><br>
               <input type="submit" value="Buscar">
    
          </form>

      </div>
  </div> 

    <div id="content_footer"></div>
    <div id="footer">
      <p> <a href="Cequipos_industriales">Equipos industriales</a></p>
    </div>
  </div>
</body>
</html>
