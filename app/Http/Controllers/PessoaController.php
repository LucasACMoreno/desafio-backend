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
		$respostareclamacao = 'RE: Reclamação';
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

				if (strpos($subject, $reclamacao) !== false) {
					echo 'Tag '.$reclamacao.' encontrada +35<br>';
					$count[$key]+= 35;
					echo "<br>";
				}
				if(strpos($subject, $respostareclamacao) !== false){
					echo 'Tag '.$respostareclamacao.' encontrada -20<br>';
					$count[$key]-= 20;
					echo "<br>";
				}
				if(strpos($subject, $resposta) !== false){
					echo 'Tag '.$resposta.' encontrada -20<br>';
					$count[$key]-= 20;
					echo "<br>";
				}
				if(strpos($subject, $procon) !== false){
					echo 'Tag '.$procon.' encontrada +35<br>';
					$count[$key]+= 35;
					echo "<br>";
				}
				if(strpos($subject, $reclameaqui) !== false){
					echo 'Tag '.$reclameaqui.' encontrada +35<br>';
					$count[$key]+= 35;
					echo "<br>";
				}
				if(strpos($subject, $resposta) !== false && strpos($sender, $expert) !== false){
					echo 'Tag '.$resposta.' encontrada -20<br>';
					echo "<br>";
					$count[$key]-= 20;
				}
				if(strpos($subject, $resposta) !== false && strpos($sender, $customer) !== false){
					echo 'Tag '.$resposta.' encontrada +25<br>';
					echo "<br>";
					$count[$key]+= 25;
				}
				if(strpos($sender, $expert) !== false){
					echo 'Tag '.$expert.' encontrada -15<br>';
					$count[$key]-= 15;
					echo "<br>";
				}
			}

			$dateI = strtotime($datecreate);
	        $dateF = strtotime($dateupdate);
	        $dateDif = $dateI - $dateF;

	        if (round($dateDif / (60 * 60 * 24)) >= 30) {
	        	echo 'Tag '.$dateDif.' encontrada +30<br>';
	        	$count[$key]+=30;	
	        }	
	

	        echo '<br>'.$count[$key].'<br>';

			if($count[$key] > 60){
		        echo "PRIORIDADE ALTA<br>";
				$ticketPriority['ticket']['ticketPriority'] = 'Prioridade Alta';
				$fp = fopen(public_path('json/tickets.json'), 'w');
				fwrite($fp, json_encode($ticketPriority));
				fclose($fp);		        
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
