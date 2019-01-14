<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class PessoaController extends Controller
{
    public function GetTickets(){

		$tickets = $this->ReadJSON();                                                                                                                      
		return view('pessoa',compact('tickets'));

	}

	public function ReadJSON(){
		
	    $jsonString = file_get_contents(public_path('json/tickets.json'));
	    $data = json_decode($jsonString, true);

	    return $data;	

	}

	public function Priority(){

		$tickets = $this->ReadJson();

		$count = [];
		//SUBJECT
	    $reclameaqui  = 'reclameAqui';
		$procon      = 'procon';
		$reclamacao = 'Reclamação';
		$resposta = 'RE: ';
		//SENDER
		$customer = 'Customer';
		$expert = 'Expert';

		foreach($tickets as $key => $ticket){

			$interactions = $ticket['Interactions'];
			$datecreate = $ticket['DateCreate'];
			$dateupdate = $ticket['DateUpdate'];
			$count[$key] = 0;

			foreach($interactions as $keyInteractions => $interaction){

				$subject = $interaction['Subject'];
				$sender = $interaction['Sender'];


				if (strpos($sender, $customer) !== false) {
					echo 'Tag '.$customer.' encontrada +15<br>';
					$count[$key]+= 15;
					echo "<br>";
				}
				if (strpos($sender, $expert) !== false) {
					echo 'Tag '.$expert.' encontrada -5<br>';
					$count[$key]-= 5;
					echo "<br>";
				}
				if (strpos($subject, $resposta) !== false && strpos($sender, $customer) !== false) {
					echo 'Tag '.$resposta.' e '.$customer.' encontrada +15<br>';
					$count[$key]+= 15;
					echo "<br>";
				}
				if (strpos($subject, $resposta) !== false && strpos($sender, $expert) !== false) {
					echo 'Tag '.$resposta.' e '.$expert.' encontrada -5<br>';
					$count[$key]-= 5;
					echo "<br>";
				}
				if (strpos($subject, $reclamacao) !== false && strpos($sender, $customer) !== false){
					echo 'Tag '.$reclamacao.' e '.$customer.' encontrada +35<br>';
					$count[$key]+= 35;
					echo "<br>";
				}
				if (strpos($subject, $reclamacao) !== false && strpos($sender, $expert) !== false){
					echo 'Tag '.$reclamacao.' e '.$expert.' encontrada -10<br>';
					$count[$key]-= 10;
					echo "<br>";
				}

			}

			$dateI = date("Y-m-d",strtotime($datecreate));
			$dataInicial = str_replace('-', '/', $dateI);
	        echo $dataInicial;
	        $dateF = date("Y-m-d",strtotime($dateupdate));
	        $dataFinal = str_replace('-', '/', $dateF);
	        echo '<br>'.$dataFinal;
	        //$dateDif = ($dataFinal - $dataInicial)/86400;
	        //echo '<br>'.$dateDif;

	        /*if (round($dateDif / (60 * 60 * 24)) >= 30) {
	        	$count[$key]+=30;	
	        }*/
	

	        echo '<br>'.$count[$key].'<br>';

			if($count[$key] >= 35){
		        echo "PRIORIDADE ALTA<br>";
				/*$ticketPriority['ticket']['ticketPriority'] = 'Prioridade Alta';
				$fp = fopen(public_path('json/tickets.json'), 'w');
				fwrite($fp, json_encode($ticketPriority));
				fclose($fp);		*/        
		        //echo "<br><br><br>".$count[$key];
		        $count[$key] = 0;	
		    } else{
		        echo "PRIORIDADE NORMAL<br>";
		        /*$ticketPriority[]['ticketPriority'] = 'Prioridade Normal';
		        $fp = fopen(public_path('json/tickets.json'), 'w');
				fwrite($fp, json_encode($ticketPriority));
				fclose($fp);*/
		        //echo "<br><br><br>".$count[$key];
		        $count[$key] = 0;
		    }
		}


		
		return view('teste',compact('count'));
	}

}
