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

		$count = 0;
		//SUBJECT
	    $reclameaqui  = 'reclameAqui';
		$procon      = 'procon';
		$reclamacao = 'reclamacao';
		$resposta = 'RE:';
		//SENDER
		$customer = 'Customer';
		$expert = 'Expert';

		foreach($tickets as $key => $ticket){
			$interactions = $ticket['Interactions'];
			$datecreate = $ticket['DateCreate'];
			$dateupdate = $ticket['DateUpdate'];

			foreach($interactions as $keyInteractions => $interaction){
				$subject = $interaction['Subject'];
				$sender = $interaction['Sender'];

				if (strpos($subject, $reclamacao) !== false) {
					echo 'Tag'.$reclamacao.'encontrada';
					echo "<br>";
					$count+= 35;
				} else  if(strpos($subject, $procon) !== false){
					echo 'Tag'.$procon.'encontrada';
					echo "<br>";
					$count+= 35;
				} else  if(strpos($subject, $reclameaqui) !== false){
					echo 'Tag'.$reclameaqui.'encontrada';
					echo "<br>";
					$count+= 35;
				} else  if(strpos($subject, $resposta) !== false){
					echo 'Tag'.$reclamacao.'encontrada';
					echo "<br>";
					$count-= 20;
				} else  if(strpos($sender, $customer) !== false){
					echo 'Tag'.$customer.'encontrada';
					echo "<br>";
					$count+=20;
				} else if(strpos($sender, $expert) !== false){
					echo 'Tag'.$expert.'encontrada';
					echo "<br>";
					$count-=15;
				}
			}

			$dateI = strtotime($datecreate);
	        $dateF = strtotime($dateupdate);
	        $dateDif = $dateI - $dateF;

	        if (round($dateDif / (60 * 60 * 24)) >= 30) {
	        	$count+=30;	
	        }	  

			return view('teste',compact('count'));
		}
		
	}

}
