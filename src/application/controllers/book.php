<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Book extends CI_Controller {
	public function view($id = 1, $type = 'arrivals') {	
	$this->smartylib->assign('page', $id.$type);
		$this->load->model('Booking');
		$eventname = $this->Booking->get_event_name($id);
		if($type == 'departures')
		{
			$flights = $this->Booking->get_departures($id);
			$this->smartylib->assign('type', 'dep');
			$this->smartylib->assign('title', $eventname.' Departures');
		}
		else
		{
			$flights = $this->Booking->get_arrivals($id);
			$this->smartylib->assign('type', 'arr');
			$this->smartylib->assign('title', $eventname.' Arrivals');
		}
		
		
		$this->smartylib->assign('flights', $flights);
		$this->smartylib->assign('event', $eventname);
		$this->_display('flightList.tpl');
		
	}
	
	function add($id) {
		$this->load->model('Booking');
		$this->load->library('Kcaptcha');
		if(!($this->Booking->flight_exists($id)))
		{
			$this->smartylib->assign('title', 'Flight not exists!');
			$this->smartylib->assign('error', 'Flight not exists!');
			$this->_display('booking_error.tpl');
			return;
		}
		if($this->Booking->is_booked($id))
		{
			$this->smartylib->assign('title', 'Already booked!');
			$this->_display('already_booked.tpl');
			return;
		}
		$this->smartylib->assign('route_id', $id);
		$routeinfo = $this->Booking->get_route($id);
		$this->smartylib->assign('title', 'Book flight '.$routeinfo->airline.$routeinfo->flight.' from '.$routeinfo->from.' to '.$routeinfo->to);
		$this->smartylib->assign('dep', $routeinfo->from);
		$this->smartylib->assign('arr', $routeinfo->to);
		//$this->smartylib->assign('result', $this->kcaptcha->check_post($this->input->post('kcaptcha')));
		$this->_display('booking_add.tpl');		
	}
	
	function process($id) {
		$this->load->model('Booking');
		$this->load->library('Kcaptcha');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('vid', 'vid', 'required|exact_length[6]|numeric');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');
		
		$this->form_validation->set_rules($rules);
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->smartylib->assign('title', 'Booking error!');
			$this->smartylib->assign('error', 'Form filled incorrect. Check email and vid!');
			$this->_display('booking_error.tpl');
			return;
		}
		
		if(!($this->Booking->flight_exists($id)))
		{
			$this->smartylib->assign('title', 'Flight not exists!');
			$this->smartylib->assign('error', 'Flight not exists!');
			$this->_display('booking_error.tpl');
			return;
		}
		if($this->kcaptcha->check($this->input->post('kcaptcha'))) {
			if($this->Booking->add_booking($id, $this->input->post('vid'), $this->input->post('email')))
			{
				$this->smartylib->assign('title', 'Booking successfull!');
				$this->smartylib->assign('email', $this->input->post('email'));
				
				
				$this->load->library('email');
				$routeinfo = $this->Booking->get_route($id);
		
				$this->email->from('noreply@ivaoru.org', 'RFE Moscow Robot');
				$this->email->to($this->input->post('email'));
				
				$this->email->subject('RU-IVAO RFE Moscow / Flight '.$routeinfo->airline.$routeinfo->flight);
				$this->email->message("Congratulations!\r\n
\r\n
You have successfully booked the flight ".$routeinfo->airline.$routeinfo->flight.".\r\n
\r\n
Please, check Pilots briefing before departure!\r\n
\r\n
FLIGHT INFO\r\n
Flight Number: ".$routeinfo->airline.$routeinfo->flight."\r\n
From: ".$routeinfo->from." (".$routeinfo->name1." \\".$routeinfo->city1.", ".$routeinfo->country1.")\r\n
Departure Time: ".$routeinfo->dtime."\r\n
To: ".$routeinfo->to." (".$routeinfo->name2." \\".$routeinfo->city2.", ".$routeinfo->country2.")\r\n
Arrival Time: ".$routeinfo->atime."\r\n
Aircraft Type: ".$routeinfo->aircraft."\r\n
Gate: ".$routeinfo->gate."\r\n
\r\n
If you would like to cancel your booking, please, send e-mail with cancelation request to: ru-wm@ivao.aero with copy to ru-awm@ivao.aero. Include your VID and flight number in this e-mail.\r\n
\r\n
Regards,\r\n
RFE Moscow Event Team.");
				
				$this->email->send();
				

				$this->_display('booking_success.tpl');	
			}
		}
		else {
			$this->smartylib->assign('title', 'Booking failed!');
			$this->smartylib->assign('error', 'Cpathca incorrect!');
			$this->_display('booking_error.tpl');	
		}
	}
	
	function confirm($id, $code) {
		$this->load->model('Booking');
		if($this->Booking->confirm_booking($id, $code)) {
			$this->smartylib->assign('title', 'Confirmation successfull!');
			$this->_display('booking_confirm_success.tpl');	
		}
		else {
			$this->smartylib->assign('title', 'Confirmation failed!');
			$this->_display('booking_confirm_error.tpl');	
		}
	}
	
	private function _display($module) {
		$this->smartylib->display('header.tpl');
		$this->smartylib->display('menu.tpl');
		$this->smartylib->display('booking/'.$module);
		$this->smartylib->display('footer.tpl');
	}

}

?>