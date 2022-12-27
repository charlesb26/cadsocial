<?php 
$tabela = 'estado';
require_once("../../conexao.php");

$nome = $_POST['nome'];
$uf = $_POST['uf'];
$pais = $_POST['pais'];
$id = $_POST['id'];

//validar nome
$query = $pdo->query("SELECT * FROM $tabela where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id and $res[0]['pais'] == $pais){
	echo 'Estado já Cadastrado neste País, escolha Outro Estado!';
	exit();	
}

if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, uf = :uf, pais = '$pais'");
	$acao = 'inserção';

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, uf = :uf, pais = '$pais' WHERE id = '$id'");
	$acao = 'edição';
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":uf", "$uf");
$query->execute();
$ult_id = $pdo->lastInsertId();

if($ult_id == "" || $ult_id == 0){
	$ult_id = $id;
}

//inserir log
$acao = $acao;
$descricao = $nome;
$id_reg = $ult_id;
require_once("../inserir-logs.php");

echo 'Salvo com Sucesso'; 

?>