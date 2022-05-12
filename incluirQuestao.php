<!DOCTYPE html>
<html>

	<head>
	<title>Cadastrar Questão</title>
		<link rel='stylesheet' type='text/css' href='./CSS/arquivo.css'>
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
			<div class='textSup'><h1>Cadastro da questão</h1></div>
			
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
					
					
				
					$pastaimg ='imgQuest/';
					$codCurso =			 $_POST['codCurso'];
					$codDisciplina =	 $_POST['codDisciplina'];
					$edicao =			 $_POST['edicao'];
					$tipoQuestao = 		 $_POST['tipoQuestao'];
					$numeroQuestao =	 $_POST['numeroQuestao'];
					$nivel =			 $_POST['nivel'];
					$enunciado =		 $_POST['enunciado'];
					$alternativaA =		 $_POST['alternativaA'];
					$alternativaB =		 $_POST['alternativaB'];
					$alternativaC =		 $_POST['alternativaC'];
					$alternativaD =		 $_POST['alternativaD'];
					$alternativaE =		 $_POST['alternativaE'];
				
					
					$dissertativa =		 $_POST['dissertativa'];
					

					
					if(isset($_FILES['anexo'])){
						$nomeAnexo = $_FILES['anexo']['name'];
						$tmp_name = $_FILES['anexo']['tmp_name'];
						
						$error = $_FILES['anexo']['error'];
						if($error !== UPLOAD_ERR_OK){
							echo '';
							
						}else{
							move_uploaded_file($tmp_name, $pastaimg.$nomeAnexo);
							
						}
					}
					
					
					
					
					
					
					
					
						
					// bloco para inserir questão alternativa
					
						if($tipoQuestao == "Alternativa"){
								if(isset($_FILES['altA'])){
								$nomeAltA = $_FILES['altA']['name'];
								$tmp_name = $_FILES['altA']['tmp_name'];
								
								$error = $_FILES['altA']['error'];
								if($error !== UPLOAD_ERR_OK){
									echo '';
									
									}else{
									move_uploaded_file($tmp_name, $pastaimg.$nomeAltA);
									
									}
								}
							
								if(isset($_FILES['altB'])){
								$nomeAltB = $_FILES['altB']['name'];
								$tmp_name = $_FILES['altB']['tmp_name'];
								
								$error = $_FILES['altB']['error'];
								if($error !== UPLOAD_ERR_OK){
									echo '';
									
								}else{
									move_uploaded_file($tmp_name, $pastaimg.$nomeAltB);
									
								}
							}
							
							if(isset($_FILES['altC'])){
								$nomeAltC = $_FILES['altC']['name'];
								$tmp_name = $_FILES['altC']['tmp_name'];
								
								$error = $_FILES['altC']['error'];
								if($error !== UPLOAD_ERR_OK){
									echo '';
									
								}else{
									move_uploaded_file($tmp_name, $pastaimg.$nomeAltC);
									
								}
							}
							if(isset($_FILES['altD'])){
								$nomeAltD = $_FILES['altD']['name'];
								$tmp_name = $_FILES['altD']['tmp_name'];
								
								$error = $_FILES['altD']['error'];
								if($error !== UPLOAD_ERR_OK){
									echo '';
									
								}else{
									move_uploaded_file($tmp_name, $pastaimg.$nomeAltD);
									
								}
							}
							
							if(isset($_FILES['altE'])){
								$nomeAltE = $_FILES['altE']['name'];
								$tmp_name = $_FILES['altE']['tmp_name'];
								
								$error = $_FILES['altE']['error'];
								if($error !== UPLOAD_ERR_OK){
									echo '';
									
								}else{
									move_uploaded_file($tmp_name, $pastaimg.$nomeAltE);
									
								}
							}	
								$alternativaCorreta = $_POST['alternativaCorreta'];
								
							// Inserir a questão na tabela tbquestao
							
								$sql = 
								"insert into tbQuestao (edicao, numeroQuestao, tipoQuestao, nivel, enunciado, anexo, alternativaA, alternativaB, alternativaC, alternativaD, alternativaE, alternativaCorreta, altA, altB, altC, altD, altE) values
									('$edicao','$numeroQuestao','$tipoQuestao','$nivel','$enunciado','$nomeAnexo','$alternativaA', '$alternativaB', '$alternativaC', '$alternativaD', '$alternativaE', '$alternativaCorreta', '$nomeAltA', '$nomeAltB', '$nomeAltC', '$nomeAltD', '$nomeAltE')";
								
								
									
									mysqli_query($conn, $sql) or 
											die ("Erro na inserção de dados" . mysqli_error($conn));
								
								
								//buscar a questão incluida para tambem inserir na tbcentral
								
								$sql2 = 
								"select codQuestao, edicao, numeroQuestao, tipoQuestao, nivel, enunciado, anexo, alternativaA, alternativaB,
									alternativaC, alternativaD, alternativaE, alternativaCorreta
									from tbquestao
									order by codQuestao desc;";
								
									$query = mysqli_query($conn, $sql2) or 
											die ("Erro na inserção de dados" . mysqli_error($conn));
								
									$dados = mysqli_fetch_array($query);
								
								// inserindo a questão na tbcentral
								
								for($i=0;$i<count($codDisciplina);$i++){
									
								$sql3 =
									"insert into tbcentral (codCurso, codDisciplina, codQuestao)
									values 
									('$codCurso', '$codDisciplina[$i]', '".$dados['codQuestao']."')";
									
								$query3 = mysqli_query($conn, $sql3) or 
									die ("Erro na inserção de dados" . mysqli_error($conn));
								
								}
								
						}
					
					
					// bloco para inserir questão dissertativa 
					
					else{
							$sql = 
						"insert into tbQuestao (edicao, numeroQuestao, tipoQuestao, nivel, enunciado, anexo, dissertativa) values
							('$edicao','$numeroQuestao','$tipoQuestao','$nivel','$enunciado','$nomeAnexo','$dissertativa')";
						
						
							
							mysqli_query($conn, $sql) or 
									die ("Erro na inserção de dados" . mysqli_error($conn));
						
						
						//buscar a questão incluida para tambem inserir na tbcentral
						
						$sql2 = 
						"select codQuestao, edicao, numeroQuestao, tipoQuestao, nivel, enunciado, anexo, dissertativa
							from tbquestao
							order by codQuestao desc;";
						
							$query = mysqli_query($conn, $sql2) or 
									die ("Erro na inserção de dados" . mysqli_error($conn));
						
							$dados = mysqli_fetch_array($query);
						
						// inserindo a questão na tbcentral
						
						for($i=0;$i<count($codDisciplina);$i++){
							
						$sql3 =
							"insert into tbcentral (codCurso, codDisciplina, codQuestao)
							values 
							('$codCurso', '$codDisciplina[$i]', '".$dados['codQuestao']."')";
							
						$query3 = mysqli_query($conn, $sql3) or 
							die ("Erro na inserção de dados" . mysqli_error($conn));
						
						}
					
					}
					
		
				?>
			
			<div class='opcoesResult'>
				A questão foi cadastrada com sucesso. O que deseja fazer?
			</div>
			
		</div>
		
		<br>
		
		<div class='separaBox'>
			
			<a href='cadCurso.html'><div class="botao"> 
				Cadastrar Curso
			</div></a>
			
			<a href='cadDisciplina.html'><div class="botao"> 
				Cadastrar Disciplina
			</div></a>
			
			<a href='cadQuestao.php'><div class="botao"> 
				Cadastrar outra questão
			</div></a>
			
		</div>
		</div>
		</div>
	</body>



</html>