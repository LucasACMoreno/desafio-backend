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
					$count[$key]+= 20;
					echo "<br>";
				}
				if (strpos($sender, $expert) !== false) {
					echo 'Tag '.$expert.' encontrada -5<br>';
					$count[$key]-= 10;
					echo "<br>";
				}
				if (strpos($subject, $resposta) !== false && strpos($sender, $customer) !== false) {
					echo 'Tag '.$resposta.' e '.$customer.' encontrada +15<br>';
					$count[$key]+= 15;
					echo "<br>";
				}
				if (strpos($subject, $resposta) !== false && strpos($sender, $expert) !== false) {
					echo 'Tag '.$resposta.' e '.$expert.' encontrada -5<br>';
					$count[$key]-= 10;
					echo "<br>";
				}
				if (strpos($subject, $reclamacao) !== false && strpos($sender, $customer) !== false){
					echo 'Tag '.$reclamacao.' e '.$customer.' encontrada +35<br>';
					$count[$key]+= 35;
					echo "<br>";
				}
				if (strpos($subject, $reclamacao) !== false && strpos($sender, $expert) !== false){
					echo 'Tag '.$reclamacao.' e '.$expert.' encontrada -10<br>';
					$count[$key]-= 25;
					echo "<br>";
				}

			}

	        $dateI = date_create($datecreate);
	        $dateF = date_create($dateupdate);
	        $diff = date_diff($dateI,$dateF); 
	        $dateDif = $diff->format("%a");	  
	        echo $dateDif.'<br>';

	        if ($dateDif >= 30 && strpos($subject, $resposta) !== false) {
	        	$count[$key]+=20;
	        }
	

	        echo '<br>'.$count[$key].'<br>';

			if($count[$key] >= 35){
		        echo "PRIORIDADE ALTA<br>";
				$ticketPriority = 'Prioridade Alta';
				$string = file_get_contents(public_path('json/tickets.json'));
				$json = json_decode($string, true);
				$json[$key]["ticketPriority"][] = $ticketPriority;
				$fp = fopen(public_path('json/tickets.json'), 'w');
				fwrite($fp, json_encode($json));
				fclose($fp);
		    } else{
		        echo "PRIORIDADE NORMAL<br>";
		        $ticketPriority = 'Prioridade Normal';
				$string = file_get_contents(public_path('json/tickets.json'));
				$json = json_decode($string, true);
				$json[$key]["ticketPriority"][] = $ticketPriority;
				$fp = fopen(public_path('json/tickets.json'), 'w');
				fwrite($fp, json_encode($json));
				fclose($fp);
		    }
		}


		
		return view('teste',compact('count'));
	}

}
