<!DOCTYPE html>
<html>

	<head>
	<title>Consultar</title>
		<link rel='stylesheet' type='text/css' href='./CSS/arquivo.css'>
		<style>
			a[href="#top"]{
				padding:10px;
				position:fixed;
				top: 90%;
				right:40px;
				display:none;
				font-size: 30px;
			}
			a[href="#top"]:hover{
				text-decoration:none;
			}
			.img{
				width: auto;
				height: auto;
				max-width: 700px;
				max-height: 700px;
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
				margin-bottom: 3px;
				max-width: 1123px;
			}
			
			.filha{
				margin-top: 6px;
				border: 1px solid black;
				border-radius: 8px;
				padding: 5px;
				background-color: white;
				
			}
			.retorno{
				background-color: #DADADA;
				min-height: 300px;
				width: auto;
				float: left;
				padding-bottom: 20px;
				min-width: 1123px;

			}
				
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		
	</head>

	<body>
		
		<div class='divSup'>
			<div class='logo'>
				<a href='home.html'><img src='./imgQuest/logoHome.png' alt='logo' height='50px' width='50px'></a>
			</div>
			<div class='textSup'><h1>Resultado da consulta</h1></div>
			
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
			
			
	<div class='retorno'>
	
		<?php 
			include('conexao.php');
			include('funcoes.php');
			$passaConn = $conn;
			
			$edicao = $_POST['edicao'];
			$cursoConsult = $_POST['cursoConsult'];
			$disciConsult = $_POST['disciConsult'];
			$nivelF = null;
			$nivelM = null;
			$nivelD = null;
			$alternativa = null;
			$dissertativa = null;
			
			
			if(isset($_POST['dissertativa'])){
				$dissertativa = $_POST['dissertativa'];
			}
						
			if(isset($_POST['alternativa'])){
				$alternativa = $_POST['alternativa'];
			}
			
			if(isset($_POST['nivelF'])){
				$nivelF = $_POST['nivelF'];
			}
			
			if(isset($_POST['nivelM'])){
				$nivelM = $_POST['nivelM'];
			}
			
			if(isset($_POST['nivelD'])){
				$nivelD = $_POST['nivelD'];
			}
			
			
				
			// recebe os valores do input curso
			$recebeCurso =  '';
			for($i=0; $i<count($cursoConsult);$i++){
					 $recebeCurso .= "tbcurso.codCurso = ".$cursoConsult[$i]." or ";
					 
				};
				
			$passaCurso = chop($recebeCurso, "or ");
			
			// recebe os valores do input disciplina 
			$recebeDisciplina =  '';
			
			for($i=0; $i<count($disciConsult);$i++){
					 $recebeDisciplina .=  "tbdisciplina.codDisciplina = ".$disciConsult[$i].' or ';
					 
				};
		
			$passaDisciplina = chop($recebeDisciplina, "or ");
			
			
			// recebe os valores do input edicao
			$recebeEdicao =  '';
			for($i=0; $i<count($edicao);$i++){
					 $recebeEdicao .=  "tbquestao.edicao = ".$edicao[$i].' or ';
					 
				};
				
			$passaEdicao = chop($recebeEdicao, "or ");
			
			
			
			if ($passaCurso !== 'tbcurso.codCurso = 0'){
				if($passaDisciplina !== 'tbdisciplina.codDisciplina = 0'){
					if($passaEdicao !== 'tbquestao.edicao = 0'){
						
						//input's $passaCurso	$passaDisciplina	$passaEdicao preenchidos
						
						//Alternativa e dissertativa preenchidos
						if($alternativa !== null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
						
						// dissertativa preenchido
						
						elseif ($alternativa == null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
								
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							else{
								echo 'nenhum preenchido';
							}
						}
						
						// alternativa preenchido
						
						elseif ($alternativa !== null && $dissertativa == null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaCurso) and 
												($passaDisciplina) and 
												($passaEdicao) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
										}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaCurso) and 
												($passaDisciplina) and 
												($passaEdicao) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							}
						
						//Alternativa e dissertativa nulos
						
						else{
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
					} else{
						
						
						//input's $passaCurso	$passaDisciplina preenchidos --	$passaEdicao nulo
						
						//Alternativa e dissertativa preenchidos
						if($alternativa !== null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
						
						// dissertativa preenchido
						
						elseif ($alternativa == null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
								
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							else{
								echo("<div class='filha'>Nenhum preenchido </div>");
							}
						}
						
						// alternativa preenchido
						
						elseif ($alternativa !== null && $dissertativa == null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaCurso) and 
												($passaDisciplina) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
										}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaCurso) and 
												($passaDisciplina) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							}
										
						//Alternativa e dissertativa nulos
						
						else{
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
					
					}
				}	else{
					
					if($passaEdicao !== 'tbquestao.edicao = 0'){
						
						
						//input's $passaCurso	$passaEdicao preenchidos --	$passaDisciplina	nulo
						
						//Alternativa e dissertativa preenchidos
						if($alternativa !== null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
						
						// dissertativa preenchido
						
						elseif ($alternativa == null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
								}
								
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							else{
								echo 'nenhum preenchido';
							}
						}
						
						// alternativa preenchido
						
						elseif ($alternativa !== null && $dissertativa == null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaCurso) and 
												($passaEdicao) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
										}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
											exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
											exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
											exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaCurso) and 
												($passaEdicao) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
													exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							}
					
						//Alternativa e dissertativa nulos
						
						else{
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
					} else{
						
						
						//input's $passaCurso preenchido -- $passaDisciplina 	$passaEdicao nulos
						
						//Alternativa e dissertativa preenchidos
						if($alternativa !== null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
						
						// dissertativa preenchido
						
						elseif ($alternativa == null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
								
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									$registros = mysqli_query($conn, $sql) or
										die ("Erro na consulta 1a".mysqli_error($conn));
										
									$linhas = mysqli_num_rows($registros);
									if($linhas == 0){
										die("<div class='filha'>Nenhuma questão foi encontrada </div>");
									}
									
									$cont = 0;
									
									while ($cont < $linhas){
										$dados = mysqli_fetch_array($registros);?>
										<div class='pai'>
										<div class='codref'><?php echo nl2br("REFCOD: ".$dados['codQuestao']."\n");?><br></div>
											<div class='filha'><?php echo nl2br("Curso: \n".$dados['nomeCurso']."\n");?><br></div>
											<div class='filha'><?php echo nl2br("Disciplina: \n".$dados['nomeDisciplina']."\n");?><br></div>
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
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							else{
								echo 'nenhum preenchido';
							}
						}
						
						// alternativa preenchido
						
						elseif ($alternativa !== null && $dissertativa == null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaCurso) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
										}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaCurso) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
													exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							}
						
						
						//Alternativa e dissertativa nulos
						
						else{
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
									where 
										($passaCurso) and 
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaCurso) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
					
					}
				
				}
			}
			else{
				if($passaDisciplina !== 'tbdisciplina.codDisciplina = 0'){
					if($passaEdicao !== 'tbquestao.edicao = 0'){
						
						//input's 	$passaDisciplina	$passaEdicao preenchidos -- $passaCurso Nulo
						
						//Alternativa e dissertativa preenchidos
						if($alternativa !== null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
						
						// dissertativa preenchido
						
						elseif ($alternativa == null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
								
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							else{
								echo 'nenhum preenchido';
							}
						}
						
						// alternativa preenchido
						
						elseif ($alternativa !== null && $dissertativa == null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaDisciplina) and 
												($passaEdicao) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
													exibeAlternativas($passaDisciplina, $sql, $conn);
										}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaDisciplina) and 
												($passaEdicao) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							}
						
						
						//Alternativa e dissertativa nulos
						
						else{
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
					} else{
						
						
						//input's 	$passaDisciplina preenchido  --	$passaEdicao $passaCurso nulos
						
						//Alternativa e dissertativa preenchidos
						if($alternativa !== null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
						
						// dissertativa preenchido
						
						
						elseif ($alternativa == null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
								
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							else{
								echo 'nenhum preenchido';
							}
						}
						
						// alternativa preenchido
						
						elseif ($alternativa !== null && $dissertativa == null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaDisciplina) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
										}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaDisciplina) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							}
						
	
						//Alternativa e dissertativa nulos
						
						else{
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaDisciplina) and
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								$sql =
								"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
								tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
								from tbcentral
								join tbcurso on tbcentral.codCurso = tbcurso.codCurso
								join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
								join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
								where 
									($passaDisciplina) and
									(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
									tbquestao.tipoQuestao = 'Dissertativa'
										group by tbquestao.codQuestao
									order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
								
								exibeDissertativas($passaDisciplina,$sql, $conn);


								$sql =
								"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
								tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
								tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
								from tbcentral
								join tbcurso on tbcentral.codCurso = tbcurso.codCurso
								join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
								join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
								where 
									($passaDisciplina) and
									(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Alternativa'
										group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";

								exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
					
					}
				}	else{
					
					if($passaEdicao !== 'tbquestao.edicao = 0'){
						
						//input's 	$passaEdicao preenchido --	$passaCurso		$passaDisciplina	nulos
						
						//Alternativa e dissertativa preenchidos
						if($alternativa !== null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
						
						// dissertativa preenchido
						
						elseif ($alternativa == null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
								
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
									($passaEdicao) and 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							else{
								echo 'nenhum preenchido';
							}
						}
						
						// alternativa preenchido
						
						elseif ($alternativa !== null && $dissertativa == null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaEdicao) and 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
										}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												($passaEdicao) and
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
											exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							}
						
						
						//Alternativa e dissertativa nulos
						
						else{
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										($passaEdicao) and
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
					} else{
						
						
						//input's $passaCurso 	$passaDisciplina 	$passaEdicao nulos
						
						//Alternativa e dissertativa preenchidos
						if($alternativa !== null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								
							}
						}
						
						// dissertativa preenchido
						
						elseif ($alternativa == null && $dissertativa !== null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
								
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = '$dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
										exibeDissertativas($passaDisciplina,$sql, $conn);
								}
							
							else{
								echo 'nenhum preenchido';
							}
						}
						
						// alternativa preenchido
						
						elseif ($alternativa !== null && $dissertativa == null){
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
													exibeAlternativas($passaDisciplina, $sql, $conn);
										}
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = '$alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
											join tbcurso on tbcentral.codCurso = tbcurso.codCurso
											join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
											join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
											where 
												(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
													tbquestao.tipoQuestao = '$alternativa'
													group by tbquestao.codQuestao
													order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
											
													exibeAlternativas($passaDisciplina, $sql, $conn);
								}
							}
						
						
						//Alternativa e dissertativa nulos
						
						else{
							if($nivelF !== null && $nivelM !== null && $nivelD !== null){
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio') and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM == null && $nivelD !== null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Dificil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Dificil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF !== null && $nivelM == null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Facil' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Facil' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							elseif($nivelF == null && $nivelM !== null && $nivelD == null){
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Medio' and
										tbquestao.tipoQuestao = 'Dissertativa'
											group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										tbquestao.nivel = 'Medio' and
											tbquestao.tipoQuestao = 'Alternativa'
											group by tbquestao.codQuestao
											order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeAlternativas($passaDisciplina, $sql, $conn);
										
								}
							
							else{
								
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.dissertativa
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
										tbquestao.tipoQuestao = 'Dissertativa'
										group by tbquestao.codQuestao
										order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
									
									exibeDissertativas($passaDisciplina,$sql, $conn);
									
						
								$sql =
									"select tbquestao.codQuestao, tbcurso.nomeCurso, tbdisciplina.nomeDisciplina, tbquestao.edicao,
									tbquestao.numeroQuestao,tbquestao.tipoQuestao, tbquestao.nivel, tbquestao.enunciado, tbquestao.anexo, tbquestao.alternativaA, tbquestao.alternativaB,
									tbquestao.alternativaC,	tbquestao.alternativaD,	tbquestao.alternativaE,	tbquestao.alternativaCorreta, tbquestao.altA, tbquestao.altB, tbquestao.altC, tbquestao.altD, tbquestao.altE 
									from tbcentral
									join tbcurso on tbcentral.codCurso = tbcurso.codCurso
									join tbdisciplina on tbcentral.codDisciplina = tbdisciplina.codDisciplina
									join tbquestao on tbcentral.codQuestao = tbquestao.codQuestao
									where 
										(tbquestao.nivel = 'Facil' or tbquestao.nivel = 'Medio' or tbquestao.nivel = 'Dificil') and
											tbquestao.tipoQuestao = 'Alternativa'
									group by tbquestao.codQuestao
									order by tbquestao.edicao, tbdisciplina.nomedisciplina;";
								
									
								
									exibeAlternativas($passaDisciplina, $sql, $conn);
									
										
								
							}
						}
					
					}
				
				}
			}
			
		?><br>
		
		<a href='consultaFiltro.php'>	
		<div class="back" bgcolor='pink'>
			<img src='./img/voltar.png' height='29px' width='29px'> 
			<div class='voltar'>Voltar</div>
		</div></a>
		
		<a href="#top" class="glyphicon glyphicon-chevron-up"><img src='./img/seta.png' height='35px' width='35px'></a>
	</div>
	
	</div>
	</body>



</html>
<script type="text/javascript">
	$(document).ready(function(){
		$(window).scroll(function(){
			if ($(this).scrollTop() > 100) {
				$('a[href="#top"]').fadeIn();
			} else {
				$('a[href="#top"]').fadeOut();
			}
		});

		$('a[href="#top"]').click(function(){
			$('html, body').animate({scrollTop : 0},800);
			return false;
		});
	});
</script>