 <?php
    
    include('verifica.php');  //SEGURANÇA
    include('conect.php');  //CONEXÃO

    if(isset($_GET['codigo'])){
        $id = $_GET['codigo'];
        
        $sql = 'DELETE FROM tblcategoria WHERE idCategoria ='. $id;
        
        if(mysqli_query($conexao, $sql)){
            echo 'success';
        }else{
            echo "<script> alert('Esta categoria não pode ser apagada pois existem subcategorias associadas a ela') </script>";
        }
        
    }

?>
<html>
    <head>
        <title>Gerenciamento de categorias</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        
        <script>
            var modal = document.getElementById('modalContainer_prod');
            
            $(document).ready(function(){
                $("#bt_cat").click(function(){
                    $("#modalContainer_prod").fadeIn(2000);
                });
                
            });
            
            $(document).ready(function(){
                $(".edit").click(function(){
                    $("#modalContainer_prod").fadeIn(2000);
                });
                
            });
            
            function novo(){
                $.ajax({
                    type: "POST",
                    url: "modal_cad_categoria.php?modo=inserir",
                    success: function(dados){
                                $('#modal_prod').html(dados);
                            }
                    
                });
            }
            
            function editar(id){
                $.ajax({
                    type: "GET",
                    url: "modal_cad_categoria.php",
                    data:{modo:'editar',id:id},
                    success: function (dados){
                        $('#modal_prod').html(dados);
                    }
                    
                });
            }
            
            function excluir(codigo){
                $.ajax({
                    type: "GET",
                    url: "gerenciamento_categorias.php",
                    data:{codigo:codigo},
                    success: function (dados){
                        console.log(dados);
                        $('#principal').html(dados);
                    }
                    
                });
                
            }
           

        </script>
        
    </head>
    <body>
        <div id="modalContainer_prod">
            <div id="modal_prod">
            </div>
        </div>
        <div id="principal">
            <?php include('hd.php') ?>
            
            <main>
                <?php include('menu.php') ?>
                
                <div id="conteudo">
                    <input id="bt_cat" onclick="novo()" type="button" value="Inserir Categoria" name="btncategoria">                   
                    <h1>Gerenciamento de categorias</h1>                
                    <?php
                    
                        include('conect.php');
                        
                        $sql = 'select * from tblcategoria order by idCategoria desc';
                        $select = mysqli_query($conexao, $sql);
            
                        while($rsCategoria=mysqli_fetch_array($select)){
                    ?>
                    
                        <div class="container_categoria">
                            <div class="item_categoria">
                                <?php echo($rsCategoria['nome']) ?>
                            </div>
                            <div class="icones_categoria">
                                <a href="#" class="edit" onclick="editar(<?= $rsCategoria['idCategoria'] ?>)">
                                    <img src="imagens/edit.png" alt="edit" title="edit">
                                </a>
                                <a id="excluir" onclick="excluir(<?= $rsCategoria['idCategoria'] ?>)">
                                    <img src="imagens/del.png" alt="delete" title="delete">
                                </a>                            
                            </div>
                        </div>
                    
                    <?php 
                        }
                    ?>
                </div>
            </main>
            <?php include('foot.php') ?>
        </div>
    </body>
</html>