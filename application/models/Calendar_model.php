<?php

class Calendar_Model extends CI_Model
{
    public function get_events($start, $end)
{
    return $this->db->where("start >=", $start)->where("end <=", $end)->get("calendar_events");
}

public function add_event($data)
{
    $this->db->insert("calendar_events", $data);
}

public function get_event($id)
{
    return $this->db->where("ID", $id)->get("calendar_events");
}

public function update_event($param)
{
    $updateArray = array(
        'start' => $param['start'],
        'end' =>  $param['end']
    );

    $this->db->where('id',$param['id']);
    $this->db->update('event',$updateArray);
    
    if($this->db->affected_rows() == 1) {
        return 1;
    }else{
        return 0;
    }
    }

    //$this->db->where("ID", $id)->update("calendar_events", $data);

    public function delete_event($id)
    {
        $this->db->where("ID", $id)->delete("calendar_events");
    }
}

?>