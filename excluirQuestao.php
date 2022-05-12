<!DOCTYPE html>
<html>

	<head>
		<link rel='stylesheet' type='text/css' href='./CSS/arquivo.css'>
		<title>Excluir Questão</title>
		
		<style>
 
			.submit{
				border-radius: 10px;
				border: 1px solid black;
				width: 1080px;
				padding: 9px;
				background-color: white;
				
			}
			
			
			
			.codref{
				height: 15px;
				padding-left: 850px;
				color: white;
			}
			
			.pai{
				background-color: #093850;
				padding: 5px;
				border-radius: 15px;
				border: 1px solid black;
				width: 1100px;
				margin-bottom: 3px;
			}
			
			.filha{
				margin-top: 6px;
				border: 1px solid black;
				border-radius: 8px;
				padding: 5px;
				background-color: white;
				
			}
			
			.img{
			width: auto;
			height: auto;
			max-width: 700px;
			max-height: 700px;
			}	
		
		</style>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	
	</head>

	<body>
		<?php
		
		include('conexao.php');
		
		$codQuestao = $_POST['codQuestao'];
		
		$sql = "
		select * from tbquestao
			where codQuestao = $codQuestao;	";
		
		
		$registros = mysqli_query($conn, $sql) or 
			die ("Erro" . mysqli_error($conn));
			
		$linhas = mysqli_num_rows($registros);
			if($linhas == 0){
				die("<div class='divSup'>
						<h1>Conferir dados da questão:</h1>
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
			<div class='filha'>
			Nehuma questão foi encontrada</div> <br> <a href='codExcluir.html'>
				<div class='back' bgcolor='pink'>
					<img src='./img/voltar.png' height='29px' width='29px'> 
						<div class='voltar'>Voltar</div>
				</div></a>");
			}
		?>
		<div class='divSup'>
			<div class='logo'>
				<a href='home.html'><img src='./imgQuest/logoHome.png' alt='logo' height='50px' width='50px'></a>
			</div>
			<div class='textSup'><h1>Realize sua consulta abaixo através dos filtros de selação</h1></div>
			
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
					
			
				<form action='questaoExcluido.php' method='POST'>

					<div id='box'>
	
	
	<?php 
		$cont = 0;
	//inicio laço while
				
		while ($cont < $linhas){
			$dados = mysqli_fetch_array($registros);
			$tipo = $dados['tipoQuestao'];
				if ($tipo == 'Alternativa'){?>
					<div class='pai'>
						<div class='codref'><?php echo nl2br("REFCOD: ".$dados['codQuestao']."\n");?><br></div>
						<div class='filha'><?php echo nl2br("Edição: \n".$dados['edicao']."\n");?><br></div>
						<div class='filha'><?php echo nl2br("Código da Questão no caderno: \n".$dados['numeroQuestao']."\n");?><br></div>
						<div class='filha'><?php echo nl2br("Tipo de Questão: \n".$dados['tipoQuestao']."\n");?><br></div>
						<div class='filha'><?php echo nl2br("Nivel de dificuldade: \n".$dados['nivel'].": ");
							if($dados['nivel'] == 'Facil'){ ?><img  src="./img/facil.png?>" alt='' height='40px' width='40px'> <?php } 
							if($dados['nivel'] == 'Medio'){ ?><img  src="./img/medio.png?>" alt='' height='40px' width='40px'> <?php } 
							if($dados['nivel'] == 'Dificil'){ ?><img  src="./img/dificil.png?>" alt='' height='40px' width='40px'> <?php }
						?><br></div>
						<div class='filha'><?php echo nl2br("Enunciado: \n".$dados['enunciado']."\n");?><br></div>
						<div class='filha'><?php echo nl2br("Anexo: \n");?><img  src="./imgQuest/<?php echo ($dados['anexo']);?>" alt='' class='img'><br></div>
						<div class='filha'><?php echo nl2br("Alternativa A:\n ".$dados['alternativaA']."\n");?><img  src="./imgQuest/<?php echo ($dados['altA']);?>" alt='' class='img'><br></div>
						<div class='filha'><?php echo nl2br("Alternativa B: \n".$dados['alternativaB']."\n");?><img  src="./imgQuest/<?php echo ($dados['altB']);?>" alt='' class='img'><br></div>
						<div class='filha'><?php echo nl2br("Alternativa C: \n".$dados['alternativaC']."\n");?><img  src="./imgQuest/<?php echo ($dados['altC']);?>" alt='' class='img'><br></div>
						<div class='filha'><?php echo nl2br("Alternativa D: \n".$dados['alternativaD']."\n");?><img  src="./imgQuest/<?php echo ($dados['altD']);?>" alt='' class='img'><br></div>
						<div class='filha'><?php echo nl2br("Alternativa E: \n".$dados['alternativaE']."\n");?><img  src="./imgQuest/<?php echo ($dados['altE']);?>" alt='' class='img'><br></div>
						<div class='filha'><b><?php echo nl2br("Alternativa Correta: " . $dados['alternativaCorreta']."\n");?></b><br></div>
					</div><br>
					<div class='pai'>
					<div class='submit'>
						Deseja excluir essa questão?<br><br>
						<input type='submit' value='excluir' >
						
					</div>
				</div>
				
				<?php }
				
				else if ($tipo == 'Dissertativa'){?>
					<div class='pai'>
						<div class='codref'><?php echo nl2br("REFCOD: ".$dados['codQuestao']."\n");?><br></div>
						<div class='filha'><?php echo nl2br("Edição: \n".$dados['edicao']."\n");?><br></div>
						<div class='filha'><?php echo nl2br("Código da Questão no caderno: \n".$dados['numeroQuestao']."\n");?><br></div>
						<div class='filha'><?php echo nl2br("Tipo de Questão: \n".$dados['tipoQuestao']."\n");?><br></div>
						<div class='filha'><?php echo nl2br("Nivel de dificuldade: \n".$dados['nivel'].": ");
							if($dados['nivel'] == 'Facil'){ ?><img  src="./img/facil.png?>" alt='' height='40px' width='40px'> <?php } 
							if($dados['nivel'] == 'Medio'){ ?><img  src="./img/medio.png?>" alt='' height='40px' width='40px'> <?php } 
							if($dados['nivel'] == 'Dificil'){ ?><img  src="./img/dificil.png?>" alt='' height='40px' width='40px'> <?php }
						?><br></div>
						<div class='filha'><?php echo nl2br("Enunciado: \n".$dados['enunciado']."\n");?><br></div>
						<div class='filha'><?php echo nl2br("Anexo: \n");?><img  src="./imgQuest/<?php echo ($dados['anexo']);?>" alt='' class='img'><br></div>
						<div class='filha'><?php echo nl2br("Resposta Dissertativa:\n ".$dados['dissertativa']."\n");?><br></div>
					</div><br><div class='pai'>
					<div class='submit'>
						Deseja excluir essa questão?<br><br>
						<input type='submit' value='excluir' >
						
					</div>
				</div>
				<?php } else{ ?>
					<div class='filha'>Erro ao encontrar questão</div><br>
			<?php	} ?>
					
			<!-- Input para repassar o codigo da questão para a página  questaoExcluido.php-->
						<input type='hidden' name='codigoQuestao' value="<?php echo $codQuestao?>">
					
					</div>
				
				
				
			
		
			
					
					<?php 
					
	//encerra o laço while
	
					$cont++; } ?>
				
				<a href='codExcluir.html'>
				<div class="back" bgcolor='pink'>
					<img src='./img/voltar.png' height='29px' width='29px'> 
						<div class='voltar'>Voltar</div>
				</div></a>
				
				</div>
				
				
				
			</div>
			
			
			
			</form>
			
			
				
			
				
		</div>
		
	
		
		</div>
	</body>



</html>

