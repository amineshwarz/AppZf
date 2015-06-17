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

	public function getClient($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveClient(Client $client)
	{
		$data = array(
				'nom' => $client->nom,
				'prenom'  => $client->prenom,
				'email'  => $client->email,
				'societe'  => $client->societe,
				'telephone'  => $client->telephone,
		);

		$id = (int) $client->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getClient($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Client id does not exist');
			}
		}
	}

	public function deleteClient($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}