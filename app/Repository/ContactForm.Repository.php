<?php

require_once ('../Abstraction/ContactForm.Abstraction.php');

/**
 * Repository
 *
 */
//namespace Repository;

class Repository EXTENDS Abstraction\ContactForm
{
	private $connection;

	public function __construct(PDO $connection=null) {

		//TODO: Move to config file.
		$this->connection = $connection;

		if($this->connection === null) {
			$this->connection = new PDO(
				'mysql:host=localhost;dbname=lifeblue',
				'root',
				'secret'
			);

			$this->connection->setAttribute(
				PDO::ATTR_ERRMODE,
				PDO::ERRMODE_EXCEPTION
			);
		}
	}

	public function Find(Abstraction\ContactForm $data)
	{
		if(is_object($data)) {
			$id = $data->id;
		}

		$Query = $this->connection->prepare('
            SELECT *
            WHERE `id` = :id
        ');

		//TODO: implement $data->id, $data->ReferenceID
		$Query->bindParam(':id', $id);
		$Query->execute();
		$Query->setFetchMode(PDO::FETCH_CLASS, '\Abstraction\ContactForm');

		return $Query->fetch();
	}

	public function Save(Abstraction\ContactForm $data)
	{
		if(is_object($data)) {

			if(isset($data->id))
				return $this->Update($data);

			//The below could be re-written to automatically assign params
			// and values based on abstraction properties.
			$Query = $this->connection->prepare('
                INSERT INTO `FormAcquisitions`
                  (name, email, phone, acquisition_method, budget)
                VALUES
                  (:name, :email, :phone, :acquisition_method, :budget)
            ');

			$Query->bindParam(':name', $data->name);
			$Query->bindParam(':email', $data->email);
			$Query->bindParam(':phone', $data->phone);
			$Query->bindParam(':acquisition_method', $data->acquisition_method);
			$Query->bindParam(':budget', $data->budget);

			if($Query->execute())
				return $this->connection->lastInsertId();
		}
	}

	public function Update(Abstraction\ContactForm $data)
	{
		if(is_object($data)) {

			if(!isset($data->id))
				throw new \LogicException('Cannot update, id not present in DB');

			$Query = $this->connection->prepare('
                UPDATE `table` SET
                  name = :name
                  email = :email
                  phone = :phone
                  acquisition_method = :acquistion_method
                  budget = :budget
                WHERE
                  id = :id
            ');

			$Query->bindParam(':id', $data->id);
			$Query->bindParam(':name', $data->name);
			$Query->bindParam(':email', $data->email);
			$Query->bindParam(':phone', $data->phone);
			$Query->bindParam(':acquisition_method', $data->acquisition_method);
			$Query->bindParam(':budget', $data->budget);

			return $Query->execute();
		}
	}
}