<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <title> Buscar llamadas </title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
</head>
<body>
 <div class="container">
    <h1> Llamadas </h1>
    <form method="post" action="llamadas">
       <div class="form-group">
          <label for="id_cliente"> Código del cliente </label>
          <input type="number" name="id_cliente" id="id_cliente" class="form-control" min="0" value="<?php echo $id_cliente ?>" />
       </div> 
       <button type="submit" class="btn btn-primary"> Buscar </button>
    </form> 
    <?php if($buscando): ?>
       <?php if(count($llamadas) > 0): ?>
          <h2> <?php echo $llamadas[0]->nombre ?> <?php echo $llamadas[0]->apellido ?> </h2> 
          <a href="llamadas/generar_excel/<?php echo $id_cliente ?>" target="_blank"> Generar excel </a> 
       <?php endif; ?> 
       <table class="table">
          <thead>
             <tr>
                <th> Número de teléfono </th>
                <th> Fecha </th>
                <th> Mensaje </th>
             </tr> 
          </thead>
          <tbody>
             <?php if(count($llamadas) > 0): ?> 
                <?php foreach($llamadas as $item): ?>
                   <tr> 
                      <td> <?php echo $item->telefono ?> </td> 
                      <td> <?php echo $item->fecha ?> </td> 
                      <td> <?php echo $item->mensaje ?> </td> 
                   </tr> 
                <?php endforeach; ?> 
             <?php else: ?> 
                <tr>
                   <td colspan="3"> No se han encontrado registros </td> 
                </tr> 
             <?php endif; ?> 
          </tbody> 
       </table> 
    <?php endif; ?> 
 </div>
</body>
</html>
