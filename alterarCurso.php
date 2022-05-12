<!DOCTYPE html>
<html>

	<head>
		<link rel='stylesheet' type='text/css' href='./CSS/arquivo.css'>
		<title>Alterar Curso</title>
		<style>
			
			
			#nomCurso{
			height: 60px;
			width: 400px;
			background-color: navy;
			margin-left: 50px
			}
			
			#box_curso{
			margin-top: 6px;
				border: 1px solid black;
				border-radius: 8px;
				padding: 5px;
				background-color: #dadada;
				margin-right: 3px;
			}
			
			.submit{
			margin-left: 50px;
			}
			
		</style>
	</head>

	<body>
		<div class='divSup'>
			<div class='logo'>
				<a href='home.html'><img src='./imgQuest/logoHome.png' alt='logo' height='50px' width='50px'></a>
			</div>
			<div class='textSup'><h1>Qual curso deseja alterar?</h1></div>
			
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
			<form action='cursoAlterado.php' method='POST'>
				<div id='box_curso'>
					<label>Escolha o curso</label><br>
					<?php include("conexao.php");?>
					
						<select name='codCurso' required>
							<option value="">Selecione</option>
							<?php 
								$select_curso = "select * from tbcurso order by nomeCurso";
								$result_curso = mysqli_query($conn, $select_curso);
								while($linha_curso = mysqli_fetch_assoc($result_curso)){
									echo'<option value="'.$linha_curso['codCurso'].'">'.$linha_curso['nomeCurso'].'</option>';
									}
							?>
											
						</select><br><br>
							Alterar o nome para:<br>
							<input	type='text'			id='nomeCurso'
									name='nomeCurso'	maxlength='70'
									required			size='70'
									placeholder="Informe o nome do curso" >
				<br><br>
				<div class='submit'>
					<input type='submit' value='Alterar' >
				</div>
				
				</div><br>
				
			</form>
			
			<br>
				<a href='escolherAlteracao.html'>
				<div class="back" bgcolor='pink'>
					<img src='./img/voltar.png' height='29px' width='29px'> 
						<div class='voltar'>Voltar</div>
				</div></a>
			
			
		</div>
		</div>
	</body>

</html>