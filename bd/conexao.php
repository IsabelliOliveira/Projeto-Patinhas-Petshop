<?PHP
$localhost = "localhost";
$usuario = "root";
$senha ="";
$BD = "patinhas";
$conexao= new mysqli($localhost,$usuario,$senha,$BD);

    if($conexao -> connect_error){
        echo "falha";
    }else{
        echo "conectado";
    }

?>