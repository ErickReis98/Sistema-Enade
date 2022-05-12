<!DOCTYPE html>
<html>

	<head>
	<title>Cadastrar Curso</title>
		<link rel='stylesheet' type='text/css' href='./CSS/arquivo.css'>
		<meta charset=utf-8″>
	<style>
		
		
		.botao{
			float: left;
			background-color: gray;
			margin-top: 80px;
			margin-left: 11%;
			padding: 10px;
			border: 1px solid black;
			border-radius: 10px;
			color: white;
		}
		
		.separaBox{
			width: auto;
			height: 40px;
		}
		
	</style>
	
	
	
	
	</head>

	<body>
		<div class='divSup'>
			<div class='logo'>
				<a href='home.html'><img src='./imgQuest/logoHome.png' alt='logo' height='50px' width='50px'></a>
			</div>
			<div class='textSup'><h1>Cadastro do curso</h1></div>
			
		</div>
		
		<div class='container'>
			<div class='menulateral'>
				<div class='boxMenu'>
					<a href='cadastrar.html'>Cadastrar</a><br>
						&nbsp;&nbsp; <a href='cadCurso.html'>Cadastrar Curso</a><br>
						&nbsp;&nbsp; <a href='cadDisciplina.html'>Cadastrar Disciplina</a><br>
						&nbsp;&nbsp; <a href='cadQuestao.php'>Cadastrar Questão</a><br>
				</div>
				
				<div class='boxMenu'>
					<a href='escolherAlteracao.html'>Alterar</a><br>
						&nbsp;&nbsp; <a href='alterarCurso.php'>Alterar Curso</a><br>
						&nbsp;&nbsp; <a href='alterarDisciplina.php'>Alterar Disciplina</a><br>
						&nbsp;&nbsp; <a href='codAlterar.html'>Alterar Questão</a><br>
				</div>
				
				<div class='boxMenu'>
					<a href='escolherExclusao.html'>Excluir</a><br>	
						&nbsp;&nbsp; <a href='excluirCurso.php'>Excluir Curso</a><br>
						&nbsp;&nbsp; <a href='excluirDisciplina.php'>Excluir Disciplina</a><br>
						&nbsp;&nbsp; <a href='codExcluir.html'>Excluir Questão</a><br>
				</div>
				
				<div class='boxMenu'>
					<a href='consultaFiltro.php'>Consultar</a><br>
					
				</div>
			</div>
			
			
			<div class='divSub'>
				<div class='retorno'>
				<?php 
					include('conexao.php');
					
					$nomeCurso = $_POST["nomeCurso"];
					
					$sql = 
					"insert into tbcurso (nomeCurso) values
						('$nomeCurso')";
						
						mysqli_query($conn, $sql) or 
								die ("Erro na inserção de dados" . mysqli_error($conn));
			
			?>
			
			<div class='opcoesResult'>
				O curso foi cadastrado com sucesso. O que deseja fazer?
			</div>
			
		</div>
		
		<br>
		
		<div class='separaBox'>
			
			<a href='cadCurso.html'><div class="botao"> 
				Cadastrar outro curso
			</div></a>
			
			<a href='cadDisciplina.html'><div class="botao"> 
				Cadastrar Disciplina
			</div></a>
			
			<a href='cadQuestao.php'><div class="botao"> 
				Cadastrar Questão
			</div></a>
			
		</div>


			</div>
		</div>
	</body>



</html>