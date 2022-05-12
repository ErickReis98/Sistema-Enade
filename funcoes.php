<?php 

require('conexao.php');

function exibeDissertativas($passaDisciplina,$sql, $conn){
	
	$registros = mysqli_query($conn, $sql) or
		die ("Erro na consulta 1a".mysqli_error($conn));
		
	$linhas = mysqli_num_rows($registros);
	if($linhas == 0){
			echo("<div class='filha'>Nenhuma questão dissertativa foi encontrada </div>");
	}
	
	$cont = 0;
	while ($cont < $linhas){
	$dados = mysqli_fetch_assoc($registros);?>
		<div class='pai'>
		<div class='codref'><?php echo nl2br("REFCOD: ".$dados['codQuestao']."\n");?><br></div>
			<div class='filha'><?php echo nl2br("Curso: \n".$dados['nomeCurso']."\n");?><br></div>
			<div class='filha'><?php echo nl2br("Essa questão está cadastrada nas seguintes disciplinas: \n\n");
		
			$pegaCodigo = $dados['codQuestao'];
			exibeDisciplinas($pegaCodigo, $conn);
			
			?>
			<br></div>
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
			<div class='filha'><?php echo nl2br("Resposta Dissertativa: \n".$dados['dissertativa']."\n");?><br></div>
		</div><br><br>
		<?php	
	$cont++;
}
}

function exibeAlternativas($passaDisciplina,$sql, $conn){
	
	$registros = mysqli_query($conn, $sql) or
		die ("Erro na consulta 1a".mysqli_error($conn));
		
	$linhas = mysqli_num_rows($registros);
	if($linhas == 0){
			echo("<div class='filha'>Nenhuma questão de alternativas foi encontrada </div>");
	}
	
	$cont = 0;
	
	while ($cont < $linhas){
		$dados = mysqli_fetch_assoc($registros);?>
		<div class='pai'>
			<div class='codref'><?php echo nl2br("REFCOD: ".$dados['codQuestao']."\n");?><br></div>
			<div class='filha'><?php echo nl2br("Curso: \n".$dados['nomeCurso']."\n");?><br></div>
			<div class='filha'><?php echo nl2br("Essa questão está cadastrada nas seguintes disciplinas: \n\n");
			$pegaCodigo = $dados['codQuestao'];

			exibeDisciplinas($pegaCodigo, $conn);
			
			
			?>
			<br></div>
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
		</div><br><br>		
		<?php	
		$cont++;
	}

}

function exibeDisciplinas($pegaCodigo, $conn){


	$ident = $pegaCodigo;
									
	$query = "select tbdisciplina.nomeDisciplina
				from tbcentral
				join tbcurso on tbcentral.codCurso = tbcurso.codCurso
				join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
				join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
				where 
				tbquestao.codQuestao = '$ident';";
						
	$reg = mysqli_query($conn, $query) or 
		die("Erro".mysqli_error($conn));
	
	
	$conta = 0;
	$concat = '';
	while($nome = mysqli_fetch_assoc($reg)){
		$concat .= $nome['nomeDisciplina'].", ";
	}
	$exibe = chop($concat, ", ");
	$resultado = $exibe."."; 
	echo $resultado;
}






?>