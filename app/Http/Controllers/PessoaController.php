<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class PessoaController extends Controller
{
    public function lista(){

		$tickets = $this->ReadJSON();

		//ordena json por data
		usort($tickets, function($a, $b) { 
		    return $a["CustomerName"] > $b["CustomerName"] ? 1 : -1; 
		});                                                                                                                                                                                        

		return view('pessoa',compact('tickets'));

	}

	public function ReadJSON(){
		
	    $jsonString = file_get_contents(public_path('json/tickets.json'));
	    $data = json_decode($jsonString, true);

	    return $data;	

	}

	function priority() {
	    $tickets = getTickets();
	    $termo = 'Reclamação';
	    $reclamacao  = '/' . 'reclamacao' . '/i'; //Padrão a ser encontrado na string $tags
		$procon      = '/' . 'procon' . '/i';
		$reclameAqui = '/' . 'reclameAqui' . '/i';


	    //Instruction to create priority based on requirements
	    foreach ($tickets as $key => $value) {
	        $DateCreate    = $value["DateCreate"];
	        $DateUpdate    = $value["DateUpdate"];
	        $Interactions  = $value["Interactions"];

	        foreach ($Interactions as $keychildren => $valuechildren) {
	            $Subject = $valuechildren["Subject"];

	            //Checks if the subject contains the word "reclamação"
	            if (strpos($Subject, $reclamacao) !== false) {
	                $ticketPriority = $tickets[$key]["TicketPriority"] = "Alta";
	            } else {
	                $ticketPriority = $tickets[$key]["TicketPriority"] = "Normal";
	            }
	        }

	        //Checking the difference between the date of submission and the last update
	        $date1 = strtotime($DateCreate);
	        $date2 = strtotime($DateUpdate);
	        $datediff = $date2 - $date1;

	        if (round($datediff / (60 * 60 * 24)) >= 30) {
	            $ticketPriority = $tickets[$key]["TicketPriority"] = "Alta";
	        }
	    }

	    //Push $ticketPriority element onto the end of array
	        //array_push($tickets, $ticketPriority);
	    //Returns the array to JSON representation
	        //$jsonData = json_encode($tickets);
	    //Write the $jsonData to a tickets.json file
	        //file_put_contents('tickets.json', $jsonData);
	    //Este trecho foi todo comentado pois não encontrei um modo de adicionar o elemento ao arquivo json sem "quebrar" sua formatação...
	}

}
