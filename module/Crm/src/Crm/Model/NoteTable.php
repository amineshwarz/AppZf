<?php
namespace Crm\Model;

use Zend\Db\TableGateway\TableGateway;

class ClientTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getNote($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id_note' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveClient(Note $note)
	{
		$data = array(
				'id_note' 			=> $note->id_note,
				'id_client' 	 	=> $note->id_client,
				'note'					=> $note->note,

		);

		$id = (int) $note->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getNote($id)) {
				$this->tableGateway->update($data, array('id_note' => $id));
			} else {
				throw new \Exception('Client id does not exist');
			}
		}
	}

	public function deleteNote($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}