<?php

class Booking extends CI_Model {
	function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
	
	function get_all_events() {
		$query = $this->db->query("SELECT * FROM events");
		foreach ($query->result() as $row)
		{
			$data[$row->id] = $row;
		}
		return $data;
	}
	
	function get_event($id) {
		$query = $this->db->query("SELECT * FROM events WHERE id = ?;", array($id));
		return $query->first();
	}
	
	function get_open_events() {
		$this->db->query("SELECT * FROM events WHERE closed = 0");
		foreach ($query->result() as $row)
		{
			$data[$row->id] = $row;
		}
		return $data;
	}
	
	function add_event($name, $desctiption, $image) {
		$this->db->query("INSERT INTO events(name, description, image) VALUES('".$name."', '".$desctiption."', '".$image."');");	
	}
	
	function get_event_name($event) {
		$query = $this->db->query("SELECT events.name FROM events WHERE id = ?;", array($event));
		if($query->num_rows() < 1) {
			$name="";
		}
		else
		{
			$name = $row = $query->first_row()->name;
		}		
		return $name;		
	}
	
	function get_departures($event) {
		$sql = "SELECT
			routes.id as id,
			routes.event as event,
			routes.airline as airline,
			routes.flightnumber as flight,
			routes.aircraft as aircraft,
			routes.from,
			routes.to,
			routes.dep_time as dtime,
			routes.arr_time as atime,
			routes.gate,
			booking.id as booking_id,
			booking.vid,
			booking.email,
			booking.confirmed,
			a1.country_iso as iso1,
			a1.name as name1,
			a1.country as country1,
			a1.city as city1,
			a2.country_iso as iso2,
			a2.name as name2,
			a2.country as country2,
			a2.city as city2
			FROM routes LEFT JOIN booking ON routes.id = booking.route
			LEFT JOIN airports as a1 ON a1.icao=routes.from
			LEFT JOIN airports as a2 ON a2.icao=routes.to
			WHERE routes.event = ? AND routes.arrival = 0 ORDER BY dtime, a1.id, a2.id;";
		$query = $this->db->query($sql, array($event));
		foreach ($query->result() as $row)
		{
			$data[$row->id] = $row;
		}
		return $data;
	}
	
	function get_arrivals($event) {
		$sql = "SELECT
			routes.id as id,
			routes.event as event,
			routes.airline as airline,
			routes.flightnumber as flight,
			routes.aircraft as aircraft,
			routes.from,
			routes.to,
			routes.dep_time as dtime,
			routes.arr_time as atime,
			routes.gate,
			booking.id as booking_id,
			booking.vid,
			booking.email,
			booking.confirmed,
			a1.country_iso as iso1,
			a1.name as name1,
			a1.country as country1,
			a1.city as city1,
			a2.country_iso as iso2,
			a2.name as name2,
			a2.country as country2,
			a2.city as city2
			FROM routes LEFT JOIN booking ON routes.id = booking.route
			LEFT JOIN airports as a1 ON a1.icao=routes.from
			LEFT JOIN airports as a2 ON a2.icao=routes.to
			WHERE routes.event = ? AND routes.arrival = 1 ORDER BY atime, a1.id, a2.id;";
		$query = $this->db->query($sql, array($event));
		foreach ($query->result() as $row)
		{
			$data[$row->id] = $row;
		}
		return $data;
	}
	
	function get_route($id) {
		$sql = "SELECT
			routes.id as id,
			routes.event as event,
			routes.airline as airline,
			routes.flightnumber as flight,
			routes.aircraft as aircraft,
			routes.from,
			routes.to,
			routes.dep_time as dtime,
			routes.arr_time as atime,
			routes.gate,
			booking.id as booking_id,
			booking.vid,
			booking.email,
			booking.confirmed,
			a1.country_iso as iso1,
			a1.name as name1,
			a1.country as country1,
			a1.city as city1,
			a2.country_iso as iso2,
			a2.name as name2,
			a2.country as country2,
			a2.city as city2
			FROM routes
			LEFT JOIN airports as a1 ON a1.icao=routes.from
			LEFT JOIN airports as a2 ON a2.icao=routes.to
			LEFT JOIN booking ON routes.id = booking.route WHERE routes.id = ?;";
		$query = $this->db->query($sql, array($id));
		if ($query->num_rows() == 1) {
			$data = $query->first_row();
		}
		return $data;			
	}
	
	function add_booking($rid, $vid, $email) {
		$code = $email.$vid.rand();
		$code = md5($code);
		$sql = "INSERT INTO booking(route, vid, email, confirmed, code)
			VALUES(?, ?, ?, 0, ?);";
		$this->db->trans_begin();
		$query = $this->db->query($sql, array($rid, $vid, $email, $code));
		if($this->db->trans_status() === TRUE) {
			$id = $this->db->insert_id();
			$this->load->library('email');
			$this->email->from($this->config->item('email'), $this->config->item('email'));
			$this->email->to($email); 
			
			$this->email->subject('IVAO Booking confirmation');
			$this->email->message('You have book a flight. Please, confirm your booking request! ID '.$id.' CODE '.$code);	
			
			//if($this->email->send())
			{
				$this->db->trans_commit();
				return true;
			}			
		}
		$this->db->trans_rollback();
		return false;
	}
	
	function confirm_booking($id, $code) {
		$sql = "UPDATE booking SET
		    confirmed = 1
			WHERE code = ? AND id = ? AND confirmed = 0;";
		$this->db->query($sql, array($code, $id));	
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		return false;
	}
	
	function is_booked($id) {
		$sql = "SELECT id FROM booking WHERE route = ?";
		$query = $this->db->query($sql, array($id));
		if($query->num_rows() > 0)
			return true;
		return false;
	}
	
	function get_country($icao) {
		$sql = "SELECT
			coutntry_iso
			FROM airports WHERE icao=?;";
		$query = $this->db->query($sql, array($icao));
		if ($query->num_rows() == 1) {
			$data = $query->first_row();
		}
		$iso = strtoupper($data->country_iso);
		return $iso;
	}
	
	function flight_exists($id) {
		$sql = "SELECT
			id
			FROM routes WHERE id=?;";
		$query = $this->db->query($sql, array($id));
		if ($query->num_rows() > 0) {
			return true;
		}
		return false;
	}
}
?>